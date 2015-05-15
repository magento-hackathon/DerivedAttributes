<?php
class Hackathon_DerivedAttributes_Adminhtml_DerivedAttributes_EntityController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/attributes/derived_attributes')
            ->_addBreadcrumb($this->__('Derived Attributes'),$this->__('Entities'))
        ;
        return $this;
    }

    public function indexAction()
    {
        //TODO implement apply rules
        // - window with preview (dry run)
        // - second action for apply
        $this->_title($this->__('Derived Attributes'))->_title($this->__('Entities'));

        $this->_initAction()
            ->renderLayout();
    }

}