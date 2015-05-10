<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();
$ruleTable = $this->getTable('derivedattributes/rule');

$installer->getConnection()->addColumn($ruleTable, 'name', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
    'size'     => 255,
    'nullable' => false,
    'comment'  => 'Rule name'
));
$installer->getConnection()->addColumn($ruleTable, 'name', array(
    'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
    'size'     => 65536,
    'nullable' => false,
    'default'  => '',
    'comment'  => 'Rule Description'
));

$installer->endSetup();