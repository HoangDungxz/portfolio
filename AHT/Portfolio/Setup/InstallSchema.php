<?php
namespace AHT\Portfolio\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
		$connection = $installer->getConnection();
		if (!$installer->tableExists('portfolio')) {
			$table = $installer->getConnection()->newTable($installer->getTable('portfolio'))
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true,
					'nullable' => false,
					'primary'  => true,
					'unsigned' => true,
				],
				'ID'
			)
			->addColumn(
				'title',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				100,
				['nullable => false'],
				'Title'
			)
			->addColumn(
				'images',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[],
				'Images'
			)
			->addColumn(
				'description',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				50,
				[],
				'Description'
			)			
			->setComment('Portfolio Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('portfolio'),
				$setup->getIdxName(
					$installer->getTable('portfolio'),
					['title', 'images', 'description'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['title', 'images', 'description'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}