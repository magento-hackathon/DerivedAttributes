<?php
/**
 * Created by PhpStorm.
 * User: fs
 * Date: 09.03.2015
 * Time: 17:59
 */

namespace IntegerNet\AttributeRule;


use IntegerNet\AttributeRule\Implementor\ProductInterface;

interface Condition
{
    const __CLASS = __CLASS__;

    function match(ProductInterface $product);
} 