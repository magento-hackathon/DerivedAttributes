<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\Attribute;
use Hackathon\DerivedAttributes\ServiceInterface\GeneratorInterface;

/**
 * Entity implementation of entity-bridge-interface.
 */
class Hackathon_DerivedAttributes_Bridge_Generator implements GeneratorInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $data;

    function __construct($type, $data=null)
    {
        $this->type = (string)$type;
        $this->data = (string)$data;
    }

    /**
     * Return the Generator type
     *
     * @return string
     */
    function getGeneratorType(){
        return $this->type;
    }

    /**
     * Return information for instantiating the generator
     *
     * @return string
     */
    function getGeneratorData(){
        return $this->data;
    }

}
