<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

interface RuleFilterInterface
{
    const __CLASS = __CLASS__;

    /**
     * Return the Filter type
     *
     * @return string
     */
    function getFilterType();

    /**
     * Return information for instantiating the filter
     *
     * @return string
     */
    function getFilterData();

}