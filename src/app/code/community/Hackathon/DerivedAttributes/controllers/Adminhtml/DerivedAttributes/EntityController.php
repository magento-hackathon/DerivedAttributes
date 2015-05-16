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
        $this->_title($this->__('Derived Attributes'))->_title($this->__('Entities'));
        $this->_initAction();
        Mage::helper('integernet_gridmassactionpager')->addScript();
        $this->renderLayout();
    }

    /**
     * Product grid for AJAX request
     */
    public function productGridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    /**
     * Customer grid for AJAX request
     */
    public function customerGridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function applyRulesAction()
    {
        //TODO apply rules
        /** @var IntegerNet_GridMassActionPager_Model_GridMassActionPager $gridMassActionPager */
        $gridMassActionPager = Mage::getModel('integernet_gridmassactionpager/gridMassActionPager');

        if ($entityIds = (array)$this->getRequest()->getParam('entity_ids')) {

            $gridMassActionPager->init($entityIds, 100);
            $gridMassActionPager->getPager()
                ->setEntityType($this->getRequest()->getParam('entity_type'))
                ->setDryRun((bool) $this->getRequest()->getParam('dry_run'));

        } elseif ($pageIds = $gridMassActionPager->getPageIds()) {

            $entityType = $gridMassActionPager->getPager()->getEntityType();
            $isDryRun = $gridMassActionPager->getPager()->getDryRun();
            $this->_process($pageIds, $entityType, $isDryRun);

            $gridMassActionPager->next();
        } else {
            //TODO (optionally) generate results page, trigger redirect
            // - log generated attributes to new table (entity_type, attribute_id, applied_rule_id, value)
            // - override IntegerNet_GridMassActionPager.prototype.process(transport)
            // - if (transport.final), redirect
        }

        $message = $this->__('Process Entities...<br />{{from}} to {{to}} of {{of}}');

        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody($gridMassActionPager->getStatus(true, $message));
    }
    protected function _process($pageIds, $entityType, $isDryRun)
    {
        //TODO process entities
    }
}