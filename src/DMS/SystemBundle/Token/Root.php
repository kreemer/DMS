<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: Root.php
 * Date: 07.10.13
 * Time: 10:29
 */

namespace DMS\SystemBundle\Token;


class Root implements Token
{

    private $tokens = array();

    /**
     * @param Token $token
     *
     * @return Root
     */
    public function addToken(Token $token)
    {
        $this->tokens[] = $token;

        return $this;
    }

    /**
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * delete empty tokens
     *
     * @return void
     */
    public function cleanUp()
    {
        foreach ($this->tokens as $token) {
            $token->cleanUp();
        }

        $toDelete = array();
        foreach ($this->tokens as $key => $token) {
            if ($token->isEmpty()) {
                $toDelete[] = $key;
            }
        }
        foreach ($toDelete as $key) {
            unset ($this->tokens[$key]);
        }
    }
}