<?php

namespace DataQL\Process;

use DataQL\Input\InputQuery;
use DataQL\Input\Item\Field;
use DataQL\Input\QueryNode;
use DataQL\Schema\Schema;
use DataQL\Type\Formula\AbstractFormulaType;
use DataQL\Type\Scalar\AbstractScalarType;

class Processor
{

    /**
     * @param Schema $schema
     * @param InputQuery $input
     * @return mixed
     */
    public function process(Schema $schema, InputQuery $input)
    {
        return $this->resolveNode($schema->getRoot(), $input->getNode());
    }

    /**
     * @param AbstractFormulaType $type
     * @param QueryNode $node
     * @return mixed
     */
    protected function resolveNode(AbstractFormulaType $type, QueryNode $node)
    {
        $data = [];

        foreach ($node->getFields() as $inputField) {
            if (!$type->hasField($inputField->getName())) {
                throw new \RuntimeException(sprintf('Field "%s" not found', $inputField->getName()));
            }

            $field = $type->getField($inputField->getName());
            $fieldType = $field->getType();

            if ($fieldType instanceof AbstractScalarType) {
                $data[$inputField->getName()] = $this->resolveField($inputField, $type, $node);
            } else if ($fieldType instanceof AbstractFormulaType) {
                $data[$inputField->getName()] = $this->resolveNode($fieldType, $inputField->getNode());
            } else {
                throw new \RuntimeException('Unsupported type');
            }
        }

        return $data;
    }

    /**
     * @param Field $field
     * @param AbstractFormulaType $type
     * @param QueryNode $formula
     * @return mixed
     */
    protected function resolveField(Field $field, AbstractFormulaType $type, QueryNode $formula)
    {
        $resolve = $type->getField($field->getName())->getCallback();

        return $resolve();
    }


}