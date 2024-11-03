<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Observer;

use Infrangible\Core\Helper\Registry;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class ControllerActionPredispatchSalesOrderMassUnhold implements ObserverInterface
{
    /** @var string */
    public const ALLOW_UNHOLD_REGISTRY_KEY = 'infrangible_customerblock_allow_unhold';

    /** @var Registry */
    protected $registryHelper;

    public function __construct(Registry $registryHelper)
    {
        $this->registryHelper = $registryHelper;
    }

    public function execute(Observer $observer): void
    {
        $this->registryHelper->register(
            static::ALLOW_UNHOLD_REGISTRY_KEY,
            true
        );
    }
}
