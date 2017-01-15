<?php

namespace DataQL\Process\Walker;

use DataQL\Type\AbstractType;
use DataQL\Type\Object\Context\ObjectField;

final class FieldWalkerResolver implements IWalkerResolver
{

	/** @var AbstractWalkerResolver */
	private $walker;

	/** @var ObjectField */
	private $field;

	/**
	 * @param AbstractWalkerResolver $walker
	 * @param ObjectField $field
	 */
	public function __construct(AbstractWalkerResolver $walker, ObjectField $field)
	{
		$this->walker = $walker;
		$this->field = $field;
	}

	/**
	 * @param AbstractType $type
	 * @return mixed
	 */
	public function resolve(AbstractType $type)
	{
		$callback = $this->field->getResolve();

		if ($callback !== NULL) {
			// Fetch data from callback
			$result = $callback();

			// Apply to given type
			$result = $type->apply($result);

			// Store result to field
			$this->field->setResult($result);

			return $result;
		}

		$stop();
		$values = $this->object->getContext()->getValues();

		if (!isset($values[$this->field->getName()])) {
			throw new \RuntimeException('No values for field');
		}

		$this->field->setResult($values[$this->field->getName()]);
	}

}
