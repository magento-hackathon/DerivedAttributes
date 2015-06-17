<?php
namespace Hackathon\DerivedAttributes;

/**
 * StoreSet: Value object, representing a set of Magento stores
 *
 * @package Hackathon\DerivedAttributes
 */
class StoreSet
{
    const __CLASS = __CLASS__;

    protected $storeCodes;

    /**
     * @param string[] $storeCodes
     */
    function __construct(array $storeCodes)
    {
        $this->storeCodes = array_map('strval', $storeCodes);
    }

    /**
     * Returns special instance representing all stores
     *
     * @return StoreSet
     */
    public static function all()
    {
        static $all;
        if (! $all) {
            $all = new self([]);
        }
        return $all;
    }

    /**
     * @return string[]
     */
    public function getStoreCodes()
    {
        return $this->storeCodes;
    }
}