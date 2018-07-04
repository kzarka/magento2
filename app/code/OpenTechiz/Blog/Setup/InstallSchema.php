<?php
namespace OpenTechiz\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$installer = $setup;

	    $installer->startSetup();
	    $table = $installer->getConnection()
	        ->newTable($installer->getTable('opentechiz_blog_post'))
	        ->addColumn('post_id', Table::TYPE_SMALLINT, null, [
	            'identity' => true,
	            'nullable' => false,
	            'primary' => true,
	        ], 'Post ID')
	        ->addColumn('url_key', Table::TYPE_TEXT, 100, [], 'Post URL Key')
	        ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable => false'], 'Blog Title')
	        ->addColumn('content', Table::TYPE_TEXT, '2M', [], 'Blog Content')
	        ->addColumn('is_active', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Is Post Active?')
	        ->addColumn('update_time', Table::TYPE_TIMESTAMP, null, [], 'Post Updated At')
	        ->addColumn('creation_time', Table::TYPE_TIMESTAMP, null, [], 'Post Created At')
	        ->addIndex($installer->getIdxName('opentechiz_blog_category', ['url_key']),['url_key'])
	        ->setComment('Post Table');
	    $installer->getConnection()->createTable($table);
	}
	
}
