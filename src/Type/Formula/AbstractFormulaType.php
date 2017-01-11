<?php

namespace DataQL\Type\Formula;

use DataQL\Type\Formula\Context\Field;
use DataQL\Type\Object\AbstractObjectType;

abstract class AbstractFormulaType extends AbstractObjectType
{

    /** @var FormulaContext */
    protected $context;

    public function getFields()
    {
        return $this->context->getFields();
    }

    public function hasField($name)
    {
        return $this->context->hasField($name);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getFieldType($name)
    {
        return $this->getField($name)->getType();
    }

    /**
     * @param string $name
     * @return Field
     */
    public function getField($name)
    {
        if (!$this->hasField($name)) {
            throw new \RuntimeException(sprintf('Field "%s" does not exist', $name));
        }

        return $this->context->getField($name);
    }

    abstract protected function configure(FormulaContext $context);

    public function attach()
    {
        if ($this->context) {
            throw new \RuntimeException('Invalid attach');
        }

        $this->context = new FormulaContext();
        $this->configure($this->context);

        foreach ($this->context->getFields() as $name => $field) {
            $type = $field->getType();
            if ($type instanceof AbstractFormulaType) {
                $type->attach();
            }
        }
    }

}