<?php

namespace DataQL\Process\Walker;

use DataQL\Input\InputNode;
use DataQL\Type\AbstractType;
use DataQL\Type\Object\AbstractObjectType;
use DataQL\Type\Object\Context\ObjectField;
use DataQL\Type\Scalar\AbstractScalarType;

abstract class AbstractResolver
{

	/**
	 * @param AbstractObjectType $type
	 * @param ObjectField $field
	 * @param InputNode $input
	 * @param ResolverContext $context
	 * @return mixed
	 */
	public function resolve(AbstractObjectType $type, ObjectField $field, InputNode $input, ResolverContext $context)
	{
		$typeImpl = $field->getTypeImpl();

		if ($typeImpl instanceof AbstractScalarType) {
			return $this->resolveField($type, $field, $input, $context);
		} else if ($typeImpl instanceof AbstractObjectType) {
			return $this->resolveObject($type, $field, $input, $context);
		} else {
			throw new \RuntimeException('Invalid type');
		}
	}

	/**
	 * @param AbstractType $type
	 * @param ObjectField $field
	 * @param InputNode $input
	 * @param ResolverContext $context
	 * @return mixed
	 */
	abstract protected function resolveField(AbstractObjectType $type, ObjectField $field, InputNode $input, ResolverContext $context);

	/**
	 * @param AbstractObjectType $type
	 * @param ObjectField $field
	 * @param InputNode $input
	 * @param ResolverContext $context
	 * @return mixed
	 */
	abstract protected function resolveObject(AbstractObjectType $type, ObjectField $field, InputNode $input, ResolverContext $context);

}
