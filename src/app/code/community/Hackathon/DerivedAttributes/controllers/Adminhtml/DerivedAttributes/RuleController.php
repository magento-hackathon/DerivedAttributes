<?php
class Hackathon_DerivedAttributes_Adminhtml_DerivedAttributes_RuleController extends
    Mage_Adminhtml_Controller_Action
{
    protected function _initRule()
    {
        $this->_title($this->__('Derived Attributes'))->_title($this->__('Rules'));

        Mage::register('current_derived_attribute_rule', Mage::getModel('derivedattributes/rule'));
        $id = (int)$this->getRequest()->getParam('id');

        if (!$id && $this->getRequest()->getParam('rule_id')) {
            $id = (int)$this->getRequest()->getParam('rule_id');
        }

        if ($id) {
            Mage::registry('current_derived_attribute_rule')->load($id);
        }
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/attributes/derived_attributes')
            ->_addBreadcrumb($this->__('Derived Attributes'),$this->__('Rules'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Derived Attributes'))->_title($this->__('Rules'));

        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('derivedattributes/rule');

        if ($id) {
            $model->load($id);
            if (! $model->getRuleId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    $this->__('This rule no longer exists.'));
                $this->_redirect('*/*');
                return;
            }
        }

        //TODO add "name" column
        $this->_title($model->getId() ? $model->getName() : $this->__('New Rule'));

        $data = Mage::getSingleton('adminhtml/session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        Mage::register('current_derived_attribute_rule', $model);

        $this->_initAction()->getLayout()->getBlock('derivedattributes_rule_edit')
            ->setData('action', $this->getUrl('*/*/save'));

        $this
            ->_addBreadcrumb(
                $id ? $this->__('Edit Rule')
                    : $this->__('New Rule'),
                $id ? $this->__('Edit Rule')
                    : $this->__('New Rule'))
            ->renderLayout();

    }

    public function saveAction()
    {
        if ($this->getRequest()->getPost()) {
            try {
                /** @var $model Hackathon_DerivedAttributes_Model_Rule*/
                $model = Mage::getModel('derivedattributes/rule');
                Mage::dispatchEvent(
                    'adminhtml_controller_derivedattributes_rule_prepare_save',
                    array('request' => $this->getRequest()));
                $data = $this->getRequest()->getPost();
                $data = $this->_filterDates($data, array('from_date', 'to_date'));
                $id = $this->getRequest()->getParam('rule_id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        Mage::throwException($this->__('Wrong rule specified.'));
                    }
                }

                $session = Mage::getSingleton('adminhtml/session');

//                $validateResult = $model->validateData(new Varien_Object($data));
//                if ($validateResult !== true) {
//                    foreach($validateResult as $errorMessage) {
//                        $session->addError($errorMessage);
//                    }
//                    $session->setPageData($data);
//                    $this->_redirect('*/*/edit', array('id'=>$model->getId()));
//                    return;
//                }

                $model->addData($data);

                $session->setPageData($model->getData());

                $model->save();
                $session->addSuccess($this->__('The rule has been saved.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('rule_id');
                if (!empty($id)) {
                    $this->_redirect('*/*/edit', array('id' => $id));
                } else {
                    $this->_redirect('*/*/new');
                }
                return;

            } catch (Exception $e) {
                $this->_getSession()->addError(
                    $this->__('An error occurred while saving the rule data. Please review the log and try again.'));
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->setPageData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('rule_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('derivedattributes/rule');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__('The rule has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addError(
                    $this->__('An error occurred while deleting the rule. Please review the log and try again.'));
                Mage::logException($e);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            $this->__('Unable to find a rule to delete.'));
        $this->_redirect('*/*/');
    }

    public function gridAction()
    {
        $this->_initRule()->loadLayout()->renderLayout();
    }

    /**
     * Returns result of current user permission check on resource and privilege
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/attributes/derived_attributes');
    }

}