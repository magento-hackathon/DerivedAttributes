Status: WIP

Build status (master): [![Build Status](https://travis-ci.org/magento-hackathon/DerivedAttributes.svg?branch=master)](https://travis-ci.org/magento-hackathon/DerivedAttributes)

DerivedAttributes (e.g. for product feed export)
================================================

(Product Attribute, Customer Attributes) 

Installation Instructions
-------------------------

### Option 1: Via Composer
1. Install via composer: `composer require magento-hackathon/derived-attributes`

### Option 2: Manually
1. Download hackathon-derivedattributes.tar.gz or hackathon-derivedattributes.zip from the [Releases page](https://github.com/magento-hackathon/DerivedAttributes/releases)
2. Extract contained directory into your Magento installation. It contains all dependencies, no additional downloads necessary.

Interfaces:
-----------

### GeneratorInterface
 - mixed generate(Entity, RuleEntity)
 - string getTitle()
 - string getDescription()

### FilterInterface
 - mixed filter(Entity, FilterEntity, mixed $current)
 - string getTitle()
 - string getDescription()

### ConditionInterface (ex. impl. BooleanAttributeCondition)
 - bool match(Entity, RuleEntity)
 - string getTitle()
 - string getDescription()


Database
--------

### derivedattribute_rule
  - id
  - title
  - description
  - attribute_id
  - generator_type
  - generator_data
  - condition_type
  - condition_data
  - store_id
  - active
  - priority
  - [date_from]
  - [date_to]
  
### [derivedattribute_filter]
  - id
  - da_id
  - filter_type
  - filter_data
  - sort_order
  - active

### [derived_attribute_condition]
  - id
  - da_id
  - active
  - condition_type
  - condition_data
  - parent_id (?)


Magento Bridge
--------------

- EntityInterface
- DerivedAttributeRuleInterface
- DerivedAttributeFilterInterface
- [DerivedAttributeConditionInterface]


Transitivity of DerivedAttributes
---
There is NO magic for "derived of derivedAttributes". Just rule priority.


License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)
