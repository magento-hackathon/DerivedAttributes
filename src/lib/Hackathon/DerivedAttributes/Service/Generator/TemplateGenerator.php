<?php
namespace Hackathon\DerivedAttributes\Service\Generator;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class TemplateGenerator implements GeneratorInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Template';
    const DESCRIPTION = 'Template that contains other product attributes';

    /**
     * @param EntityInterface $product
     * @return mixed
     */
    public function generateAttributeValue(EntityInterface $product)
    {
        // TODO: Implement generateAttributeValue() method.
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return self::TITLE;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return self::DESCRIPTION;
    }

}