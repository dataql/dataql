<?php

namespace DataQL\Input\Item;

use DataQL\Input\QueryNode;

final class NodeField extends Field
{

    /** @var QueryNode */
    private $node;

    /**
     * @param string $name
     * @param QueryNode $node
     */
    public function __construct($name, QueryNode $node)
    {
        parent::__construct($name);
        $this->node = $node;
    }

    /**
     * @return QueryNode
     */
    public function getNode()
    {
        return $this->node;
    }

}