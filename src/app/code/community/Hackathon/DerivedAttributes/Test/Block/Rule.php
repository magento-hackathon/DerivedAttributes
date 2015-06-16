<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Block_Rule extends Hackathon_DerivedAttributes_Test_Case_Controller_Dom
{
    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     */
    public function gridShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_rule');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/index');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_index');
        $this->assertLayoutBlockCreated('derivedattributes_rule', 'Grid container should be instantiated');
        $this->assertResponseBodyNotContains('empty-text', 'Grid content should not be empty');
        $this->assertResponseBodyContains('Test Rule 1');
        $this->assertResponseBodyContains('/derivedAttributes_entity/index', '"Apply rules" link should be present');
    }

    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     * @registry current_derived_attribute_rule
     */
    public function newFormShouldBeLoaded()
    {
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_rule/new');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/edit');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_edit');
        $this->assertLayoutBlockCreated('derivedattributes_rule_edit', 'Form should be instantiated');
        $this->assertResponseBodyXpath(
            '//select[@name="generator_type"]/option[@value="template"]',
            'Dropdown with generator types should be present');
        $this->assertResponseBodyXpath(
            '//select[@name="condition_type"]/option[@value="boolean-attribute"]',
            'Dropdown with condition types should be present');
        $this->assertResponseBodyXpathContains(
            '//select[@name="store_id[]"]//option[@value="0"]', 'All Store Views',
            'Select box for store views should contain "All Store Views"');

        $this->assertResponseBodyXpath(
            '//select[@name="attribute_id"]/optgroup[@label="Customer"]',
            'Dropdown with attribute ids should contain customer optgroup');
        $this->assertResponseBodyXpath(
            '//select[@name="attribute_id"]/optgroup[@label="Product"]',
            'Dropdown with attribute ids should contain product optgroup');
        $this->assertResponseBodyXpath(
            '//select[@name="attribute_id"]//option[@value="72"]',
            'Dropdown with attribute ids should contain product description attribute id');
        $this->assertResponseBodyNotXpath(
            '//select[@name="attribute_id"]//option[@value="111"]',
            'Dropdown with attribute ids should not contain product has_options attribute id (invisible)');
        $this->assertResponseBodyXpath(
            '//select[@name="attribute_id"]//option[@value="5"]',
            'Dropdown with attribute ids should contain customer first name attribute id');
        $this->assertResponseBodyNotXpath(
            '//select[@name="attribute_id"]//option[@value="16"]',
            'Dropdown with attribute ids should not contain customer confirmation attribute id (invisible)');
    }
    /**
     * @test
     * @singleton adminhtml/session
     * @singleton admin/session
     * @singleton index/indexer
     * @registry current_derived_attribute_rule
     */
    public function editFormShouldBeLoaded()
    {
        $ruleId = 1;
        $this->adminSession();
        $this->dispatch('adminhtml/derivedAttributes_rule/edit', ['id' => $ruleId]);
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/edit');
        $this->assertLayoutHandleLoaded('adminhtml_derivedattributes_rule_edit');
        $this->assertLayoutBlockCreated('derivedattributes_rule_edit', 'Form should be instantiated');
        $this->assertResponseBodyXpath(
            '//input[@name="name"][@value="Test Rule 1"]', 'Name input should be filled');
        $this->assertResponseBodyXpathContains(
            '//select[@name="active"]/option[@value="1"][@selected="selected"]', 'Active',
            'Status input should be set to active');
        $this->assertResponseBodyXpathContains(
            '//select[@name="store_id[]"]//option[@value="0"][@selected="selected"]', 'All Store Views',
            'Store view input should be set to "All Store Views"');
        $this->assertResponseBodyXpathContains(
            '//textarea[@name="description"]', 'This is a template generator rule for the product description',
            'Description input should be filled');
    }
}