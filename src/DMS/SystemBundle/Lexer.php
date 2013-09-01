<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Lexer.php
 * Date: 01.09.13
 * Time: 12:16
 */

namespace DMS\SystemBundle;

/**
 * Class Lexer
 *
 * @package DMS\SystemBundle
 */
class Lexer
{
    protected static $terminals = array(
        '/^(\ )+/'                          =>      'T_WHITESPACE',
        '/^([0-9])+/'                       =>      'T_VALUES',
        '/^sin\([A-Za-z0-9]+\)/'                  =>      'T_SIN',
        '/^cos\((A-Za-z0-9)+\)/'                  =>      'T_COS',
        '/^tan\((A-Za-z0-9)+\)/'                  =>      'T_TAN',
        '#^for\([A-Za-z];[0-9]+;[0-9]+\)#'   =>      'T_FOR_LOOP',
        '/^(\[A-Za-z])+/'                    =>      'T_VAR',
        '/^\+/'                             =>      'T_PLUS',
        '/^\-/'                             =>      'T_MINUS',
        '/^\*/'                             =>      'T_MULTIPLICATION',
        '/^\:/'                             =>      'T_DIVISION',
        '/^\//'                             =>      'T_DIVISION',
        '#^\(#'                             =>      'T_BLOCK',
        '#^\)#'                             =>      'T_END_BLOCK',
        '#^\{#'                             =>      'T_CURL_BLOCK',
        '#^\}#'                             =>      'T_END_CURL_BLOCK',
    );

    /**
     * lex the source
     *
     * @param $source
     *
     * @return array
     * @throws Parser\Exception
     */
    public static function run($source) {
        $tokens = array();

        foreach ($source as $number => $line) {
            $offset = 0;
            while ($offset < strlen($line)) {
                $result = self::match($line, $number, $offset);
                if ($result === false) {
                    throw new Parser\Exception("Unable to parse line at " . ($number + 1) . ".");
                }
                $tokens[] = $result;
                $offset += strlen($result['match']);
            }
        }

        return $tokens;
    }

    /**
     * match the following keyword
     *
     * @param $line
     * @param $number
     * @param $offset
     *
     * @return array|bool
     */
    protected static function match($line, $number, $offset) {
        $string = substr($line, $offset);

        foreach (self::$terminals as $pattern => $name) {
            var_dump($pattern);
            var_dump($string);
            if (preg_match($pattern, $string, $matches)) {
                return array(
                    'match' => isset($matches[1]) ? $matches[1] : $matches[0],
                    'token' => $name,
                    'line' => $number+1
                );
            }
        }

        return false;
    }
}