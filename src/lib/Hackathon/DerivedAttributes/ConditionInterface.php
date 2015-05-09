<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 17:59
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\Implementor\ProductInterface;

interface ConditionInterface
{
    const __CLASS = __CLASS__;

    function match(ProductInterface $product);
} 