<?php

namespace DataQL\Process\Walker;

use DataQL\Input\InputNode;
use DataQL\Type\AbstractType;

interface IResolver
{

	/**
	 * @param AbstractType $type
	 * @param InputNode $input
	 * @return mixed
	 */
	public function resolve(AbstractType $type, InputNode $input);

}
