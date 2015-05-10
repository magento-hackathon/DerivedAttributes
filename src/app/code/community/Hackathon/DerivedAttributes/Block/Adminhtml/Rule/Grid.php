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
    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }

    /**
     * Get collection object
     * @return Hackathon_DerivedAttributes_Model_Resource_Derivedattributes_Rule_Collection
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
        $this->addColumn('rule_id', array(
            'header'    => $this->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'rule_id',
        ));

        $this->addColumn('name', array(
            'header'    => $this->__('Rule Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('is_active', array(
            'header'    => $this->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('rule_store_id', array(
                'header'    => $this->__('Store'),
                'align'     =>'left',
                'index'     => 'store_id',
                'type'      => 'options',
                'sortable'  => false,
                'options'   => Mage::getSingleton('adminhtml/system_store')->getStoreOptionHash(),
                'width'     => 200,
            ));
        }

        $this->addColumn('priority', array(
            'header'    => $this->__('Priority'),
            'align'     => 'right',
            'index'     => 'priority',
            'width'     => 100,
        ));
        return parent::_prepareColumns();
    }


}