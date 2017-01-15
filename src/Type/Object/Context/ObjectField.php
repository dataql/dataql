<?php

namespace DataQL\Type\Object\Context;

use DataQL\Process\Type\ITypeResolver;
use DataQL\Type\AbstractType;
use DataQL\Type\Object\AttachableType;

final class ObjectField
{

	/** @var string */
	private $name;

	/** @var callable */
	private $resolve;

	/** @var string */
	private $type;

	/** @var AbstractType */
	private $typeImpl;

	/** @var mixed */
	private $values;

	/** @var mixed */
	private $result;

	// Internal ==============

	/** @var bool */
	private $attached = FALSE;

	/** @var bool */
	private $resolved = FALSE;

	/**
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return callable
	 */
	public function getResolve()
	{
		return $this->resolve;
	}

	/**
	 * @param callable $resolve
	 * @return static
	 */
	public function setResolve($resolve)
	{
		$this->resolve = $resolve;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasResolve()
	{
		return $this->resolve !== NULL;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return static
	 */
	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * @return AbstractType
	 */
	public function getTypeImpl()
	{
		return $this->typeImpl;
	}

	/**
	 * @param AbstractType $typeImpl
	 * @return static
	 */
	public function setTypeImpl(AbstractType $type)
	{
		$this->typeImpl = $type;

		return $this;
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
	 * @return static
	 */
	public function setValues($values)
	{
		$this->values = $values;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * @param mixed $result
	 * @return static
	 */
	public function setResult($result)
	{
		$this->result = $result;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isAttached()
	{
		return $this->attached;
	}

	/**
	 * @param ITypeResolver $typeResolver
	 * @return void
	 */
	public function attach(ITypeResolver $typeResolver)
	{
		// Skip already attached field
		if ($this->attached === TRUE) return;

		// Mark as attached
		$this->attached = TRUE;

		// If typeImpl is filled, skip creating instance
		if ($this->typeImpl === NULL) {
			// Create implementation
			$this->setTypeImpl($typeResolver->create($this->getType()));
		}

		// If it is's nested type, propagate into
		if ($this->typeImpl instanceof AttachableType) {
			$this->typeImpl->attach($typeResolver);
		}
	}

}
