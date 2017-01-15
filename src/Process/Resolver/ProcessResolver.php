<?php

namespace DataQL\Process\Resolver;

use DataQL\Input\InputNode;
use DataQL\Process\Walker\ResolverContext;
use DataQL\Process\Walker\WalkerResolver;
use DataQL\Type\Object\AbstractObjectType;
use DataQL\Type\Object\Context\ObjectField;

final class ProcessResolver
{

	/**
	 * @param AbstractObjectType $type
	 * @param InputNode $input
	 * @return mixed
	 */
	public function process(AbstractObjectType $type, InputNode $input)
	{

		$walker = new WalkerResolver($type, $input);
		$data = $type->accept($walker);

		return $data;
		//


//		$data = [];
//		$typeContext = $type->getContext();
//
//		// Iterate over all fields (1st level) in input
//		foreach ($input->getFields() as $item) {
//			// Validate that requested field is present on type
//			if (!$typeContext->hasField($item->getName())) {
//				throw new \RuntimeException(sprintf('Nested field "%s" not found', $item->getName()));
//			}
//
//			// Get field from type
//			$field = $typeContext->getField($item->getName());
//
//			$data[$item->getName()] = $field->getResult();
//		}
//
//		return $data;
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
		$stop();
		$walker = new WalkerResolver($type, $field, $input);
		$field->getTypeImpl()->accept($walker);
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
		$stop();
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
