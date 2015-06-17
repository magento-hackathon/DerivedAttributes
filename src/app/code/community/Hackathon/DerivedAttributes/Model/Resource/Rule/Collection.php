<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

/**
 *
 */
class Hackathon_DerivedAttributes_Model_Resource_Rule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    //TODO move Hackathon_DerivedAttributes_Model_Rule so that it cannot be instantiated with Mage::getModel()
    // it should only ever be instantiated by resource model and collection
    protected $_itemObjectClass = 'Hackathon_DerivedAttributes_Model_Rule';
    protected function _construct()
    {
        $this->_init(null, 'derivedattributes/rule');
    }
}
