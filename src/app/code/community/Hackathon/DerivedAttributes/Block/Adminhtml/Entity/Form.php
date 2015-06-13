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
        $fieldset = $form->addFieldset('apply_rules_stores', array(
            'legend' => $this->__('Select Stores')
        ));
        if (Mage::app()->isSingleStoreMode()) {
            $storeId = Mage::app()->getStore(true)->getId();
            $fieldset->addField('store_id', 'hidden', array(
                'name'     => 'store_id[]',
                'value'    => $storeId
            ));
            //TODO make fieldset invisible?
        } else {
            $field = $fieldset->addField('store_id', 'multiselect', array(
                'name'     => 'store_id[]',
                'label'    => $this->__('Store'),
                'title'    => $this->__('Store'),
                'required' => true,
                'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                'onchange' => '$(\'massaction_store_id\').setValue(this.getValue())',
            ));
            $field->setValue('0');
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }
        $this->setForm($form);
        return parent::_prepareForm();
    }

}