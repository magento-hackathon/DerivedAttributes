Status: WIP

Build status (master): [![Build Status](https://travis-ci.org/magento-hackathon/DerivedAttributes.svg?branch=master)](https://travis-ci.org/magento-hackathon/DerivedAttributes)

DerivedAttributes (e.g. for product feed export)
================================================

(Product Attribute, Customer Attributes) 

Installation Instructions
-------------------------

### Option 1: Via Composer
1. Add required repositories to project `composer.json`:

        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/magento-hackathon/DerivedAttributes.git"
            },
            {
                "type": "vcs",
                "url": "https://github.com/integer-net/IntegerNet_GridMassActionPager"
            }
        ]

2. Install via composer: `composer require magento-hackathon/derived-attributes`

### Option 2: Manually
1. Download hackathon-derivedattributes.tar.gz or hackathon-derivedattributes.zip from the [Releases page](https://github.com/magento-hackathon/DerivedAttributes/releases)
2. Extract contained directory into your Magento installation. It contains all dependencies, no additional downloads necessary.


Add custom conditions and generators
-----------

Custom conditions and generators must implement the interfaces listed below.
To add them, create an observer for the `derivedattribute_new_rulemanager` event:
 
         <events>
             <derivedattribute_new_rulemanager>
                 <observers>
                     <your_module>
                         <type>singleton</type>
                         <class>Your_Module_Model_Observer</class>
                         <method>addDerivedAttributesPlugin</method>
                     </your_module>
                 </observers>
             </derivedattribute_new_rulemanager>
         </events>

In this observer:
        
        class Your_Module_Model_Observer
        {
            public function addDerivedAttributesPlugin(Varien_Event_Observer $observer)
            {
                /** @var \Hackathon\DerivedAttributes\Service\Manager $ruleManager */
                $ruleManager = $observer->getRuleManager();
                $ruleManager->addConditionType('your_unique_condition_identifier', Mage::getModel('your_module/your_condition_class'));
                $ruleManager->addGeneratorType('your_unique_generator_identifier', Mage::getModel('your_module/your_generator_class'));
            }
        }

## Interfaces

### GeneratorInterface

    GeneratorInterface configure(string $data)
    string getData()
    mixed generateAttributeValue(EntityInterface $entity)
    string getTitle()
    string getDescription()
    
### ConditionInterface (ex. impl. BooleanAttributeCondition)

    ConditionInterface configure(string $data)
    string getData()
    boolean match(EntityInterface $entity)
    string getTitle()
    string getDescription()



Transitivity of DerivedAttributes
---
There is NO magic for "derived of derivedAttributes". Just rule priority.


License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)
