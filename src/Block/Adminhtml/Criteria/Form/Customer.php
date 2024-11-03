<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Form;

use Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Form;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Customer extends Form
{
    protected function isAddress(): bool
    {
        return false;
    }

    protected function isEMail(): bool
    {
        return false;
    }

    protected function isPaypal(): bool
    {
        return false;
    }
}
