<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Observer;

use Magento\CatalogInventory\Observer\CancelOrderItemObserver;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Item;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class SalesOrderItemCancel implements ObserverInterface
{
    /** @var CancelOrderItemObserver */
    protected $cancelOrderItemObserver;

    public function __construct(CancelOrderItemObserver $cancelOrderItemObserver)
    {
        $this->cancelOrderItemObserver = $cancelOrderItemObserver;
    }

    public function execute(Observer $observer): void
    {
        /** @var Item $item */
        $item = $observer->getData('item');

        $order = $item->getOrder();

        if (! $order || ! $order->getData('is_blocked')) {
            $this->cancelOrderItemObserver->execute($observer);
        }
    }
}
