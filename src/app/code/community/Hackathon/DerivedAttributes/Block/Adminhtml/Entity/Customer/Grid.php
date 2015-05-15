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
class Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Get collection object
     * @return Mage_Customer_Model_Entity_Customer_Collection
     */
    public function getCollection()
    {
        if (!parent::getCollection()) {
            $collection = Mage::getResourceModel('customer/customer_collection');
            $this->setCollection($collection);
        }

        return parent::getCollection();
    }

    /**
     * Prepare columns
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => $this->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));
        return parent::_prepareColumns();
    }
}