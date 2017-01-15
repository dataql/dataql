<?php

namespace DataQL\Type\Special;

use DataQL\Type\AbstractType;

class ListOfType extends AbstractType
{

	/** @var AbstractType */
	private $inner;

	/**
	 * @param AbstractType $inner
	 */
	public function __construct(AbstractType $inner)
	{
		$this->inner = $inner;
	}

	/**
	 * @param array $value
	 * @return mixed
	 */
	public function apply($value)
	{
		if (!is_array($value)) {
			throw new \RuntimeException('Value must be array');
		}

		$output = [];
		foreach ($value as $key => $item) {
			$output[$key] = $this->inner->apply($item);
		}

		return $output;
	}

}
