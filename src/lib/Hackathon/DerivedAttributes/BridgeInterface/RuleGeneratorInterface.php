<?php
namespace Hackathon\DerivedAttributes\BridgeInterface;

interface RuleGeneratorInterface
{
    const __INTERFACE = __CLASS__;

    /**
     * Return the Generator type
     *
     * @return string
     */
    function getGeneratorType();

    /**
     * Return information for instantiating the generator
     *
     * @return string
     */
    function getGeneratorData();

}