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
     * @var array
     */
    private $vars = array();

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
     * @return $this
     */
    public function addLine(Line $line)
    {
        $line->setParent($this);
        $this->lines[] = $line;

        return $this;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param string $var
     * @param string $text
     *
     * @return Block
     */
    public function addVar($var, $text)
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
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->lines) == 0;
    }

    /**
     * remove empty keywords
     *
     * @return void
     */
    public function cleanUp()
    {
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
}