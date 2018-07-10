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
        // create notification table
        $table = $installer->getConnection()
            ->newTable($installer->getTable('opentechiz_blog_comment_approval_notification'))
            ->addColumn('noti_id', Table::TYPE_SMALLINT, null, [
               'identity' => true,
               'nullable' => false,
               'primary' => true,
            ], 'Noti ID')
            ->addColumn('content', Table::TYPE_TEXT, 255, ['nullable => false'], 'Notification Content')
            ->addColumn('user_id', Table::TYPE_SMALLINT, null, ['nullable' => false], 'User ID')
            ->addColumn('post_id', Table::TYPE_SMALLINT, null, ['nullable' => false], 'Post ID')
            ->addColumn('creation_time', Table::TYPE_TIMESTAMP, null, [], 'Comment Created At')
            ->setComment('Comment Notification');

        $installer->getConnection()->createTable($table);
        
        // modified comment table
        $tableName = $installer->getTable('opentechiz_blog_comment');
            $installer->getConnection()->addColumn($tableName, 'user_id', [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => true,
                'default' => NULL,
                'comment' => 'User ID'
            ]);

        $installer->endSetup();
    }
}