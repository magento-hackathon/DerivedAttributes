<?php
class Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('ruleApplyForm');
    }

    protected function _prepareForm()
    {
        $form   = new Varien_Data_Form(array(
            'id'        => 'apply_rules_form',
            'action'    => $this->getData('action'),
            'method'    => 'post'
        ));
        $form->addFieldset('apply_rules_entities', array(
            'legend' => $this->__('Select Entities')
        ));
        $this->setForm($form);
        return parent::_prepareForm();
    }

}