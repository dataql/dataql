<?php

namespace DataQL\Process\Walker;

use DataQL\Input\InputNode;
use DataQL\Type\Object\Context\ObjectField;

interface IWalkerResolver
{

	/**
	 * @return InputNode
	 */
	public function getInput();

	/**
	 * @param ObjectField $field
	 * @return mixed
	 */
	public function resolve(ObjectField $field);

}
