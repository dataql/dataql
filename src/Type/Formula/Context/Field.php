<?php

namespace DataQL\Type\Formula\Context;

use DataQL\Type\AbstractType;

final class Field
{
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return AbstractType
     */
    public function getType()
    {
        return $this->config['type'];
    }

    public function getCallback()
    {
        return $this->config['resolve'];
    }


}