<?php
namespace Hackathon\DerivedAttributes\Mock;


use Hackathon\DerivedAttributes\BridgeInterface\EntityIteratorInterface;
use Hackathon\DerivedAttributes\Store;

/**
 * Dumb implementation of EntityIteratorInterface that iterates over an array of data
 */
class CollectionMock extends \ArrayIterator implements EntityIteratorInterface
{
    const __CLASS = __CLASS__;

    private $store;

    /**
     * @param callable $callable
     * @return mixed
     */
    function walk(callable $callable)
    {
        foreach ($this as $row) {
            $callable($this);
        }
    }

    /**
     * Returns raw data from database
     *
     * @return mixed
     */
    function getRawData()
    {
        return $this->current();
    }

    /**
     * Returns number of iteration
     *
     * @return int
     */
    function getIteration()
    {
        return $this->key();
    }

    /**
     * Returns total size of collection
     *
     * @return mixed
     */
    function getSize()
    {
        return $this->count();
    }

    function getStore()
    {
        return $this->store;
    }

    function setStore(Store $store)
    {
        $this->store = $store;
    }

}