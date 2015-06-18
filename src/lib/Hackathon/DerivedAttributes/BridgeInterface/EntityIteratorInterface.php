<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\Store;

interface EntityIteratorInterface
{

    /**
     * @param callable $callable
     * @return mixed
     */
    function walk(callable $callable);

    /**
     * Returns raw data from database
     *
     * @return mixed
     */
    function getRawData();

    /**
     * Returns number of iteration
     *
     * @return int
     */
    function getIteration();

    /**
     * Returns total size of collection
     *
     * @return mixed
     */
    function getSize();

    /**
     * @return Store
     */
    function getStore();

    /**
     * @param Store $store
     * @return mixed
     */
    function setStore(Store $store);
}