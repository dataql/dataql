<?php

namespace DataQL\Input\Item;

final class Limit
{

	/** @var string */
	private $name;

	/** @var mixed */
	private $value;

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

}
