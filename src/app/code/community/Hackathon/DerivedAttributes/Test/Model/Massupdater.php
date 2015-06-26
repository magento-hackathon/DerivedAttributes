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
     * @dataProviderFile testProductMassUpdateByStoreView
     * @loadExpectation attributes
     * @helper catalog/product_flat
     * @param $entityIds
     * @param $storeIds
     */
    public function testProductMassUpdateByStoreView($entityIds, $storeIds)
    {
        $this->setCurrentStore('admin');
        $this->assertTrue(Mage::getStoreConfigFlag('catalog/frontend/flat_catalog_product'), 'Flat index should be enabled.');
        $this->assertFalse(Mage::getResourceModel('catalog/product_collection')->isEnabledFlat(), 'Flat index should not be used');

        /** @var Hackathon_DerivedAttributes_Model_Massupdater $updater */
        $updater = Mage::getModel('derivedattributes/massupdater');
        $updater->update($entityIds, 'catalog_product', $storeIds, false);

        if ($storeIds === ['0']) {
            $storeIds = ['0', '1', '2'];
        }
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

        /**
     * @test
     * @expectedException Mage_Core_Exception
     * @expectedExceptionMessageRegExp Invalid entity type foo_bar.
     */
    public function testInvalidEntityType()
    {
        /** @var Hackathon_DerivedAttributes_Model_Massupdater $updater */
        $updater = Mage::getModel('derivedattributes/massupdater');
        $updater->update(['1'], 'foo_bar', ['0'], false);
    }
}