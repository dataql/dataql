<?php

namespace DataQL\Process\Walker;

interface IWalker
{

	/**
	 * @param IWalkerResolver $walker
	 * @return mixed
	 */
	public function accept(IWalkerResolver $walker);

}
