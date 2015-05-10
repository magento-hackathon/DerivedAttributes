<?php
abstract class Hackathon_DerivedAttributes_Model_Source_Abstract
{
    /**
     * @var \Hackathon\DerivedAttributes\Service\Manager
     */
    protected $_serviceManager;

    public function __construct()
    {
        $this->_serviceManager = new \Hackathon\DerivedAttributes\Service\Manager();
    }

    abstract public function getOptions();

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