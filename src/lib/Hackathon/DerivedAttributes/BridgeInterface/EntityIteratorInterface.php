<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

use Hackathon\DerivedAttributes\Store;
use \Iterator;

/**
 * Interface EntityIteratorInterface
 *
 * @package Hackathon\DerivedAttributes\BridgeInterface
 */
interface EntityIteratorInterface extends Iterator
{
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