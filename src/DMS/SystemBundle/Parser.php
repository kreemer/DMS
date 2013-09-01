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
     * parse the content and return all tasks
     *
     * @param $content
     *
     * @return array
     */
    public function parseContent($content) {
        $lines = explode(PHP_EOL, $content);
        $return = array();
        foreach ($lines as $key => $line) {
            $task = new Task();
            $task->setStep($key);
            $task->setMath($line);
            $return[] = $task;
        }

        return $return;
    }

}