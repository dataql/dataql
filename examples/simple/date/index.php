<?php

use DataQL\Input\InputQuery;
use DataQL\Input\Item\DataField;
use DataQL\Input\Item\NodeField;
use DataQL\Input\QueryNode;
use DataQL\Process\Processor;
use DataQL\Schema\Schema;
use DataQL\Type\Formula\FormulaContext;
use DataQL\Type\Formula\QueryType;
use DataQL\Type\Formula\RootQueryType;
use DataQL\Type\Types;

require_once __DIR__ . '/../../../vendor/autoload.php';

final class DateQueryType extends QueryType
{

    protected function configure(FormulaContext $context)
    {
        $context->addRawField('day', [
            'type' => Types::string(),
        ]);
        $context->addRawField('month', [
            'type' => Types::string(),
        ]);
        $context->addRawField('year', [
            'type' => Types::string(),
        ]);
    }

}

final class RootType extends RootQueryType
{

    protected function root(FormulaContext $context)
    {
        $context->addRawField('date', [
            'type' => new DateQueryType(),
            'resolve' => function () {
                return [
                    'day' => date('d'),
                    'month' => date('m'),
                    'year' => date('y')
                ];
            }
        ]);

        $context->addRawField('echo', [
            'type' => Types::string(),
            'resolve' => function () {
                return 'Hi!';
            }
        ]);
    }

}

$root = new RootType();
$schema = new Schema(new RootType());

$dateNode = new QueryNode();
$dateNode->addField(new DataField('day'));

$nodeRoot = new QueryNode();
$nodeRoot->addField(new NodeField('date', $dateNode));
$input = new InputQuery($nodeRoot);

$processor = new Processor();
$data = $processor->process($schema, $input);

var_dump($data);