<?php

namespace DataQL\Input;

use DataQL\Input\Item\Filter;
use DataQL\Input\Item\Limit;
use DataQL\Input\Item\NestedField;
use DataQL\Input\Item\Order;
use DataQL\Input\Item\StdField;

final class InputNode
{

	/** @var StdField[] */
	private $fields = [];

	/** @var Filter[] */
	private $filters = [];

	/** @var Order[] */
	private $orders = [];

	/** @var Limit[] */
	private $limits = [];

	/**
	 * @param StdField $field
	 * @return void
	 */
	public function addField(StdField $field)
	{
		$this->fields[$field->getName()] = $field;
	}

	/**
	 * @return StdField[]
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param string $name
	 * @return InputNode
	 */
	public function getNodeInput($name)
	{
		if (!isset($this->fields[$name])) {
			throw new \RuntimeException('No node found');
		}

		/** @var NestedField $nested */
		$nested = $this->fields[$name];

		return $nested->getNode();
	}

	/**
	 * @param Filter $filter
	 * @return void
	 */
	public function addFilter(Filter $filter)
	{
		$this->filters[] = $filter;
	}

	/**
	 * @param Order $order
	 * @return void
	 */
	public function addOrder(Order $order)
	{
		$this->orders[] = $order;
	}

	/**
	 * @param Limit $limit
	 * @return void
	 */
	public function addLimit(Limit $limit)
	{
		$this->limits[] = $limit;
	}

}
