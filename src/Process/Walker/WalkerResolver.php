<?php

namespace DataQL\Process\Walker;

use DataQL\Input\InputNode;
use DataQL\Type\AbstractType;
use DataQL\Type\Object\AbstractObjectType;
use DataQL\Type\Object\Context\ObjectField;

final class WalkerResolver implements IWalkerResolver
{

	/** @var AbstractObjectType */
	private $object;

	/** @var InputNode */
	private $input;

	/**
	 * @param AbstractObjectType $object
	 * @param InputNode $input
	 */
	public function __construct(AbstractObjectType $object, InputNode $input)
	{
		$this->object = $object;
		$this->input = $input;
	}

	/**
	 * @return AbstractObjectType
	 */
	public function getObject()
	{
		return $this->object;
	}

	/**
	 * @return InputNode
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * @param ObjectField $field
	 * @return mixed
	 */
	public function resolve(ObjectField $field)
	{
		$callback = $field->getResolve();

		if ($callback !== NULL) {
			// Fetch data from callback
			$result = $callback();

			// Apply to given type
			$result = $field->getTypeImpl()->apply($result);

			// Store result to field
			$field->setResult($result);

			return $result;
		}

		$values = $this->object->getContext()->getValues();

		if (!isset($values[$field->getName()])) {
			throw new \RuntimeException('No values for field');
		}

		$field->setResult($values[$field->getName()]);
	}

}
