<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\Rule;

/**
 * Magento model for rules.
 *
 * Only used internally by resource model
 */
class Hackathon_DerivedAttributes_Model_Rule extends Mage_Core_Model_Abstract
{
    const ALIAS = 'derivedattributes/rule';

    protected function _construct(){
        $this->_init(self::ALIAS);
    }
}
