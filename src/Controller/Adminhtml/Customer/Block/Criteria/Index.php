<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Controller\Adminhtml\Customer\Block\Criteria;

use Infrangible\CustomerBlock\Block\Adminhtml\Criteria\Grid\Container;
use Infrangible\CustomerBlock\Traits\Criteria;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Index
    extends \Infrangible\BackendWidget\Controller\Backend\Object\Index
{
    use Criteria;

    protected function getGridBlockType(): string
    {
        return Container::class;
    }
}
