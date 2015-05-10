<?php
class Hackathon_DerivedAttributes_Model_Source_Generator
{
    /**
     * @var \Hackathon\DerivedAttributes\Service\Manager
     */
    protected $_serviceManager;

    public function __construct()
    {
        $this->_serviceManager = new \Hackathon\DerivedAttributes\Service\Manager();
    }

    public function getOptions()
    {
        $options = array();
        foreach ($this->_serviceManager->getAvailableGeneratorTypes() as $id => $info) {
            $options[$id] = Mage::helper('derivedattributes')->__($info['title']);
        }
        return $options;
    }
    public function toOptionArray($withEmpty = false)
    {
        $options = array();

        foreach ($this->getOptions() as $value => $label) {
            $options[] = array(
                'label' => $label,
                'value' => $value
            );
        }

        if ($withEmpty) {
            array_unshift($options, array('value'=>'', 'label'=>Mage::helper('page')->__('-- Please Select --')));
        }

        return $options;
    }
}