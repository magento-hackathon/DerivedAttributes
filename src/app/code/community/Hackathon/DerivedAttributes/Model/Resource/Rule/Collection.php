<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

class Hackathon_DerivedAttributes_Model_Resource_Rule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init(Hackathon_DerivedAttributes_Model_Rule::ALIAS);
    }
}
