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
        $form->addField('massaction_entity_type', 'hidden', array(
            'name' => 'entity_type',
            'value' => $this->getEntityType(),
            'no_span' => true,
        ));
        $form->addField('massaction_store_id', 'multiselect', array(
            'name'     => 'store_id[]',
            'required' => true,
            'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            'no_span'  => true,
            'style'    => 'display:none',
        ));
        if ($this->getDryRun()) {
            $form->addField('massaction_dry_run', 'hidden', array(
                'name' => 'dry_run',
                'value' => '1',
                'no_span' => true,
            ));
        }
        $massActionId = $this->getParentBlock()->getMassaction()->getHtmlId();
        $updateHiddenFieldJs = <<<HTML
<script type="text/javascript">
\$('{$massActionId}').observe('change', function() {
    \$('massaction_store_id').setValue(\$('store_id').getValue())
});
</script>
HTML;
        return $form->toHtml() . $updateHiddenFieldJs;

    }
}