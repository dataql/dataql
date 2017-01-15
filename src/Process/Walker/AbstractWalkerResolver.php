<?php

namespace DataQL\Process\Walker;

use DataQL\Input\InputNode;
use DataQL\Type\Object\AbstractObjectType;

abstract class AbstractWalkerResolver implements IWalkerResolver
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

}
