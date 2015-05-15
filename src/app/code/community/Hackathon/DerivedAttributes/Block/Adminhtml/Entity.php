<?php
class Hackathon_DerivedAttributes_Block_Adminhtml_Entity extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'entity_id';
        $this->_controller = 'adminhtml_entity';
        $this->_headerText = $this->__('Apply Rules');

        parent::__construct();
    }
}