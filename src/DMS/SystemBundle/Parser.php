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
    static public function run($keywords) {
        $tasks = array();
        $task = new Task();
        $text = '';
        foreach ($keywords as $key => $keyword) {
            switch ($keyword['token']) {
                case 'T_FOR_LOOP':
                    $forTasks = array();
                    $breakKeywords = array();
                    $forKeywords = array();
                    $state = 0;
                    $out = false;
                    for ($u = $key+1; $u < count($keywords); $u++) {
                        switch ($keywords[$u]['token']) {
                            case 'T_WHITESPACE':
                                $forKeywords[] = $keywords[$u];
                                break;
                            case 'T_CURL_BLOCK':
                                $state++;
                                break;
                            case 'T_END_CURL_BLOCK':
                                $state--;
                                break;
                            default:
                                if ($state > 0 && !$out) {
                                    $forKeywords[] = $keywords[$u];
                                }
                                if ($state == 0) {
                                    $out = true;
                                    $breakKeywords[] = $keywords[$u];
                                }
                        }
                    }
                    for ($i = $keyword['match'][2]; $i <= $keyword['match'][3]; $i++) {
                        $tmpTasks = self::run($forKeywords);
                        foreach ($tmpTasks as $tmpTask) {
                            $content = $tmpTask->getMath();
                            $content = str_replace($keyword['match'][1], $i, $content);
                            $tmpTask->setMath($content);
                            $forTasks[] = $tmpTask;
                        }
                    }
                    $tasks = array_merge($tasks, $forTasks);
                    $tasks = array_merge($tasks, self::run($breakKeywords));

                    return $tasks;
                    break;
                case 'T_WHITESPACE':
                    /** Do nothing */
                    break;
                case 'T_SIN':
                    $task->setMath(trim($task->getMath() . ' sin(' . $keyword['match'][1] . ')'));
                    break;
                case 'T_NEWLINE':
                    $tasks[] = $task;
                    $task = new Task();
                    break;
                default:
                    throw new Parser\Exception('Unrecognized keyword (' . $keyword['token'] . ')');

            }
        }

        return $tasks;
    }
}