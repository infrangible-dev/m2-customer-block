<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Observer;

use Exception;
use Infrangible\CustomerBlock\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Address;
use Magento\Sales\Model\Order\Payment;
use Magento\Sales\Model\ResourceModel\OrderFactory;
use Psr\Log\LoggerInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class SalesOrderSaveAfter implements ObserverInterface
{
    /** @var Data */
    protected $helper;

    /** @var LoggerInterface */
    protected $logging;

    /** @var OrderFactory */
    protected $resourceFactory;

    public function __construct(
        Data $helper,
        LoggerInterface $logging,
        OrderFactory $resourceFactory
    ) {
        $this->helper = $helper;
        $this->logging = $logging;
        $this->resourceFactory = $resourceFactory;
    }

    public function execute(Observer $observer): void
    {
        /** @var Order $order */
        $order = $observer->getData('order');

        if ($order->getData('is_unblocked')) {
            return;
        }

        try {
            /** @var Payment $payment */
            $payment = $order->getPayment();

            $checkOrderStatus = $payment->getMethodInstance()->getConfigData('order_status');
        } catch (LocalizedException $exception) {
            $this->logging->error($exception);

            $checkOrderStatus = Order::STATE_PROCESSING;
        }

        if ($checkOrderStatus === null) {
            $checkOrderStatus = Order::STATE_PROCESSING;
        }

        if ($this->_isStateChangeTo(
            $order,
            $checkOrderStatus
        )) {
            // status-change detected that triggers check
            try {
                if ($this->isBlockedByEmail($order) || $this->isBlockedByAddress($order->getShippingAddress()) ||
                    $this->isBlockedByCustomer($order) || $this->isBlockedByPaypalPayerId($order)) {
                    // order matches block criteria

                    $order->hold();
                    $order->setData(
                        'is_blocked',
                        1
                    );

                    $this->resourceFactory->create()->save($order);

                    $this->helper->sendOrderNotification($order);
                }
            } catch (Exception $exception) {
                $this->logging->error($exception);
            }
        }
    }

    protected function _isStateChangeTo(Order $order, string $state): bool
    {
        return (($order->getOrigData('state') != $state && $order->getData('state') == $state) ||
            ($order->getOrigData('status') != $state && $order->getData('status') == $state));
    }

    public function isBlockedByEmail(Order $order): bool
    {
        return $this->helper->isBlockedEmail($order->getCustomerEmail());
    }

    public function isBlockedByCustomer(Order $order): bool
    {
        $firstNames = [$order->getCustomerFirstname()];
        $lastNames = [$order->getCustomerLastname()];
        $cities = [];

        foreach ($order->getAddresses() as $address) {
            $firstNames[] = $address->getFirstname();
            $lastNames[] = $address->getLastname();
            $cities[] = $address->getCity();
        }

        $firstNames = array_unique($firstNames);
        $lastNames = array_unique($lastNames);
        $cities = array_unique($cities);

        foreach ($firstNames as $firstname) {
            foreach ($lastNames as $lastname) {
                foreach ($cities as $city) {
                    if ($this->helper->isBlockedCustomer(
                        $firstname,
                        $lastname,
                        $city
                    )) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function isBlockedByAddress(Address $address): bool
    {
        return $this->helper->isBlockedAddress(
            $address->getStreetLine(1),
            $address->getStreetLine(2),
            $address->getPostcode(),
            $address->getCity()
        );
    }

    public function isBlockedByPaypalPayerId(Order $order): bool
    {
        $payment = $order->getPayment();

        if ($payment) {
            $additionalInformation = $payment->getAdditionalInformation();
            if (is_string($additionalInformation)) {
                $additionalInformation = @unserialize($additionalInformation);
            }

            if (is_array($additionalInformation) && isset($additionalInformation[ 'paypal_payer_id' ])) {
                return $this->helper->isBlockedPaypalPayerId($additionalInformation[ 'paypal_payer_id' ]);
            }
        }

        return false;
    }
}
