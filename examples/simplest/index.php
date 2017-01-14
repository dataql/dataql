<?php

use DataQL\Input\InputNode;
use DataQL\Input\InputQuery;
use DataQL\Input\Item\NestedField;
use DataQL\Input\Item\StdField;
use DataQL\Process\Processor;
use DataQL\Process\Type\InstanceResolver;
use DataQL\Process\Walker\ProcessWalker;
use DataQL\Schema\Schema;
use DataQL\Type\Object\Context\ObjectContext;
use DataQL\Type\Object\ObjectType;
use DataQL\Type\Object\QueryType;
use DataQL\Type\Scalar\StringType;
use DataQL\Type\Special\ListOfType;
use Tracy\Debugger;

require_once __DIR__ . '/../../vendor/autoload.php';

Debugger::$strictMode = TRUE;
Debugger::$maxDepth = 10;
Debugger::enable(FALSE);

final class DateQueryType extends QueryType
{

	protected function build(ObjectContext $context)
	{
		$context->add('day')
			->setType(StringType::class);

		$context->add('month')
			->setType(StringType::class)
			->setResolve(function () {
				return 'HOUHOU!';
			});
	}

}

$schema = new Schema(new ObjectType([
	'date' => [
		'type' => DateQueryType::class,
		'resolve' => function () {
			return [
				'day' => date('d'),
				'month' => date('m'),
			];
		},
	],
	'user' => [
		'type' => new ObjectType([
			'name' => [
				'type' => StringType::class,
				'resolve' => function () {
					return sprintf('Felix %s', time());
				},
			],
		]),
		'resolve' => function () {
			// Needed for nested type
		},
	],
	'heroes' => [
		'type' => new ListOfType(new StringType()),
		'resolve' => function () {
			return ['Chuck Norris', 'Felix'];
		},
	],
	'echo' => [
		'type' => StringType::class,
		'resolve' => function () {
			return 'Hi!';
		},
	],
]));


// {date{day,month}}

$dateNode1 = new InputNode();
$dateNode1->addField(new StdField('day'));
$dateNode1->addField(new StdField('month'));

$nodeRoot1 = new InputNode();
$nodeRoot1->addField(new NestedField('date', $dateNode1));
$input1 = new InputQuery($nodeRoot1);


// {echo}

$nodeRoot2 = new InputNode();
$nodeRoot2->addField(new StdField('echo'));
$input2 = new InputQuery($nodeRoot2);


// {user{name}}

$userNode3 = new InputNode();
$userNode3->addField(new StdField('name'));

$nodeRoot3 = new InputNode();
$nodeRoot3->addField(new NestedField('user', $userNode3));
$input3 = new InputQuery($nodeRoot3);


// {heroes}

$nodeRoot4 = new InputNode();
$nodeRoot4->addField(new StdField('heroes'));
$input4 = new InputQuery($nodeRoot4);


$walker = new ProcessWalker();
$typeResolver = new InstanceResolver();
$processor = new Processor($walker, $typeResolver);

$processor->validate($schema);
$data = $processor->process($schema, $input3);
var_dump($data);
