<?php
/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 * @loadFixture products.yaml
 */
class Hackathon_DerivedAttributes_Test_Model_Rule extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     * @dataProvider dataProvider
     * @loadExpectation attributes
     */
    public function rulesShouldBeAppliedOnModelSave($productId)
    {
        $storeIds = array(0, 1, 2);
        /** @var Mage_Catalog_Model_Product $product */
        foreach ($storeIds as $storeId) {
            $product = Mage::getModel('catalog/product')->setStoreId($storeId)->load($productId);
            $product->setDataChanges(true)->save();
        }
        $this->assertEventDispatchedAtLeast('model_save_before', count($storeIds));

        foreach ($storeIds as $storeId) {
            $product->setStoreId($storeId)->load($productId);
            $expectedAttributeValues = $this->expected('product_%d_store_%d', $productId, $storeId)->getAttributes();
            foreach ($expectedAttributeValues as $attributeCode => $expectedValue) {
                $this->assertEquals(
                    $expectedValue,
                    $product->getData($attributeCode));
            }
        }
    }
}