<?php

namespace DataQL\Process\Walker;

use DataQL\Type\AbstractType;

interface IWalkerResolver
{

	/**
	 * @param AbstractType $type
	 * @return mixed
	 */
	public function resolve(AbstractType $type);

}
