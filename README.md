WIP: DerivedAttributes

Interfaces:
---

GeneratorInterface
 - mixed generate(Entity, RuleEntity)
 - string getTitle()
 - string getDescription()

FilterInterface
 - mixed filter(Entity, FilterEntity, mixed $current)
 - string getTitle()
 - string getDescription()

ConditionInterface (ex. impl. BooleanAttributeCondition)
 - bool match(Entity, RuleEntity)
 - string getTitle()
 - string getDescription()


Database
---

- derivedattribute_rule
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
  - -date_from-
  - -date_to´-
- derivedattribute_filter
  - id
  - da_id
  - filter_type
  - filter_data
  - sort_order
  - active
- -derived_attribute_condition-
  - id
  - da_id
  - active
  - condition_type
  - condition_data
 - parent_id (?)


Magento Bridge
---

- EntityInterface
- DerivedAttributeRuleInterface
- DerivedAttributeFilterInterface
- -DerivedAttributeConditionInterface-


Ideas for later
---

- einzelne daten pro store view ändern (generator_data, active, ...) mit EAV entity
- conditions für einzelne filter
- optimierung / vorberechnung der conditions
- auch für kunden und andere entities
- "test produkt x" oder "dry run"


Tasks
---
Define Interfaces
Create Magento Entities and implement Bridge Interfaces