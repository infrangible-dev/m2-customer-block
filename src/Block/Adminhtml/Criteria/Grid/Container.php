<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Grid;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Container extends \Infrangible\BackendWidget\Block\Grid\Container
{
    protected function _construct(): void
    {
        parent::_construct();

        $this->buttonList->remove('add');

        $this->buttonList->add(
            'add_customer',
            [
                'label'   => __('Add Customer'),
                'onclick' => 'setLocation(\'' . $this->getUrl(
                        '*/*/add',
                        ['type' => 'customer']
                    ) . '\')',
                'class'   => 'add primary',
            ]
        );

        $this->buttonList->add(
            'add_email',
            [
                'label'   => __('Add Email'),
                'onclick' => 'setLocation(\'' . $this->getUrl(
                        '*/*/add',
                        ['type' => 'email']
                    ) . '\')',
                'class'   => 'add primary',
            ]
        );

        $this->buttonList->add(
            'add_address',
            [
                'label'   => __('Add Address'),
                'onclick' => 'setLocation(\'' . $this->getUrl(
                        '*/*/add',
                        ['type' => 'address']
                    ) . '\')',
                'class'   => 'add primary',
            ]
        );

        $this->buttonList->add(
            'add_paypal',
            [
                'label'   => __('Add Paypal'),
                'onclick' => 'setLocation(\'' . $this->getUrl(
                        '*/*/add',
                        ['type' => 'paypal']
                    ) . '\')',
                'class'   => 'add primary',
            ]
        );
    }
}
