<?php

namespace DataQL\Type\Object;

use DataQL\Type\Object\Context\ObjectContext;

class ObjectType extends AbstractObjectType
{

	/** @var array */
	private $config;

	/**
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @param ObjectContext $context
	 * @return void
	 */
	protected function build(ObjectContext $context)
	{
		foreach ($this->config as $name => $item) {
			$field = $context->add($name);

			if (isset($item['resolve'])) {
				$field->setResolve($item['resolve']);
			}

			if (isset($item['type'])) {
				if (is_object($item['type'])) {
					$field->setTypeImpl($item['type']);
					$field->setType(get_class($item['type']));
				} else {
					$field->setType($item['type']);
				}
			}
		}
	}

}
