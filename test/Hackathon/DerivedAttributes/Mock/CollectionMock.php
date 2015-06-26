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