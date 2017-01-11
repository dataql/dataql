<?php

namespace DataQL\Type;

use DataQL\Type\Formula\AbstractFormulaType;

class RootType extends AbstractType
{

    /** @var AbstractFormulaType[] */
    private $formulas = [];

    public function add(AbstractFormulaType $formula) {
        $this->formulas[] = $formula;
    }

    public function attach()
    {
        foreach ($this->formulas as $formula) {
            $formula->attach();
        }
    }

}