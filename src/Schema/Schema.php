<?php

namespace DataQL\Schema;

use DataQL\Type\Formula\RootQueryType;

class Schema
{

    /** @var RootQueryType */
    private $root;

    /**
     * @param RootQueryType $root
     */
    public function __construct(RootQueryType $root)
    {
        $this->root = $root;
        $this->root->attach();
    }

    /**
     * @return RootQueryType
     */
    public function getRoot()
    {
        return $this->root;
    }


}