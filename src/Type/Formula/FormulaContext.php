<?php

namespace DataQL\Type\Formula;

use DataQL\Type\Formula\Context\Field;

final class FormulaContext
{

    /** @var Field[] */
    protected $fields = [];

    /**
     * @param string $name
     * @param array $config
     */
    public function addRawField($name, array $config)
    {
        $this->fields[$name] = new Field($config);
    }

    /**
     * @param string $name
     * @param Field $field
     */
    public function addField($name, Field $field)
    {
        $this->fields[$name] = $field;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $name
     * @return Field
     */
    public function getField($name)
    {
        return $this->fields[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasField($name)
    {
        return array_key_exists($name, $this->fields);
    }
}