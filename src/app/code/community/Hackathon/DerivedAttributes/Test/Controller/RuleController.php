<?php
/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 */
class Hackathon_DerivedAttributes_Test_Controller_RuleController
    extends Hackathon_DerivedAttributes_Test_Case_Controller_Dom
{
    /**
     * @test
     * @dataProvider dataSaveExistingRule
     * @param string[] $postData
     * @loadFixture products.yaml
     * @singleton adminhtml/session
     * @singleton admin/session
     */
    public function existingRuleShouldBeSaved(array $postData)
    {
        $defaultData = ['priority' => '1'];
        $this->adminSession();
        $this->getRequest()->setMethod('POST');
        $this->getRequest()->setPost($postData);
        $this->dispatch('adminhtml/derivedAttributes_rule/save');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/save');
        $this->assertRedirectTo('adminhtml/derivedAttributes_rule/index');

        $rule = Mage::getModel('derivedattributes/rule')->load($postData['rule_id']);
        $this->assertEquals($defaultData + $postData, $rule->getData(), 'Rule data should be as posted');
    }

    public static function dataSaveExistingRule()
    {
        return array(
            [ 'postData' => [
                'rule_id'        => '1',
                'active'         => '1',
                'name'           => 'Edited Test Rule',
                'description'    => 'The rule has been edited',
                'attribute_id'   => '72',
                'condition_type' => 'always',
                'condition_data' => '',
                'generator_type' => 'template',
                'generator_data' => 'Edited template',
                'store_id'       => [ '1', '2']
            ]]
        );
    }

    /**
     * @test
     * @loadFixture products.yaml
     * @singleton adminhtml/session
     * @singleton admin/session
     */
    public function existingRuleShouldBeDeleted()
    {
        $ruleId = '1';

        $this->adminSession();
        $this->getRequest()->setParam('id', $ruleId);
        $this->dispatch('adminhtml/derivedAttributes_rule/delete');
        $this->assertRequestRoute('adminhtml/derivedAttributes_rule/delete');
        $this->assertRedirectTo('adminhtml/derivedAttributes_rule/index');

        $rule = Mage::getModel('derivedattributes/rule')->load($ruleId);
        $this->assertNull($rule->getId(), 'Rule should not be loaded after delete');
    }
}