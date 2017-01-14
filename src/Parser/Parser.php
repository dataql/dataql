<?php

namespace DataQL\Parser;

use Nette\Utils\TokenIterator;
use Nette\Utils\Tokenizer;

require_once __DIR__ . '/../../vendor/autoload.php';

final class Parser
{

	const T_SPACE = 1;
	const T_SEPARATOR = 2;
	const T_WORD = 3;
	const T_NUMBER = 4;
	const T_MODIFIER = 5;
	const T_VARIABLE = 6;
	const T_QL_FILTERS = 10;
	const T_QL_LIMITS = 11;
	const T_QL_SORTS = 12;
	const T_QL_FIELDS = 13;

	public function parse($t)
	{
		$tokenizer = new Tokenizer([
			self::T_SPACE => '\s',
			self::T_SEPARATOR => ',',
			self::T_WORD => '\w+',
			self::T_NUMBER => '\d+',
			self::T_QL_FILTERS => '\((?:\w+:\d+,?)\)',
			self::T_QL_LIMITS => '\<\d+,?\d+\>',
			self::T_QL_SORTS => '\[(?:[\>\<]+\w+,?)+\]',
			self::T_QL_FIELDS => '\{.+\}',
		]);

		var_dump($tokenizer->tokenize($t));
		$ti = new TokenIterator($tokenizer->tokenize($t));
		while ($ti->nextToken()) {
			$w = $ti->currentValue();
			if ($ti->isCurrent(self::T_WORD)) {
			}
			if ($ti->isCurrent(self::T_QL_FIELDS)) {
				var_dump($w);
				$this->parse(substr($ti->currentValue(), 1, -1));
			}
		}
	}

}

$t = 'photos<0,10>(id:1){id,{moje}}[>id]';
$p = new Parser();
$p->parse($t);
