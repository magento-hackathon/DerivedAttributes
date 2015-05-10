<?php
class Hackathon_DerivedAttributes_Model_Source_Condition extends Hackathon_DerivedAttributes_Model_Source_Abstract
{

    public function getOptions()
    {
        $options = array();
        foreach ($this->_serviceManager->getAvailableConditionTypes() as $id => $info) {
            $options[$id] = Mage::helper('derivedattributes')->__($info['title']);
        }
        return $options;
    }
}