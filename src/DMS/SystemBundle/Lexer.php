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
        '/^(\ )+/'                                  =>      'T_WHITESPACE',
        '/^([0-9])+(.([0-9])+)?/'                   =>      'T_VALUES',
        // Trigo
        '/^sin\((.+)\)/U'                           =>      'T_SIN',
        '/^cos\((.+)\)/U'                           =>      'T_COS',
        '/^tan\((.+)\)/U'                           =>      'T_TAN',
        // Special
        '#^sqrt\((.+)(,(.+))?\)#U'                  =>      'T_SQRT',
        '#^ln\((.+)\)#U'                            =>      'T_LN',
        '#^log\((.+)(,(.+))?\)#U'                   =>      'T_LOG',
        // Controlstructures
        '#^for\((\$[A-Za-z]);([0-9]+);([0-9]+)\)#'  =>      'T_FOR_LOOP',
        // Keywords
        '#^Math.PI#'                                =>      'T_MATH_KEYWORD_PI',
        '#^Math.E#'                                 =>      'T_MATH_KEYWORD_E',
        // Variables
        '/^(\$[A-Za-z])+ ?=(.*)$/U'                  =>      'T_VAR_SET',
        '/^(\$[A-Za-z])+/'                          =>      'T_VAR',
        // Math operators
        '/^\+/'                                     =>      'T_PLUS',
        '/^\-/'                                     =>      'T_MINUS',
        '/^\*/'                                     =>      'T_MULTIPLICATION',
        '/^\:/'                                     =>      'T_DIVISION',
        '/^\//'                                     =>      'T_DIVISION',
        '/^\^\((.+)\)/'                             =>      'T_POW',
        // Logic
        '#^\(#'                                     =>      'T_BLOCK',
        '#^\)#'                                     =>      'T_END_BLOCK',
        '#^\{#'                                     =>      'T_CURL_BLOCK',
        '#^\}#'                                     =>      'T_END_CURL_BLOCK',
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
                    throw new Parser\Exception('Unable to parse line at ' . ($number + 1));
                }
                $offset += strlen($result['match'][0]);
                if ($result['token'] == 'T_WHITESPACE') {
                    continue;
                }
                $tokens[] = $result;
            }
            $tokens[] = array('token' => 'T_NEWLINE');
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
            if (preg_match($pattern, $string, $matches)) {
                return array(
                    'match' => $matches,
                    'token' => $name,
                    'line' => $number+1
                );
            }
        }

        return false;
    }
}