<?php
namespace Hackathon\DerivedAttributes\Service\Generator;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class TemplateGenerator implements GeneratorInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Template';
    const DESCRIPTION = 'Template that contains other product attributes';

    private $data;

    /**
     * @param string $data
     * @return $this
     */
    public function configure($data)
    {
        $this->data = $data;
        // TODO: Implement configure() method.
        return $this;
    }

    /**
     * @internal used to test instantiation
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

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