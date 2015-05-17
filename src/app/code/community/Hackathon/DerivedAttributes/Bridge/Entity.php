<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\Attribute;

/**
 * Entity implementation of entity-bridge-interface.
 */
class Hackathon_DerivedAttributes_Bridge_Entity implements \Hackathon\DerivedAttributes\BridgeInterface\EntityInterface
{
    /**
     * @var Mage_Core_Model_Abstract
     */
    private $entity;

    public function __construct(Mage_Core_Model_Abstract $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return boolean
     */
    public function isChanged()
    {
        return $this->entity->hasDataChanges();
    }

    /**
     * @param Attribute $attribute
     * @return mixed
     */
    public function getAttributeValue(Attribute $attribute)
    {
        return $this->entity->getData($attribute->getAttributeCode());
    }

    /**
     * @param Attribute $attribute
     * @return string
     */
    public function getLocalizedAttributeValue(Attribute $attribute)
    {
        if ($value = $this->entity->getAttributeText($attribute->getAttributeCode()) !== false ) return $value;
        else return $this->entity->getData($attribute->getAttributeCode());
    }

    /**
     * @param Attribute $attribute
     * @param mixed $value
     * @return void
     */
    public function setAttributeValue(Attribute $attribute, $value)
    {
        $this->entity->setData($attribute->getAttributeCode(), $value);
    }

    /**
     * Sets raw data from database
     *
     * @param string[] $data
     * @return void
     */
    public function setRawData($data)
    {
        $this->entity->addData($data);
    }

    /**
     * Save changed attribute values in database
     *
     * @return void
     */
    public function saveAttributes()
    {
        $resource = $this->entity->getResource();
        $resource->isPartialSave(true);
        $resource->save($this->entity);
    }

    /**
     * Reset to empty instance
     *
     * @return void
     */
    public function clearInstance()
    {
        $this->entity->clearInstance();
    }

    /**
     * Returns collection iterator
     *
     * @return Hackathon_DerivedAttributes_Bridge_EntityIterator
     */
    public function getCollectionIterator()
    {
        $collection = $this->entity->getCollection();
        $iterator = new Hackathon_DerivedAttributes_Bridge_EntityIterator($collection);
        return $iterator;
    }

}
