<?php

namespace DataQL\Type\Object;

use DataQL\Process\Type\ITypeResolver;
use DataQL\Process\Walker\AbstractWalkerResolver;
use DataQL\Process\Walker\FieldWalkerResolver;
use DataQL\Type\AbstractType;
use DataQL\Type\Object\Context\ObjectContext;

abstract class AbstractObjectType extends AbstractType implements AttachableType, ResolvableType
{

	/** @var ObjectContext */
	protected $context;

	/**
	 * @return ObjectContext
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * ATTACHING ***************************************************************
	 */

	/**
	 * Attach (touch) type and configure fields
	 *
	 * @param ITypeResolver $typeResolver
	 * @return void
	 */
	public function attach(ITypeResolver $typeResolver)
	{
		// Skip already configured object
		if ($this->context) return;

		// Create context for storing fields etc.
		$this->context = new ObjectContext();

		// Fire build method!
		$this->build($this->context);
		$this->context->attach($typeResolver);
	}

	/**
	 * BUILDING (fields + types) ***********************************************
	 */

	/**
	 * @param ObjectContext $context
	 * @return void
	 */
	abstract protected function build(ObjectContext $context);

	/**
	 * RESOLVABLE (fields + data) ************************************************
	 */

	/**
	 * @param mixed $values
	 * @return void
	 */
	public function resolve($values)
	{
		$this->context->setValues($values);
	}

	/**
	 * WALKING *****************************************************************
	 */

	/**
	 * @param AbstractWalkerResolver $walker
	 * @return mixed
	 */
	public function accept(AbstractWalkerResolver $walker)
	{
		$input = $walker->getInput();
		$output = [];

		// Iterate over all fields in input
		foreach ($input->getFields() as $item) {
			// Validate that requested field is present on type
			if (!$this->context->hasField($item->getName())) {
				throw new \RuntimeException(sprintf('Nested field "%s" not found', $item->getName()));
			}

			// Get field from type
			$field = $this->context->getField($item->getName());

			// Resolve field
			$subwalker = new FieldWalkerResolver($walker, $field);
			$subwalker->resolve($field->getTypeImpl());

			$output[$item->getName()] = $field->getResult();
		}

		return $output;
	}

	/**
	 * APPLYING (given raw values) *********************************************
	 */

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function apply($value)
	{
		if (!is_array($value)) {
			throw new \RuntimeException('Values must be array');
		}

		$output = [];

		// Iterate over all fields in input
		foreach ($this->context->getFields() as $name => $field) {
			// Skip not required fields
			if (!array_key_exists($name, $value)) continue;

			// Set result to field
			if ($field->hasResolve()) {
				$output[$name] = call_user_func($field->getResolve());
			} else {
				$output[$name] = $field->getTypeImpl()->apply($value[$name]);
			}
		}

		return $output;
	}


}
