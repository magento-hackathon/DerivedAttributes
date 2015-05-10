<?php
class Hackathon_DerivedAttributes_Block_Adminhtml_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'derivedattributes';
        $this->_controller = 'adminhtml_rule';
        $this->_headerText = $this->__('Derived Attribute Rules');
        $this->_addButtonLabel = $this->__('Add New Rule');
        parent::__construct();

    }
}