<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Parser.php
 * Date: 01.09.13
 * Time: 12:02
 */

namespace DMS\SystemBundle;

use DMS\SystemBundle\Entity\Task;
use DMS\SystemBundle\Parser\Exception;
use DMS\SystemBundle\Parser\Variable;
use DMS\SystemBundle\Token\Block;
use DMS\SystemBundle\Token\Line;
use DMS\SystemBundle\Token\Loop;
use DMS\SystemBundle\Token\Root;

/**
 * Class Parser
 *
 * @package DMS\SystemBundle
 */
class Parser
{

    /**
     * run through all keywords and parse that thing
     *
     * @param $keywords
     *
     * @return array
     */
    static public function run($keywords)
    {
        $tasks = array();
        $rootToken = self::prepareTokens($keywords);
        $tokens = $rootToken->getTokens();
        foreach ($tokens as $step => $token) {
            /** @var $token Token\Collection */
            if ($token instanceof Token\Loop) {
                /** @var $token Token\Loop */
                $u = $token->getStart();
                while($u < $token->getEnd()) {
                    $lines = $token->getLines();
                    foreach ($lines as $line) {
                        $task = new Task();
                        $task->setStep($step);
                        $task->setMath(self::parseLine($line, array($token->getLoopVar() => $u)));
                        $tasks[] = $task;
                    }
                    $u = $u + $token->getStep();
                }
            } else {
                $lines = $token->getLines();
                foreach ($lines as $line) {
                    $task = new Task();
                    $task->setStep($step);
                    $task->setMath(self::parseLine($line));
                    $tasks[] = $task;
                }
            }
        }

        var_dump($tasks); die();

        return $tasks;
    }

    /**
     * prepare the tokens
     *
     * @param $keywords
     *
     * @return Root
     * @throws Parser\Exception
     */
    static public function prepareTokens($keywords)
    {
        $root = new Root();
        $block = new Block();
        $line = new Line();

        $root->addToken($block);
        $block->addLine($line);

        $actualBlock = $block;
        foreach ($keywords as $keyword) {
            switch ($keyword['token']) {
                case 'T_FOR_LOOP':
                    $loop = new Loop('$a', 0, 10, 1);
                    $root->addToken($loop);
                    $line = new Line();
                    $loop->addLine($line);
                    $actualBlock = $loop;
                    break;
                case 'T_CURL_BLOCK':
                    if (!$actualBlock instanceof Loop) {
                        throw new Exception('I should be in a loop, but cant find that thing');
                    }
                    break;
                case 'T_END_CURL_BLOCK':
                    if (!$actualBlock instanceof Loop) {
                        throw new Exception('I should be in a loop, but cant find that thing');
                    }
                    $block = new Block();
                    $line = new Line();

                    $root->addToken($block);
                    $block->addLine($line);

                    $actualBlock = $block;
                    break;
                case 'T_VAR_SET':
                    $actualBlock->addVar($keyword['match'][1], $keyword['match'][2]);
                    break;
                case 'T_NEWLINE':
                    $line = new Line();
                    $actualBlock->addLine($line);
                    break;
                default:
                    $line->addKeyword($keyword);
            }
        }
        $root->cleanUp();

        return $root;
    }

    /**
     * parse line to math equations
     *
     * @param Line  $line
     * @param array $loopVars
     *
     * @return string
     * @throws Parser\Exception
     */
    static protected function parseLine(Line $line, $loopVars = array())
    {
        $keywords = $line->getKeywords();
        $text = '';
        foreach ($keywords as $keyword) {
            echo $keyword['token'];
            switch ($keyword['token']) {
                case 'T_VALUES':
                    $text .= $keyword['match'][0];
                    break;
                case 'T_MULTIPLICATION':
                    $text .= '*';
                    break;
                case 'T_DIVISION':
                    $text .= '/';
                    break;
                case 'T_PLUS':
                    $text .= '+';
                    break;
                case 'T_MINUS':
                    $text .= '-';
                    break;
                case 'T_MATH_KEYWORD_PI':
                    $text .= 'Pi';
                    break;
                case 'T_SIN':
                    $text .= 'sin(' . $keyword['match'][1] . ')';
                    break;
                case 'T_COS':
                    $text .= 'cos(' . $keyword['match'][1] . ')';
                    break;
                case 'T_TAN':
                    $text .= 'tan(' . $keyword['match'][1] . ')';
                    break;
                case 'T_VAR':
                    $vars = $line->getParent()->getVars();
                    if (array_key_exists($keyword['match'][1], $vars)) {
                        $text .= $vars[$keyword['match'][1]];
                    } elseif(array_key_exists($keyword['match'][1], $loopVars)) {
                        $text .= $loopVars[$keyword['match'][1]];
                    } else {
                        throw new Exception('Var (' . $keyword['match'][1] . ') not recognized');
                    }
                    break;
                default:
                    throw new Exception('Unrecognized keyword (' . $keyword['token'] . ')');
            }
        }

        return $text;
    }

    /**
     * replace the variables within the tasks
     *
     * @param       $tasks
     * @param array $vars
     *
     * @return void
     */
    static protected function replaceVars($tasks, $vars = array())
    {
        foreach ($tasks as $task) {
            foreach ($vars as $name => $value) {
                $task->setMath(str_replace($name, $value, $task->getMath()));
            }
        }
    }
}