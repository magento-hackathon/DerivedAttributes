<?php
/**
 * This file is part of Hackathon_DerivedAttributes for Magento.
 *
 * @license OSL-3.0
 * @author Fabian Schmengler <fs@integer-net.de> <@fschmengler>
 * @category Hackathon
 * @package Hackathon_DerivedAttributes
 */

/**
 * @package Hackathon_DerivedAttributes
 */
class Hackathon_DerivedAttributes_Block_Adminhtml_Rule_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Get collection object
     * @return Hackathon_DerivedAttributes_Model_Resource_Derivedattributes/rule_Collection
     */
    public function getCollection()
    {
        if (!parent::getCollection()) {
            $collection = Mage::getResourceModel('derivedattributes/rule_collection');
            $this->setCollection($collection);
        }

        return parent::getCollection();
    }

    /**
     * Prepare columns
     * @return Hackathon_DerivedAttributes_Block_Adminhtml_Rule_Grid
     */
    protected function _prepareColumns()
    {
        return parent::_prepareColumns();
    }


}