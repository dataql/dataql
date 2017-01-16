<?php

namespace DataQL\Type;

use DataQL\Process\Walker\IWalker;
use DataQL\Process\Walker\IWalkerResolver;

abstract class AbstractType implements IWalker
{

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	abstract public function apply($value);

}
