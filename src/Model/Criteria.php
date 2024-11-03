<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 *
 * @method string getEmail()
 * @method string getFirstname()
 * @method string getLastname()
 * @method string getPostcode()
 * @method string getCity()
 * @method string getPaypalPayerId()
 */
class Criteria extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Criteria::class);
    }

    public function getStreet(int $line): ?string
    {
        return $this->getData('street_' . $line);
    }
}
