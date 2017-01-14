<?php

namespace DataQL\Schema;

use DataQL\Process\Type\ITypeResolver;
use DataQL\Type\Object\ObjectType;

class Schema
{

	/** @var ObjectType */
	private $root;

	/**
	 * @param ObjectType $root
	 */
	public function __construct(ObjectType $root)
	{
		$this->root = $root;
	}

	/**
	 * @return ObjectType
	 */
	public function getRoot()
	{
		return $this->root;
	}

	/**
	 * ATTACHING ***************************************************************
	 */

	/**
	 * Build type fields and whole type nested tree
	 *
	 * @return void
	 */
	public function attach(ITypeResolver $typeResolver)
	{
		// @todo AttachManager(TypeResolver)
		$this->root->attach($typeResolver);
	}

}
