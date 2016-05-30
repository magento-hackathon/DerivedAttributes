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
class Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productDerivedAttributesGrid');
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_ids');
        $this->getMassactionBlock()->setUseAjax(true);
        $this->setNoFilterMassactionColumn(true);

        $this->getMassactionBlock()->addItem('apply', array(
            'label'=> Mage::helper('catalog')->__('Apply Rules'),
            'url'  => $this->getUrl('*/*/applyRules'),
            'confirm' => Mage::helper('catalog')->__('Are you sure?'),
            'complete' => 'integerNetGridMassActionPager',
            'additional' => $this->_getAdditionalMassactionBlock(),
        ));

        $this->getMassactionBlock()->addItem('dryrun', array(
            'label'=> Mage::helper('catalog')->__('Apply Rules (dry run)'),
            'url'  => $this->getUrl('*/*/applyRules'),
            'complete' => 'integerNetGridMassActionPager',
            'additional' => $this->_getAdditionalMassactionBlock()->setDryRun(true),
        ));

        return $this;
    }

    protected function _getAdditionalMassactionBlock()
    {
        /** @var Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Massaction $block */
        $block = $this->getLayout()->createBlock('derivedattributes/adminhtml_entity_massaction');
        $block->setEntityType(Mage_Catalog_Model_Product::ENTITY);
        return $block;
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();
        $this->removeColumn('action');
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/productGrid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return '#';
    }

}