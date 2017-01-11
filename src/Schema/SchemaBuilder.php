<?php

namespace DataQL\Schema;

use DataQL\Type\AbstractFormulaType;
use DataQL\Type\MutationType;
use DataQL\Type\QueryType;

class SchemaBuilder
{

    /** @var AbstractFormulaType[] */
    private $types = [];

    private function add(AbstractFormulaType $type)
    {
        $this->types[] = $type;
    }

    public function addQuery(QueryType $query)
    {
        $this->add($query);
    }

    public function addMutation(MutationType $mutation)
    {
        $this->add($mutation);
    }

    public function create() {
        return new Schema($this->types);
    }
}