<?php

/**
 * Additional form inputs for massaction block
 *
 * @method Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Massaction setEntityType(string $type)
 * @method string getEntityType()
 * @method Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Massaction setDryRun(boolean $dryRun)
 * @method bool getDryRun()
 */
class Hackathon_DerivedAttributes_Block_Adminhtml_Entity_Massaction extends Mage_Adminhtml_Block_Abstract
{
    protected function _toHtml()
    {
        $form = new Varien_Data_Form([
            'use_container' => false,
        ]);
        $form->addField('entity_type', 'hidden', array(
            'name' => 'entity_type',
            'value' => $this->getEntityType(),
            'no_span' => true,
        ));
        if ($this->getDryRun()) {
            $form->addField('dry_run', 'hidden', array(
                'name' => 'dry_run',
                'value' => '1',
                'no_span' => true,
            ));
        }
        return $form->toHtml();
    }
}