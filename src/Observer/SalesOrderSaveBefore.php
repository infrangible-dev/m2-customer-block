<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Observer;

use Exception;
use Infrangible\Core\Helper\Registry;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class SalesOrderSaveBefore implements ObserverInterface
{
    /** @var string */
    public const ALLOW_UNHOLD_REGISTRY_KEY = 'infrangible_customerblock_allow_unhold';

    /** @var Registry */
    protected $registryHelper;

    /** @var LoggerInterface */
    protected $logging;

    public function __construct(Registry $registryHelper, LoggerInterface $logging)
    {
        $this->registryHelper = $registryHelper;
        $this->logging = $logging;
    }

    public function execute(Observer $observer): void
    {
        /** @var Order $order */
        $order = $observer->getData('order');

        if ($this->_isStateChangeFrom(
                $order,
                Order::STATE_HOLDED
            ) && (int)$order->getData('is_blocked')) {
            if (! $this->registryHelper->registry(static::ALLOW_UNHOLD_REGISTRY_KEY)) {
                try {
                    $order->hold();
                } catch (Exception $exception) {
                    $this->logging->error($exception);
                }
            } else {
                $order->setData(
                    'is_blocked',
                    0
                );
                $order->setData(
                    'is_unblocked',
                    1
                );
            }
        }
    }

    protected function _isStateChangeFrom(Order $order, string $state): bool
    {
        return (($order->getOrigData('state') == $state && $order->getData('state') != $state) ||
            ($order->getOrigData('status') == $state && $order->getData('status') != $state));
    }
}
