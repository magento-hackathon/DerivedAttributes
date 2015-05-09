<?php

$installer = $this;

$installer->startSetup();

// install table
$createTableStatements = '

    CREATE TABLE `derivedattributes_rule` (
      `rule_id` int(11) NOT NULL AUTO_INCREMENT,
      `attribute_id` smallint(5) unsigned NOT NULL,
      `generator_type` varchar(64) DEFAULT NULL,
      `generator_data` tinytext,
      `condition_type` varchar(64) DEFAULT NULL,
      `condition_data` tinytext,
      `store_id` smallint(5) unsigned DEFAULT NULL,
      `active` tinyint(4) NOT NULL DEFAULT '1',
      `priority` int(11) DEFAULT '0',
      PRIMARY KEY (`rule_id`),
      KEY `fk_derivedattributes_rule_1_idx` (`attribute_id`),
      KEY `fk_derivedattributes_rule_2_idx` (`store_id`),
      CONSTRAINT `fk_derivedattributes_rule_2` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
      CONSTRAINT `fk_derivedattributes_rule_1` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE `derivedattributes_rule_condition` (
      `rule_condition_id` int(11) NOT NULL AUTO_INCREMENT,
      `rule_id` int(11) DEFAULT NULL,
      `condition_type` varchar(64) DEFAULT NULL,
      `condition_data` tinytext,
      `active` tinyint(4) NOT NULL DEFAULT '1',
      PRIMARY KEY (`rule_condition_id`),
      KEY `fk_derivedattributes_rule_condition_1_idx` (`rule_id`),
      CONSTRAINT `fk_derivedattributes_rule_condition_1` FOREIGN KEY (`rule_id`) REFERENCES `derivedattributes_rule` (`rule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE `derivedattributes_rule_filter` (
      `rule_filter_id` int(11) NOT NULL AUTO_INCREMENT,
      `rule_id` int(11) DEFAULT NULL,
      `filter_type` varchar(64) DEFAULT NULL,
      `filter_data` tinytext,
      `active` tinyint(4) NOT NULL DEFAULT '1',
      `priority` int(11) DEFAULT '0',
      PRIMARY KEY (`rule_filter_id`),
      KEY `fk_derivedattributes_rule_filter_1_idx` (`rule_id`),
      CONSTRAINT `fk_derivedattributes_rule_filter_1` FOREIGN KEY (`rule_id`) REFERENCES `derivedattributes_rule` (`rule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

';
$installer->run($createTableStatements);

$installer->endSetup();
