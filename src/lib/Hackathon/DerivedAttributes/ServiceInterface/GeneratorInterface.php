<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 18:00
 */

namespace Hackathon\DerivedAttributes\ServiceInterface;

use Hackathon\DerivedAttributes\BridgeInterface\EntityInterface;
use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;

interface GeneratorInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * @param EntityInterface $product
     * @return mixed
     */
    function generateAttributeValue(EntityInterface $product);

    /**
     * @return string
     */
    function getTitle();

    /**
     * @return string
     */
    function getDescription();
}