<?php

namespace Hackathon\DerivedAttributes;

class StoreSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldIterateOverStores()
    {
        $storeCodes = ['1', '2'];

        $storeSet = new StoreSet($storeCodes);

        reset($storeCodes);
        foreach ($storeSet as $actualStoreCode => $actualStore) {
            $expectedStoreCode = current($storeCodes);
            $this->assertEquals($expectedStoreCode, $actualStoreCode);
            $this->assertInstanceOf(Store::__CLASS, $actualStore);
            $this->assertEquals($expectedStoreCode, (string) $actualStore);
            next($storeCodes);
        }
        $this->assertFalse(current($storeCodes), 'Iterator should yield all stores.');
    }
}