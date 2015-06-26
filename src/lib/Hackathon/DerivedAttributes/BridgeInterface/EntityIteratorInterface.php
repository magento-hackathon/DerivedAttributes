<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\Store;
use \Iterator;

/**
 * Interface EntityIteratorInterface
 *
 * @todo simplify, no need to tie it to core/iterator resource model anymore
 *
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface EntityIteratorInterface extends Iterator
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