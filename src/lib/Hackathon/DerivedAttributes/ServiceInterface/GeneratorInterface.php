<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 18:00
 */

namespace Hackathon\DerivedAttributes\ServiceInterface;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;

interface GeneratorInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @param string $data
     * @return $this
     */
    function configure($data);

    /**
     * @internal used to test instantiation
     * @return string
     */
    function getData();

    /**
     * @param EntityInterface $entity
     * @return mixed
     */
    function generateAttributeValue(EntityInterface $entity);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}