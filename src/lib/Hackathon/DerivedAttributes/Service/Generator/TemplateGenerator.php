<?php
namespace Hackathon\DerivedAttributes\Service\Generator;

use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

class TemplateGenerator implements GeneratorInterface
{
    const __CLASS = __CLASS__;

    const TITLE = 'Template';
    const DESCRIPTION = 'Template that contains other product attributes';

    private $data;
    protected $entity;

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
     * @param EntityInterface $entity
     * @return mixed
     */
    public function generateAttributeValue(EntityInterface $entity)
    {
       return $this->_parseData($entity);
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

    /**
     * Return default value based on configured template
     *
     * @return string
     */
    private function _parseData(EntityInterface $entity)
    {
        $this->entity = $entity;
        $valueTemplate = $this->data;
        $value = preg_replace_callback('~#([\w\-]+)#~', function ($matches) {
            /*
             * getData() for multiselect attribute should be a comma separated string,
             * but something converts it to an array and we need to revert that to make
             * the frontend model work:
             */
            $attr = new Attribute($matches[1]);
            if (is_array($this->entity->getLocalizedAttributeValue($attr))) {
                $this->entity->getLocalizedAttributeValue($attr,
                    join(',', $this->entity->getLocalizedAttributeValue($attr)));
            }
            $_value = $this->entity->getLocalizedAttributeValue($attr);
            return $_value;
        }, $valueTemplate);
        return $value;
    }

}