<?php
namespace DataQL\Type\Object;

interface ResolvableType
{

	/**
	 * @param mixed $values
	 * @return mixed
	 */
	public function resolve($values);

}
