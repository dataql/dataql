<?php

namespace DataQL\Type\Scalar;

use DataQL\Process\Walker\IWalkerResolver;

class StringType extends AbstractScalarType
{

	public function accept(IWalkerResolver $walker)
	{
		$stop();    // TODO: Implement accept() method.
	}


	/**
	 * @param mixed $value
	 * @return string
	 */
	public function apply($value)
	{
		if (!is_string($value)) {
			throw new \RuntimeException('Value is not string');
		}

		return strval($value);
	}

}
