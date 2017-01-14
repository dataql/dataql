<?php

namespace DataQL\Process\Type;

final class InstanceResolver implements ITypeResolver
{

	/**
	 * @param string $type
	 * @return object
	 */
	public function create($type)
	{
		return new $type();
	}

}
