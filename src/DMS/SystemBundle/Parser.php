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
use DMS\SystemBundle\Lexer;
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
        $root = self::prepareTokens($keywords);
        $tasks = self::runCollection($root);

        return $tasks;
    }

    static protected function runCollection($collection, $step = 0)
    {
        $tasks = array();
        /** @var $collection Token\Collection */
        if ($collection instanceof Token\Loop) {
            /** @var $collection Token\Loop */
            $u = $collection->getStart();
            while($u <= $collection->getEnd()) {
                $lines = $collection->getLines();
                $collection->setVar($collection->getLoopVar(), $u);
                foreach ($lines as $line) {
                    $task = new Task();
                    $task->setStep($step);
                    $text = self::parseLine($line);
                    if ($text != '') {
                        // this line was just a T_VAR_SET
                        $task->setMath($text);
                        $tasks[] = $task;
                    }
                }
                $u = $u + $collection->getStep();
            }
        } else {
            /** @var $collection Token\Block */
            $lines = $collection->getLines();
            foreach ($lines as $line) {
                $task = new Task();
                $task->setStep($step);
                $text = self::parseLine($line);
                if ($text != '') {
                    // this line was just a T_VAR_SET
                    $task->setMath($text);
                    $tasks[] = $task;
                }
            }
        }

        $collections = $collection->getChildren();
        foreach ($collections as $collection) {
            $tasks = array_merge($tasks, self::runCollection($collection, $step++));
        }

        return $tasks;
    }

    /**
     * prepare the tokens
     *
     * @param $keywords
     *
     * @return Token\Collection
     * @throws Parser\Exception
     */
    static public function prepareTokens($keywords)
    {
        $root = $block = new Block();
        $line = new Line();

        $block->addLine($line);

        foreach ($keywords as $keyword) {
            switch ($keyword['token']) {
                case 'T_FOR_LOOP':
                    $block = $block->addChild(
                        new Loop(
                            $keyword['match'][1], $keyword['match'][2], $keyword['match'][3], 1
                        )
                    );
                    $line = new Line();
                    $block->addLine($line);
                    break;
                case 'T_CURL_BLOCK':
                    if (!$block instanceof Loop) {
                        throw new Exception('I should be in a loop, but cant find that thing');
                    }
                    break;
                case 'T_END_CURL_BLOCK':
                    if (!$block instanceof Loop) {
                        throw new Exception('I should be in a loop, but cant find that thing');
                    }
                    $block = $block->getParent();
                    $line = $block->addLine(new Line());
                    break;
                case 'T_NEWLINE':
                    $line = $block->addLine(new Line());
                    break;
                default:
                    $line->addKeyword($keyword);
            }
        }
        $root->cleanUp();

        return $root;
    }

    /**
     * parse a line to math equations
     *
     * @param Line $line
     *
     * @return string
     * @throws Parser\Exception
     */
    static protected function parseLine(Line $line)
    {
        $keywords = $line->getKeywords();
        $text = '';
        foreach ($keywords as $keyword) {
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
                    $text .= 'sin(' . self::parseLineBlock($keyword['match'][1], $line->getParent()) . ')';
                    break;
                case 'T_COS':
                    $text .= 'cos(' . self::parseLineBlock($keyword['match'][1], $line->getParent()) . ')';
                    break;
                case 'T_TAN':
                    $text .= 'tan(' . self::parseLineBlock($keyword['match'][1], $line->getParent()) . ')';
                    break;
                case 'T_VAR_SET':
                    $line->getParent()->setVar(
                        $keyword['match'][1],
                        self::parseLineBlock($keyword['match'][2], $line->getParent())
                    );
                    break;
                case 'T_VAR':
                    $hasVar = $line->getParent()->hasVar($keyword['match'][1]);
                    if (!$hasVar) {
                        throw new Exception('Var (' . $keyword['match'][1] . ') not recognized');
                    }
                    $text .= $line->getParent()->getVar($keyword['match'][1]);
                    break;
                default:
                    throw new Exception('Unrecognized keyword (' . $keyword['token'] . ')');
            }
        }

        return $text;
    }

    /**
     * parse a supblock of a line, like in sin(xy) or $a=xy
     *
     * @param $string
     * @param $parent
     *
     * @return string
     */
    static protected function parseLineBlock($string, $parent)
    {
        $line = new Line();
        $line->setParent($parent);

        $keywords = Lexer::run(array(1 => $string));
        $lastKeyword = end($keywords);
        if ($lastKeyword['token'] == 'T_NEWLINE') {
            array_pop($keywords);
        }
        $line->setKeywords($keywords);

        return self::parseLine($line);
    }
}