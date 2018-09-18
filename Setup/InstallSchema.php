<?php
/**
 * Mage-World
 *
 *  @category    Mage-World
 *  @package     MW
 *  @author      Mage-world Developer
 *
 *  @copyright   Copyright (c) 2018 Mage-World (https://www.mage-world.com/)
 */

namespace MW\EasyFaq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package MW\EasyFaq\Setup
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $setup->getConnection()->dropTable($setup->getTable('mw_faq_category'));
        $setup->getConnection()->dropTable($setup->getTable('mw_faq'));
        $table  = $setup->getConnection()
            ->newTable($setup->getTable('mw_faq_category'))
            ->addColumn(
                'category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Category Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '',
                ['nullable' => false],
                'Category Name'
            )->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '',
                ['nullable' => true],
                'Category Description'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => true],
                'Sort Order'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false, 'default' => 0],
                'Store Id'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Status'
            );
        $setup->getConnection()->createTable($table);

        $table  = $setup->getConnection()
            ->newTable($setup->getTable('mw_faq'))
            ->addColumn(
                'faq_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Faq Id'
            )->addColumn(
                'category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false,'unsigned' => true],
                'Category Id'
            )->addColumn(
                'question',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '',
                ['nullable' => false],
                'Faq Question'
            )->addColumn(
                'answer',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '',
                ['nullable' => true],
                'Faq Answer'
            )->addColumn(
                'sort_order',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => true],
                'Sort Order'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['nullable' => false],
                'Status'
            )->addIndex(
                $setup->getIdxName('mw_faq', ['category_id']),
                ['category_id']
            )->addForeignKey(
                $setup->getFkName(
                    'mw_faq',
                    'category_id',
                    'mw_faq_category',
                    'category_id'
                ),
                'category_id',
                $setup->getTable('mw_faq_category'),
                'category_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }
}