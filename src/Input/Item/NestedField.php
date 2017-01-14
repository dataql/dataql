<?php

namespace DataQL\Input\Item;

use DataQL\Input\InputNode;

final class NestedField extends StdField
{

	/** @var InputNode */
	private $node;

	/**
	 * @param string $name
	 * @param InputNode $node
	 */
	public function __construct($name, InputNode $node)
	{
		parent::__construct($name);
		$this->node = $node;
	}

	/**
	 * @return InputNode
	 */
	public function getNode()
	{
		return $this->node;
	}

}
