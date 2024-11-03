<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Controller\Adminhtml\Customer\Block\Criteria;

use Infrangible\CustomerBlock\Traits\Criteria;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Delete
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Delete
{
    use Criteria;

    protected function getObjectDeletedMessage(): string
    {
        return __('Successfully deleted criteria.')->render();
    }
}
