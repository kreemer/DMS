<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Block.php
 * Date: 07.10.13
 * Time: 10:15
 */

namespace DMS\SystemBundle\Token;


class Line
{
    /**
     * @var int
     */
    protected $lineNumber;

    /**
     * @param mixed $lineNumber
     *
     * @return Line
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @var Collection
     */
    protected $parent;

    /**
     * @param Collection $collection
     *
     * @return Line
     */
    public function setParent(Collection $collection)
    {
        $this->parent = $collection;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getParent()
    {
        return $this->parent;
    }

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