<?php
namespace OpenTechiz\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
        $installer = $setup;

    	$installer->startSetup();
    	if (version_compare($context->getVersion(), "1.2.5", "<")) {
		    $tableName = $installer->getTable('opentechiz_blog_comment');
            $installer->getConnection()->addColumn($tableName, 'email', [
                'type' => Table::TYPE_TEXT,
                'length' => 100,
                'nullable' => false,
                'comment' => 'Email'
            ]);
		}

    	$installer->endSetup();
    }
}