<?php

namespace DataQL\Input;

final class InputQuery
{

    /** @var QueryNode */
    private $node;

    /**
     * @param QueryNode $node
     */
    public function __construct(QueryNode $node)
    {
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