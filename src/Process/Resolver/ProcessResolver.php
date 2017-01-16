<?php

namespace DataQL\Process\Resolver;

use DataQL\Input\InputNode;
use DataQL\Process\Walker\WalkerResolver;
use DataQL\Type\Object\AbstractObjectType;

final class ProcessResolver
{

	/**
	 * @param AbstractObjectType $type
	 * @param InputNode $input
	 * @return mixed
	 */
	public function process(AbstractObjectType $type, InputNode $input)
	{
		$walker = new WalkerResolver($type, $input);
		$data = $type->accept($walker);

		return $data;
	}


}
