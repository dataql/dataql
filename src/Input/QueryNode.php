<?php

namespace DataQL\Input;

use DataQL\Input\Item\Field;
use DataQL\Input\Item\Filter;
use DataQL\Input\Item\Limit;
use DataQL\Input\Item\Order;

final class QueryNode
{

    /** @var Field[] */
    private $fields;

    /** @var Filter[] */
    private $filters;

    /** @var Order[] */
    private $orders;

    /** @var Limit[] */
    private $limits;

    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }

    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    public function addLimit(Limit $limit)
    {
        $this->limits[] = $limit;
    }
}