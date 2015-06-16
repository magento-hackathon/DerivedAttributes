<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\Attribute;

/**
 * Bridge-entity for rule(s).
 */
class Hackathon_DerivedAttributes_Model_Rule extends Mage_Core_Model_Abstract
{
    
    protected function _construct(){
        $this->_init("derivedattributes/rule");
    }

}
