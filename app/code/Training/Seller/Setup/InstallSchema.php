<?php
/**
 * Module Training/Seller
 */

namespace Training\Seller\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Training\Seller\Api\Data\SellerInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @inheritdoc}
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = $setup->getTable(SellerInterface::TABLE_NAME);

        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                SellerInterface::FIELD_SELLER_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )->addColumn(
                SellerInterface::FIELD_IDENTIFIER,
                Table::TYPE_TEXT,
                64,
                ['nullable' => false]
            )->addColumn(
                SellerInterface::FIELD_NAME,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false]
            )->addColumn(
                SellerInterface::FIELD_CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT]
            )->addColumn(
                SellerInterface::FIELD_UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE]
            )->addIndex(
                $setup->getIdxName(
                    SellerInterface::TABLE_NAME,
                    [SellerInterface::FIELD_IDENTIFIER],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [SellerInterface::FIELD_IDENTIFIER],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->setComment(
                'Training - Seller'
            );

        $setup->startSetup();
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}
