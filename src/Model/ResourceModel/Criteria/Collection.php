<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Model\ResourceModel\Criteria;

use Infrangible\CustomerBlock\Model\Criteria;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(
            Criteria::class,
            \Infrangible\CustomerBlock\Model\ResourceModel\Criteria::class
        );
    }
}
