<?php
namespace Hackathon\DerivedAttributes;
use Traversable;
use ArrayIterator;
use IteratorAggregate;
use Countable;

/**
 * StoreSet: Value object, representing a set of Magento stores
 *
 * @package Hackathon\DerivedAttributes
 */
class StoreSet implements IteratorAggregate, Countable
{
    const __CLASS = __CLASS__;

    /**
     * @var Store[]
     */
    protected $stores = [];

    /**
     * @param string[] $storeCodes
     */
    function __construct(array $storeCodes)
    {
        foreach ($storeCodes as $storeCode) {
            $this->stores[(string) $storeCode] = new Store($storeCode);
        }
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
        return array_keys($this->stores);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->stores);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->stores);
    }


}