<?php
class Hackathon_DerivedAttributes_Model_Source_Generator extends Hackathon_DerivedAttributes_Model_Source_Abstract
{
    public function getOptions()
    {
        $options = array();
        foreach ($this->_serviceManager->getAvailableGeneratorTypes() as $id => $info) {
            $options[$id] = Mage::helper('derivedattributes')->__($info['title']);
        }
        return $options;
    }
}