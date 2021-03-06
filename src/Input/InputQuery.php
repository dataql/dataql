<?php

namespace DataQL\Input;

final class InputQuery
{

	/** @var InputNode */
	private $node;

	/**
	 * @param InputNode $node
	 */
	public function __construct(InputNode $node)
	{
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
