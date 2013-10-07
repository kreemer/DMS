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


class Line extends Keyword implements Token
{
    /**
     * @var Block
     */
    protected $parent;

    /**
     * @param Collection $block
     *
     * @return Line
     */
    public function setParent(Collection $block)
    {
        $this->parent = $block;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getParent()
    {
        return $this->parent;
    }
}