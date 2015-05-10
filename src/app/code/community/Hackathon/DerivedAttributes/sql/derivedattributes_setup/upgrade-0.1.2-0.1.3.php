<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();
$ruleTable = $this->getTable('derivedattributes/rule');

$installer->getConnection()->dropForeignKey($ruleTable, 'fk_derivedattributes_rule_2');
$installer->getConnection()->modifyColumn($ruleTable, 'store_id', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length'   => 255,
    'nullable' => false,
    'comment'  => 'Rule name'
));
$installer->getConnection()->resetDdlCache($ruleTable);

$installer->endSetup();