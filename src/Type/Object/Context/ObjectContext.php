<?php

namespace DataQL\Type\Object\Context;

use DataQL\Process\Type\ITypeResolver;

class ObjectContext
{

	/** @var ObjectField[] */
	protected $fields = [];

	/** @var mixed */
	protected $values;

	/**
	 * @param string $name
	 * @return ObjectField
	 */
	public function add($name)
	{
		$field = new ObjectField($name);
		$this->fields[$name] = $field;

		return $field;
	}

	/**
	 * @return ObjectField[]
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param string $name
	 * @return ObjectField
	 */
	public function getField($name)
	{
		if (!$this->hasField($name)) {
			throw new \RuntimeException(sprintf('Field "%s" does not exist', $name));
		}

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

	/**
	 * @return mixed
	 */
	public function getValues()
	{
		return $this->values;
	}

	/**
	 * @param mixed $values
	 */
	public function setValues($values)
	{
		$this->values = $values;
	}

	/**
	 * ATTACHING ***************************************************************
	 */

	/**
	 * Propagate attaching to all fields
	 *
	 * @return void
	 */
	public function attach(ITypeResolver $typeResolver)
	{
		foreach ($this->fields as $field) {
			$field->attach($typeResolver);
		}
	}
}
