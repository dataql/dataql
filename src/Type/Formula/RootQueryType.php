<?php

namespace DataQL\Type\Formula;

abstract class RootQueryType extends AbstractFormulaType
{

    abstract protected function root(FormulaContext $context);

    protected function configure(FormulaContext $context)
    {
        $this->root($context);
    }


}