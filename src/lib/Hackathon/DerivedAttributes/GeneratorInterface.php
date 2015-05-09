<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 18:00
 */

namespace Hackathon\DerivedAttributes;


use Hackathon\DerivedAttributes\Implementor\ProductInterface;

interface GeneratorInterface
{
    const __CLASS = __CLASS__;

    function generateAttributeValue(ProductInterface $product, Attribute $attribute);
} 