<?php
// turn off strict notices while loading to maintain compatibility with old ZF version in Magento < 1.9.1 and PHPUnit > 3.5
$__old_error_reporting = error_reporting(error_reporting() & ~ E_STRICT);

/**
 * Extension of DomQuery constraint with configuration in constructor instead
 * of in evaluate() - so that it can be used in EcomDev PHPUnit Controller
 * Test Case
 */
class Hackathon_DerivedAttributes_Test_Constraint_DomQuery extends Zend_Test_PHPUnit_Constraint_DomQuery
{
    const ASSERT_XPATH                  = 'assertXpath';
    const ASSERT_XPATH_CONTENT_CONTAINS = 'assertXpathContentContains';
    const ASSERT_XPATH_CONTENT_REGEX    = 'assertXpathContentRegex';
    const ASSERT_XPATH_CONTENT_COUNT    = 'assertXpathCount';
    const ASSERT_XPATH_CONTENT_COUNT_MIN= 'assertXpathCountMin';
    const ASSERT_XPATH_CONTENT_COUNT_MAX= 'assertXpathCountMax';
    
    protected $_defaultType;

    protected $_additionalParameter;

    public function __construct(
        $path, $defaultType = self::ASSERT_QUERY, $additionalParameter = null)
    {
        $this->_defaultType = $defaultType;
        $this->_additionalParameter = $additionalParameter;
        parent::__construct($path);
    }

    /* (non-PHPdoc)
     * @see Zend_Test_PHPUnit_Constraint_DomQuery::evaluate()
     */
    public function evaluate ($other, $assertType='', $match=false)
    {
        if ($assertType === '') {
            $assertType = $this->_defaultType;
        }
        if ($this->_additionalParameter !== null) {
            return parent::evaluate(
                $other, $assertType, $this->_additionalParameter
            );
        }
        return parent::evaluate($other, $assertType);
    }

    /* (non-PHPdoc)
     * @see Zend_Test_PHPUnit_Constraint_DomQuery::toString()
     */
    public function toString ()
    {
        return sprintf(
            'matches %s(%s%s)',
            $this->_assertType,
            var_export($this->_path, true),
            $this->_additionalParameter === null
                ? ''
                : ', ' . var_export($this->_additionalParameter, true)
        );
    }

}

// restore error reporting
error_reporting($__old_error_reporting);
unset($__old_error_reporting);