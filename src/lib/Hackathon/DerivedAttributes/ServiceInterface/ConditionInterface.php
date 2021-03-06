<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 17:59
 */

namespace Hackathon\DerivedAttributes\ServiceInterface;


use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;

interface ConditionInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @param string $data
     * @return $this
     */
    function configure($data);

    /**
     * @return string
     */
    function getData();

    /**
     * @param EntityInterface $entity
     * @return boolean
     */
    function match(EntityInterface $entity);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}