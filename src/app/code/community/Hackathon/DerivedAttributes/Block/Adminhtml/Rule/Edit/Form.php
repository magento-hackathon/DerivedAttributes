<?php
class Hackathon_DerivedAttributes_Block_Adminhtml_Rule_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('derivedattributes_rule_form');
        $this->setTitle($this->__('Rule Information'));
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post'));
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend' => $this->__('General Information'))
        );

        $model = Mage::registry('current_derived_attribute_rule');
        if ($model->getId()) {
            $fieldset->addField('rule_id', 'hidden', array(
                'name' => 'rule_id',
            ));
        }

        $fieldset->addField('name', 'text', array(
            'name'     => 'name',
            'label'    => $this->__('Rule Name'),
            'title'    => $this->__('Rule Name'),
            'required' => true,
        ));

        $fieldset->addField('description', 'textarea', array(
            'name'  => 'description',
            'label' => $this->__('Description'),
            'title' => $this->__('Description'),
            'style' => 'height: 100px;',
        ));

        $fieldset->addField('active', 'select', array(
            'label'     => $this->__('Status'),
            'title'     => $this->__('Status'),
            'name'      => 'active',
            'required'  => true,
            'options'    => array(
                '1' => $this->__('Active'),
                '0' => $this->__('Inactive'),
            ),
        ));

        if (Mage::app()->isSingleStoreMode()) {
            $storeId = Mage::app()->getStore(true)->getId();
            $fieldset->addField('store_id', 'hidden', array(
                'name'     => 'store_id[]',
                'value'    => $storeId
            ));
            $model->setStoreId($storeId);
        } else {
            $field = $fieldset->addField('store_id', 'multiselect', array(
                'name'     => 'store_id[]',
                'label'    => $this->__('Store'),
                'title'    => $this->__('Store'),
                'required' => true,
                'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
            ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        }

        $fieldset->addField('attribute_id', 'select', array(
            'label'    => $this->__('Attribute'),
            'title'    => $this->__('Attribute'),
            'name'     => 'attribute_id',
            'required' => true,
            'values'  => Mage::getModel('derivedattributes/source_attribute')->toOptionArray(true)
        ));

        $fieldset = $form->addFieldset('generator_fieldset',
            array('legend' => $this->__('Generator'))
        );

        $fieldset->addField('generator_type', 'select', array(
            'name' => 'generator_type',
            'label' => $this->__('Generator Type'),
            'title' =>  $this->__('Generator Type'),
            'values' => Mage::getModel('derivedattributes/source_generator')->toOptionArray(true)
        ));

        //TODO show description for currently selected generator to explain generator_data format
        $fieldset->addField('generator_data', 'textarea', array(
            'name' => 'generator_data',
            'label' => $this->__('Generator Data'),
            'title' => $this->__('Generator Data'),
            'style' => 'height: 100px;',
        ));

        $fieldset = $form->addFieldset('condition_fieldset',
            array('legend' => $this->__('Condition'))
        );

        $fieldset->addField('condition_type', 'select', array(
            'name' => 'condition_type',
            'label' => $this->__('Condition Type'),
            'title' =>  $this->__('Condition Type'),
            'values' => Mage::getModel('derivedattributes/source_condition')->toOptionArray(true)
        ));

        //TODO show description for currently selected condition to explain condition_data format
        $fieldset->addField('condition_data', 'textarea', array(
            'name' => 'condition_data',
            'label' => $this->__('Condition Data'),
            'title' => $this->__('Condition Data'),
            'style' => 'height: 100px;',
        ));

        $form->setValues($model->getData());

        return parent::_prepareForm();
    }


}
