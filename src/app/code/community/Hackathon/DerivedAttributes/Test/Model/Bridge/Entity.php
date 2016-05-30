<?php
use Hackathon\DerivedAttributes\Attribute;

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 * @loadFixture products.yaml
 */
class Hackathon_DerivedAttributes_Test_Model_Bridge_Entity extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     */
    public function testLocalizedAttributeValueForTextAttributes()
    {
        $this->assertEquals('Test Product 1', $this->getProductEntityBridge(1, 1)
            ->getLocalizedAttributeValue($this->getAttributeBridge('name')));
        $this->assertEquals('Test Product 1 in store view', $this->getProductEntityBridge(2, 1)
            ->getLocalizedAttributeValue($this->getAttributeBridge('name')));

        $this->assertEquals('description.', $this->getProductEntityBridge(1, 1)
            ->getLocalizedAttributeValue($this->getAttributeBridge('description')));
        $this->assertEquals('description in store view', $this->getProductEntityBridge(2, 1)
            ->getLocalizedAttributeValue($this->getAttributeBridge('description')));
    }

    /**
     * @param $storeId
     * @param $productId
     * @return Hackathon_DerivedAttributes_Model_Bridge_Entity
     */
    private function getProductEntityBridge($storeId, $productId)
    {
        /** @var Hackathon_DerivedAttributes_Helper_Data $helper */
        $helper = Mage::helper('derivedattributes');
        $entity = $helper->getNewEntityModel(
            $helper->getEntityTypeInstance(Mage_Catalog_Model_Product::ENTITY),
            Mage::getModel('catalog/product')->setStoreId($storeId)->load($productId)
        );
        return $entity;
    }

    /**
     * @param $attributeCode
     * @return Attribute
     */
    private function getAttributeBridge($attributeCode)
    {
        return new Attribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode);
    }
}