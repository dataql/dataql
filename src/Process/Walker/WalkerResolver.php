<?php

namespace DataQL\Process\Walker;

use DataQL\Type\AbstractType;

final class WalkerResolver extends AbstractWalkerResolver
{

	/**
	 * @param AbstractType $type
	 * @return mixed
	 */
	public function resolve(AbstractType $type)
	{
		$stop();
	}

}
