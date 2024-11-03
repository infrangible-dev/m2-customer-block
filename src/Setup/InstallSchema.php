<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Setup;

use Exception;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Psr\Log\LoggerInterface;
use Zend_Db_Exception;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class InstallSchema implements InstallSchemaInterface
{
    /** @var LoggerInterface */
    protected $logging;

    public function __construct(LoggerInterface $logging)
    {
        $this->logging = $logging;
    }

    /**
     * @throws Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        $tableName = $setup->getTable('customer_block_criteria');

        if (! $connection->isTableExists($tableName)) {
            try {
                $table = $connection->newTable($tableName);
                $table->addColumn(
                    'criteria_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary'  => true,
                    ]
                );
                $table->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255
                );
                $table->addColumn(
                    'firstname',
                    Table::TYPE_TEXT,
                    255
                );
                $table->addColumn(
                    'lastname',
                    Table::TYPE_TEXT,
                    255
                );
                $table->addColumn(
                    'street_1',
                    Table::TYPE_TEXT,
                    255
                );
                $table->addColumn(
                    'street_2',
                    Table::TYPE_TEXT,
                    255
                );
                $table->addColumn(
                    'postcode',
                    Table::TYPE_TEXT,
                    5
                );
                $table->addColumn(
                    'city',
                    Table::TYPE_TEXT,
                    255
                );
                $table->addColumn(
                    'paypal_payer_id',
                    Table::TYPE_TEXT,
                    255
                );
                $table->setComment('Criteria');

                $connection->createTable($table);
            } catch (Zend_Db_Exception $exception) {
                $this->logging->error($exception);
                /** @noinspection PhpUnhandledExceptionInspection */
                throw new Exception($exception);
            }
        }

        $table = $setup->getTable('sales_order');

        $column = 'is_blocked';

        if (! $connection->tableColumnExists(
            $table,
            $column
        )) {
            $connection->addColumn(
                $table,
                $column,
                [
                    'type'    => Table::TYPE_SMALLINT,
                    'comment' => 'Is Order Blocked',
                    'default' => 0
                ]
            );
        }

        $column = 'is_unblocked';

        if (! $connection->tableColumnExists(
            $table,
            $column
        )) {
            $connection->addColumn(
                $table,
                $column,
                [
                    'type'    => Table::TYPE_SMALLINT,
                    'comment' => 'Is Order Un-Blocked',
                    'default' => 0
                ]
            );
        }

        $setup->endSetup();
    }
}
