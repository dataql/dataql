<?php

namespace DataQL\Process;

use DataQL\Input\InputNode;
use DataQL\Input\InputQuery;
use DataQL\Process\Resolver\ProcessResolver;
use DataQL\Process\Type\ITypeResolver;
use DataQL\Schema\Schema;
use DataQL\Type\Object\AbstractObjectType;

class Processor
{

	/** @var ProcessResolver */
	private $walker;

	/** @var ITypeResolver */
	private $typeResolver;

	/**
	 * @param ProcessResolver $walker
	 * @param ITypeResolver $typeResolver
	 */
	public function __construct(ProcessResolver $walker, ITypeResolver $typeResolver)
	{
		$this->walker = $walker;
		$this->typeResolver = $typeResolver;
	}

	/**
	 * @param Schema $schema
	 * @param InputQuery $input
	 * @return mixed
	 */
	public function process(Schema $schema, InputQuery $input)
	{
		// @throw ProcessException
		return $this->walk($schema->getRoot(), $input->getNode());
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function validate(Schema $schema)
	{
		// @throw ValidationException
		$schema->attach($this->typeResolver);
	}

	/**
	 * @param AbstractObjectType $type
	 * @param InputNode $input
	 * @return mixed
	 */
	protected function walk(AbstractObjectType $type, InputNode $input)
	{
		return $this->walker->process($type, $input);
	}

}
