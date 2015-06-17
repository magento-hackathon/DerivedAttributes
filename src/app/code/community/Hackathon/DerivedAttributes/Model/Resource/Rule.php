<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

class Hackathon_DerivedAttributes_Model_Resource_Rule
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct(){
        $this->_init("derivedattributes/rule", "rule_id");
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $object->setStoreId(explode(',', $object->getStoreId()));
        return parent::_afterLoad($object);
    }


    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $object->setStoreId(join(',', (array)$object->getStoreId()));
        return parent::_beforeSave($object);
    }

}