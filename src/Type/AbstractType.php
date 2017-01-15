<?php

namespace DataQL\Type;

use DataQL\Process\Walker\AbstractWalkerResolver;
use DataQL\Process\Walker\IWalker;

abstract class AbstractType implements IWalker
{

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	abstract public function apply($value);

	/**
	 * @param AbstractWalkerResolver $walker
	 * @return mixed
	 */
	public function accept(AbstractWalkerResolver $walker)
	{
		return $walker->resolve($this);
	}

}
