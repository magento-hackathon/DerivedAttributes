<?php

/**
 * @group Hackathon_DerivedAttributes
 * @loadSharedFixture stores.yaml
 * @loadSharedFixture rules.yaml
 * @loadFixture products.yaml
 */
class Hackathon_DerivedAttributes_Test_Model_Massupdater extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     * @dataProvider getUpdateData
     * @param $entityIds
     * @param $entityType
     * @param $storeId
     */
    public function testMassUpdateByStoreView($entityIds, $entityType, $storeId)
    {
        $this->markTestIncomplete();
    }
    public static function getUpdateData()
    {
        return array(
            [ [1, 2, 3], 'catalog_product', ['0'] ],
            [ [1, 2, 3], 'catalog_product', ['1'] ],
            [ [1, 2, 3], 'catalog_product', ['1', '2'] ],
        );
    }
}