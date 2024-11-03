<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Controller\Adminhtml\Customer\Block\Criteria;

use Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Form\Address;
use Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Form\Customer;
use Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Form\Email;
use Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Form\Paypal;
use Infrangible\CustomerBlock\Traits\Criteria;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Edit
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Edit
{
    use Criteria;

    protected function getFormContentBlockType(): ?string
    {
        $type = $this->getRequest()->getParam('type', 'form');

        if ($type === 'address') {
            return Address::class;
        } else if ($type === 'customer') {
            return Customer::class;
        } else if ($type === 'email') {
            return Email::class;
        } else if ($type === 'paypal') {
            return Paypal::class;
        }

        return parent::getFormContentBlockType();
    }
}
