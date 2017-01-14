<?php
namespace DataQL\Type\Object;

use DataQL\Process\Type\ITypeResolver;

interface AttachableType
{

	/**
	 * Attach (touch) type and configure fields
	 *
	 * @param ITypeResolver $typeResolver
	 * @return void
	 */
	public function attach(ITypeResolver $typeResolver);

}
