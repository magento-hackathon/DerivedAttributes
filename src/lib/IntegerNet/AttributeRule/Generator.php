<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 18:00
 */

namespace IntegerNet\AttributeRule;


use IntegerNet\AttributeRule\Implementor\ProductInterface;

interface Generator
{
    const __CLASS = __CLASS__;

    function generateAttributeValue(ProductInterface $product, Attribute $attribute);
} 