<?php
class Hackathon_DerivedAttributes_Adminhtml_DerivedAttributes_RuleController extends
    Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/attributes/derived_attributes');
    }

    /**
     * @var Hackathon_DerivedAttributes_Model_Resource_Rule
     */
    protected $_repository;

    protected function _construct()
    {
        $this->_repository = Mage::getModel('derivedattributes/bridge_ruleRepository');
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
        $model = new Varien_Object();

        if ($id) {
            try {
                $rule = $this->_repository->findById($id);
                $model = $this->_repository->getRuleModel($rule);
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*');
                return;
            }
        }

        $this->_title($model->getId() ? $rule->getName() : $this->__('New Rule'));

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
                Mage::dispatchEvent(
                    'adminhtml_controller_derivedattributes_rule_prepare_save',
                    array('request' => $this->getRequest()));
                $data = $this->getRequest()->getPost();
//                $data = $this->_filterDates($data, array('from_date', 'to_date'));

//                $validateResult = $model->validateData(new Varien_Object($data));
//                if ($validateResult !== true) {
//                    foreach($validateResult as $errorMessage) {
//                        $session->addError($errorMessage);
//                    }
//                    $session->setPageData($data);
//                    $this->_redirect('*/*/edit', array('id'=>$model->getId()));
//                    return;
//                }


                $id = $this->getRequest()->getParam('rule_id');
                if ($id) {
                    $oldRule = $this->_repository->findById($id);
                    $model = $this->_repository->getRuleModel($oldRule);
                    $model->addData($data);
                    $newRule = $this->_createRuleFromModel($model);
                    $this->_repository->replaceRule($oldRule, $newRule);
                } else {
                    $newRule = $this->_createRuleFromModel(new Varien_Object($data));
                    $this->_repository->createRule($newRule);
                }

                $this->_getSession()->addSuccess($this->__('The rule has been saved.'));
                $this->_getSession()->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $this->_repository->getRuleId($newRule)));
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
                $ruleToBeDeleted = $this->_repository->findById($id);
                $this->_repository->deleteRule($ruleToBeDeleted);
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
        $this->_title($this->__('Derived Attributes'))->_title($this->__('Rules'));
        $this->loadLayout()->renderLayout();
    }

    /**
     * @param $model
     * @return \Hackathon\DerivedAttributes\Rule
     */
    protected function _createRuleFromModel($model)
    {
        $newRule = Mage::helper('derivedattributes/rule_director')->createRule($model);
        $this->_getSession()->setPageData($this->_repository->getRuleModel($newRule)->getData());
        return $newRule;
    }

}