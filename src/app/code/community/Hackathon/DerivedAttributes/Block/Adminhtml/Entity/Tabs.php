<?php
class Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('derivedattributes_entity_tabs');
        $this->setDestElementId('apply_rules_entities');
        $this->setTitle(Mage::helper('derivedattributes')->__('Apply Rules'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('product', array(
            'label'     => $this->__('Products'),
            'content'   => $this->getLayout()->createBlock('derivedattributes/adminhtml_entity_product_grid')->toHtml(),
        ));

        $this->addTab('customers', array(
            'label'     => Mage::helper('customer')->__('Customers'),
            'content'   => $this->getLayout()->createBlock('derivedattributes/adminhtml_entity_customer_grid')->toHtml(),
        ));

        $this->_updateActiveTab();
        return parent::_beforeToHtml();
    }

    protected function _updateActiveTab()
    {
        $tabId = $this->getRequest()->getParam('tab');
        if( $tabId ) {
            $tabId = preg_replace("#{$this->getId()}_#", '', $tabId);
            if($tabId) {
                $this->setActiveTab($tabId);
            }
        }
    }
}
