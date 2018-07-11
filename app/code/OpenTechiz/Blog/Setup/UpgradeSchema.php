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

        $tableName = $installer->getTable('opentechiz_blog_comment_approval_notification');
            $installer->getConnection()->addColumn($tableName, 'comment_id', [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => true,
                'comment' => 'Comment ID?'
            ]);

        $installer->endSetup();
    }
}