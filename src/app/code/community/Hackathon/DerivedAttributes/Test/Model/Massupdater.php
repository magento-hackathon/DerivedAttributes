<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 * @loadFixture products.yaml
 */
class Hackathon_DerivedAttributes_Test_Model_Massupdater extends EcomDev_PHPUnit_Test_Case
{
    protected function setUp()
    {
        parent::setUp();
        Mage::getModel('index/indexer')->getProcessByCode('catalog_product_flat')->reindexAll();
    }

    /**
     * @test
     * @dataProvider dataProvider
     * @loadExpectation attributes
     * @param $entityIds
     * @param $storeIds
     */
    public function testProductMassUpdateByStoreView($entityIds, $storeIds)
    {
        /** @var Hackathon_DerivedAttributes_Model_Massupdater $updater */
        $updater = Mage::getModel('derivedattributes/massupdater');
        $updater->update($entityIds, 'catalog_product', $storeIds, false);
        foreach($storeIds as $storeId) {
            foreach ($entityIds as $entityId) {
                $product = Mage::getModel('catalog/product')->setStoreId($storeId)->load($entityId);
                $expectedAttributeValues = $this->expected('product_%d_store_%d', $entityId, $storeId)->getAttributes();
                foreach ($expectedAttributeValues as $attributeCode => $expectedValue) {
                    $this->assertEquals(
                        $expectedValue,
                        $product->getData($attributeCode),
                        sprintf('Store %d Product %d Attribute %s', $storeId, $entityId, $attributeCode));
                }
            }
        }
    }
}