<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Collection.php
 * Date: 07.10.13
 * Time: 11:25
 */

namespace DMS\SystemBundle\Token;


abstract class Collection
{
    /**
     * @var array
     */
    protected $lines = array();

    /**
     * @var Collection
     */
    protected $parent;

    /**
     * @var array
     */
    protected $children = array();

    /**
     * @var array
     */
    protected $vars = array();

    /**
     * @param Collection $parent
     *
     * @return Collection
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

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
     * @param array $lines
     *
     * @return Block
     */
    public function setLines($lines)
    {
        foreach ($lines as $line) {
            /** @var $line Line */
            $line->setParent($this);
        }
        $this->lines = $lines;

        return $this;
    }

    /**
     * @param Line $line
     *
     * @return Line
     */
    public function addLine(Line $line)
    {
        $line->setParent($this);
        $this->lines[] = $line;

        return $line;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->lines) == 0 && count($this->children) == 0;
    }

    /**
     * remove empty keywords
     *
     * @return void
     */
    public function cleanUp()
    {
        $toDelete = array();
        foreach ($this->children as $key => $child) {
            $child->cleanUp();
            if ($child->isEmpty()) {
                $toDelete[] = $key;
            }
        }
        foreach ($toDelete as $key) {
            unset ($this->children[$key]);
        }

        $toDelete = array();
        foreach ($this->lines as $key => $token) {
            if ($token->isEmpty()) {
                $toDelete[] = $key;
            }
        }
        foreach ($toDelete as $key) {
            unset ($this->lines[$key]);
        }
    }

    /**
     * @param array $children
     *
     * @return Collection
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(Collection $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $child;
    }


    /**
     * @param string $var
     * @param string $text
     *
     * @return Block
     */
    public function setVar($var, $text)
    {
        $this->vars[$var] = $text;

        return $this;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function getVar($key)
    {
        if (!isset($this->vars[$key])) {
            if ($this->getParent() !== null) {
                return $this->getParent()->getVar($key);
            }
            throw new \Exception('Var (' . $key . ') doesnt exist in this context');
        }

        return $this->vars[$key];
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function hasVar($key)
    {
        if(!isset($this->vars[$key])) {
            if ($this->getParent() !== null) {
                return $this->getParent()->hasVar($key);
            }
            return false;
        }

        return true;
    }
}