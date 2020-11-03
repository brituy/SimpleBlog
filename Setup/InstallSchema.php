<?php
namespace Brituy\SimpleBlog\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
class InstallSchema implements InstallSchemaInterface{
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$installer = $setup;
		$installer->startSetup();
		$tableName = $installer->getTable('brituy_blog_main');
		if ($installer->getConnection()->isTableExists($tableName) != true) {
			$table = $installer->getConnection()
				->newTable($tableName)
				->addColumn('blog_id', Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'ID')
				->addColumn('visible', Table::TYPE_BOOLEAN, null, ['nullable' => false, 'default' => '1'], 'Visible')
				->addColumn('category_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false], 'Category ID')
				->addColumn('author_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false], 'Author ID')
				->addColumn('date', Table::TYPE_DATE, null, ['nullable' => false], 'Date')
				->addColumn('title', Table::TYPE_TEXT, null, ['length' => 255, 'nullable' => false], 'Title')
				->addColumn('content', Table::TYPE_BLOB, null, ['length' => 255, 'nullable' => false], 'Content')
				->setComment('Brituy Blog Main Table');
			$installer->getConnection()->createTable($table);
		}
		$installer->endSetup();
	}
}
?>
