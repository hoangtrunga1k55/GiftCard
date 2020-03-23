<?php

namespace Mageplaza\GiftCard\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.5.0', '<')) {
            $table = $installer->getTable('customer_entity');
            if ($setup->getConnection()->isTableExists($table) == true) {
                $columns = [
                    'giftcard_balance' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'giftcard_balance',
                    ],
                ];
                $connection = $setup->getConnection();

                foreach ($columns as $name => $definition) {
                    $connection->addColumn($table, $name, $definition);
                }


                if (!$installer->tableExists('giftcard_history')) {
                    $table1 = $installer->getConnection()->newTable(
                        $installer->getTable('giftcard_history')
                    )
                        ->addColumn(
                            'history_id',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            null,
                            [
                                'identity' => true,
                                'primary' => true,
                                'nullable' => false,
                                'unsigned' => true,
                            ],
                            'history_id'
                        )
                        ->addColumn(
                            'giftcard_id',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            null,
                            ['unsigned' => true, 'nullable' => false, 'index' => true],
                            'GiftCard Id'
                        )
                        ->addColumn(
                            'amount',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            null,
                            ['nullable' => false],
                            'amount'
                        )
                        ->addColumn(
                            'action',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                            255,
                            ['nullable' => false],
                            'action'
                        )->addColumn(
                            'action_time',
                            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                            null,
                            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                            'action_time'
                        )
                        ->addColumn(
                            'customer_id',
                            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                            null,
                            ['unsigned' => true, 'nullable' => false, 'index' => true],
                            'Customer id'
                        )
                        ->addForeignKey(
                            $installer->getFkName('giftcard_history', 'giftcard_id', 'giftcard_code', 'giftcard_id'),
                            'giftcard_id',
                            $installer->getTable('giftcard_code'),
                            'giftcard_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                        )
                        ->addForeignKey(
                            $installer->getFkName('giftcard_history', 'customer_id', 'customer_entity', 'entity_id'),
                            'customer_id',
                            $installer->getTable('customer_entity'),
                            'entity_id',
                            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                        );
                    $installer->getConnection()->createTable($table1);
                }
                $installer->endSetup();
            }
        }
    }
}
