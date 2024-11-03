<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Controller\Adminhtml\Customer\Block\Criteria;

use Infrangible\CustomerBlock\Traits\Criteria;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Save
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Save
{
    use Criteria;

    protected function getObjectCreatedMessage(): string
    {
        return __('Successfully created criteria.')->render();
    }

    protected function getObjectUpdatedMessage(): string
    {
        return __('Successfully updated criteria.')->render();
    }
}
