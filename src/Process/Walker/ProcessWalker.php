<?php

namespace DataQL\Process\Walker;

use DataQL\Input\InputNode;
use DataQL\Type\Object\AbstractObjectType;
use DataQL\Type\Object\Context\ObjectField;

final class ProcessWalker extends AbstractResolver
{

	/**
	 * @param AbstractObjectType $type
	 * @param InputNode $input
	 * @return mixed
	 */
	public function process(AbstractObjectType $type, InputNode $input)
	{
		$resolveContext = new ResolverContext();
		$typeContext = $type->getContext();

		$data = [];

		// Iterate over all fields (1st level) in input
		foreach ($input->getFields() as $item) {
			// Validate that requested field is present on type
			if (!$typeContext->hasField($item->getName())) {
				throw new \RuntimeException(sprintf('Nested field "%s" not found', $item->getName()));
			}

			// Get field from type
			$field = $typeContext->getField($item->getName());

			// Resolve field/object
			$this->resolve(
				$type,
				$field,
				$input,
				$resolveContext
			);

			$data[$item->getName()] = $field->getResult();
		}

		return $data;
	}

	/**
	 * RESOLVING ***************************************************************
	 */

	/**
	 * @param AbstractObjectType $type
	 * @param ObjectField $field
	 * @param InputNode $input
	 * @param ResolverContext $context
	 * @return mixed
	 */
	protected function resolveField(AbstractObjectType $type, ObjectField $field, InputNode $input, ResolverContext $context)
	{
		$callback = $field->getResolve();

		if ($callback !== NULL) {
			$result = $callback();
			$field->setResult($result);

			return $result;
		}

		$values = $type->getContext()->getValues();

		if (!isset($values[$field->getName()])) {
			throw new \RuntimeException('No values for field');
		}

		$field->setResult($values[$field->getName()]);

		return $values[$field->getName()];
	}

	/**
	 * @param AbstractObjectType $type
	 * @param ObjectField $field
	 * @param InputNode $input
	 * @param ResolverContext $context
	 * @return mixed
	 */
	protected function resolveObject(AbstractObjectType $type, ObjectField $field, InputNode $input, ResolverContext $context)
	{
		$callback = $field->getResolve();

		if ($callback === NULL) {
			throw new \RuntimeException('Resolve callback is needed for nested types');
		}

		$field->setValues($callback());
		$typeImpl = $field->getTypeImpl();

		// Check if nested type is a object
		if (!($typeImpl instanceof AbstractObjectType)) {
			throw new \RuntimeException('No object type');
		}

		$typeImpl->getContext()->setValues($field->getValues());

		$result = $this->process(
			$typeImpl,
			$input->getNodeInput($field->getName())
		);

		$field->setResult($result);

		return $result;
	}
}
