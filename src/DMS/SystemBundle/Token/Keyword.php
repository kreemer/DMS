<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Token.php
 * Date: 07.10.13
 * Time: 10:16
 */

namespace DMS\SystemBundle\Token;


abstract class Keyword
{
    /**
     * @var array
     */
    private $keywords = array();

    /**
     * @param array $keywords
     *
     * @return Token
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * @param array $keyword
     *
     * @return Token
     */
    public function addKeyword($keyword)
    {
        $this->keywords[] = $keyword;

        return $this;
    }
    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->keywords) == 0;
    }
}