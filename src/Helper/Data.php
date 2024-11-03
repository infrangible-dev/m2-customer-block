<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Helper;

use Exception;
use Infrangible\Core\Helper\Stores;
use Infrangible\CustomerBlock\Model\ResourceModel\Criteria\Collection;
use Infrangible\CustomerBlock\Model\ResourceModel\Criteria\CollectionFactory;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Data
{
    /** @var Stores */
    protected $storeHelper;

    /** @var LoggerInterface */
    protected $logging;

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var TransportBuilder */
    protected $transportBuilder;

    public function __construct(
        Stores $storeHelper,
        LoggerInterface $logging,
        CollectionFactory $collectionFactory,
        TransportBuilder $transportBuilder
    ) {
        $this->storeHelper = $storeHelper;
        $this->logging = $logging;
        $this->collectionFactory = $collectionFactory;
        $this->transportBuilder = $transportBuilder;
    }

    public function isBlockedEmail(string $email): bool
    {
        $collection = $this->_getCollection();

        $collection->addFieldToFilter(
            'email',
            $email
        );

        return $collection->getSize() > 0;
    }

    public function isBlockedCustomer(?string $firstname, ?string $lastname, ?string $city): bool
    {
        $collection = $this->_getCollection();

        $collection->addFieldToFilter(
            'firstname',
            $firstname
        );
        $collection->addFieldToFilter(
            'lastname',
            $lastname
        );
        $collection->addFieldToFilter(
            'city',
            $city
        );

        return $collection->getSize() > 0;
    }

    public function isBlockedAddress(string $street1, string $street2, string $postcode, string $city): bool
    {
        $collection = $this->_getCollection();

        if ($street1 !== '') {
            $collection->addFieldToFilter(
                'street_1',
                $street1
            );
        }

        if ($street2 !== '') {
            $collection->addFieldToFilter(
                'street_2',
                $street2
            );
        }

        if ($postcode !== '') {
            $collection->addFieldToFilter(
                'postcode',
                $postcode
            );
        }

        if ($city !== '') {
            $collection->addFieldToFilter(
                'city',
                $city
            );
        }

        return $collection->getSize() > 0;
    }

    public function isBlockedPaypalPayerId(string $payerId): bool
    {
        $collection = $this->_getCollection();

        $collection->addFieldToFilter(
            'paypal_payer_id',
            $payerId
        );

        return $collection->getSize() > 0;
    }

    protected function _getCollection(): Collection
    {
        return $this->collectionFactory->create();
    }

    public function sendOrderNotification(Order $order): void
    {
        try {
            $receiver =
                $this->storeHelper->getExplodedConfigValues('infrangible_customerblock/order_notification/receiver');

            if ($receiver) {
                $sender = $this->storeHelper->getStoreConfig('infrangible_customerblock/order_notification/identity');
                $templateIdentifier =
                    $this->storeHelper->getStoreConfig('infrangible_customerblock/order_notification/template');

                /** @noinspection PhpDeprecationInspection */
                $this->transportBuilder->setFrom($sender);
                foreach ($receiver as $email) {
                    $this->transportBuilder->addTo($email);
                }

                $this->transportBuilder->setTemplateIdentifier($templateIdentifier);
                $this->transportBuilder->setTemplateOptions([
                    'area'  => Area::AREA_FRONTEND,
                    'store' => $this->storeHelper->getStore()->getId()
                ]);
                $this->transportBuilder->setTemplateVars(['order' => $order]);

                $transport = $this->transportBuilder->getTransport();

                $transport->sendMessage();
            }
        } catch (Exception $exception) {
            $this->logging->error($exception);
        }
    }
}
