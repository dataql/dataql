<?php

namespace DataQL\Type\Scalar;

class StringType extends AbstractScalarType
{

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
