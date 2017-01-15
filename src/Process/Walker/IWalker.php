<?php

namespace DataQL\Process\Walker;

interface IWalker
{

	/**
	 * @param AbstractWalkerResolver $walker
	 * @return mixed
	 */
	public function accept(AbstractWalkerResolver $walker);

}
