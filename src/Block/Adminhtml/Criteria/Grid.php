<?php /** @noinspection PhpDeprecationInspection */

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Block\Adminhtml\Criteria;

use Exception;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Grid extends \Infrangible\BackendWidget\Block\Grid
{
    protected function prepareCollection(AbstractDb $collection): void
    {
        if ($collection instanceof AbstractCollection) {
            $collection->addExpressionFieldToSelect(
                'name_city',
                "CONCAT_WS(' ', {{firstname}}, {{lastname}})",
                [
                    'firstname' => 'firstname',
                    'lastname'  => 'lastname',
                    'city'      => 'city'
                ]
            );

            $collection->addExpressionFieldToSelect(
                'shipping_address',
                "CONCAT_WS(', ', {{street_1}}, {{street_2}}, {{postcode}}, {{city}})",
                [
                    'street_1' => 'street_1',
                    'street_2' => 'street_2',
                    'postcode' => 'postcode',
                    'city'     => 'city'
                ]
            );
        }
    }

    /**
     * @throws Exception
     */
    protected function prepareFields(): void
    {
        $this->addTextColumn(
            'email',
            __('Email')->render()
        );
        $this->addTextColumn(
            'name_city',
            __('Name')->render()
        );
        $this->addTextColumn(
            'firstname',
            __('First name')->render()
        );
        $this->addTextColumn(
            'lastname',
            __('Last name')->render()
        );
        $this->addTextColumn(
            'shipping_address',
            __('Shipping Address')->render()
        );
        $this->addTextColumn(
            'street_1',
            __('Street (Address Line 1)')->render()
        );
        $this->addTextColumn(
            'street_2',
            __('House Number (Address Line 2)')->render()
        );
        $this->addTextColumn(
            'postcode',
            __('Postcode')->render()
        );
        $this->addTextColumn(
            'city',
            __('City')->render()
        );
        $this->addTextColumn(
            'paypal_payer_id',
            __('Paypal Payer Id')->render()
        );
    }

    /**
     * @return string[]
     */
    protected function getHiddenFieldNames(): array
    {
        return ['firstname', 'lastname', 'street_1', 'street_2', 'postcode', 'city'];
    }
}
