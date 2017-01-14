<?php

namespace DataQL\Process\Type;

use DataQL\Type\AbstractType;

interface ITypeResolver
{

	/**
	 * @param string $type
	 * @return AbstractType
	 */
	public function create($type);

}
