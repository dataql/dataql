<?php

namespace DataQL\Type;

use DataQL\Type\Scalar\StringType;

final class Types
{

	public static function string()
	{
		return new StringType();
	}

	public static function object()
	{

	}

}
