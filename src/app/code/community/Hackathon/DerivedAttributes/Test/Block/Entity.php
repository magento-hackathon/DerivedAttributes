<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Block_Entity extends Hackathon_DerivedAttributes_Test_Case_Controller_Dom
{
    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     */
    public function formForApplyRulesShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_entity');
        $this->assertRequestRoute('adminhtml/derivedAttributes_entity/index');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_entity_index');
        $this->assertLayoutBlockRendered('derivedattributes_entity', 'Container should be instantiated');
        $this->assertLayoutBlockRendered('derivedattributes_entity_form', 'Form should be instantiated');
        $this->assertLayoutBlockRendered('derivedattributes_entity_tabs', 'Tabs should be instantiated');

        $this->assertResponseBodyXpath(
            '//select[@id="customerGrid_massaction-select"]/option[@value="apply"]',
            'Customer grid should contain mass action "apply".');
        $this->assertResponseBodyXpath(
            '//select[@id="customerGrid_massaction-select"]/option[@value="dryrun"]',
            'Customer grid should contain mass action "dryrun".');

        $this->assertResponseBodyXpath(
            '//select[@id="productDerivedAttributesGrid_massaction-select"]/option[@value="apply"]',
            'Product grid should contain mass action "apply".');
        $this->assertResponseBodyXpath(
            '//select[@id="productDerivedAttributesGrid_massaction-select"]/option[@value="dryrun"]',
            'Product grid should contain mass action "dryrun".');

        $this->assertResponseBodyContains('name="entity_type"', 'Mass action block should contain hidden input with entity type');
        // assertLayoutBlockRendered does not work with blocks created from code (i.e. the grids)
    }
}