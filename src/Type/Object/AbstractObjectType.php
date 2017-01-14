<?php

namespace DataQL\Type\Object;

use DataQL\Process\Type\ITypeResolver;
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


}
