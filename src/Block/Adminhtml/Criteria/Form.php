<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Block\Adminhtml\Criteria;

use Magento\Framework\Data\Form\Element\Fieldset;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Form extends \Infrangible\BackendWidget\Block\Form
{
    protected function isAddress(): bool
    {
        return true;
    }

    protected function isCustomer(): bool
    {
        return true;
    }

    protected function isEMail(): bool
    {
        return true;
    }

    protected function isPaypal(): bool
    {
        return true;
    }

    protected function prepareFields(\Magento\Framework\Data\Form $form): void
    {
        $criteriaFieldSet = $form->addFieldset(
            'criteria',
            ['legend' => __('Criteria')]
        );

        $this->prepareCriteriaFields($criteriaFieldSet);
    }

    protected function prepareCriteriaFields(Fieldset $criteriaFieldSet): void
    {
        if ($this->isEMail()) {
            $this->addTextField(
                $criteriaFieldSet,
                'email',
                __('Email')->render()
            );
        }

        if ($this->isCustomer()) {
            $this->addTextField(
                $criteriaFieldSet,
                'firstname',
                __('First name')->render()
            );
            $this->addTextField(
                $criteriaFieldSet,
                'lastname',
                __('Last name')->render()
            );
        }

        if ($this->isAddress()) {
            $this->addTextField(
                $criteriaFieldSet,
                'street_1',
                __('Street (Address Line 1)')->render()
            );
            $this->addTextField(
                $criteriaFieldSet,
                'street_2',
                __('House Number (Address Line 2)')->render()
            );
            $this->addTextField(
                $criteriaFieldSet,
                'postcode',
                __('Postcode')->render()
            );
        }

        if ($this->isAddress() || $this->isCustomer()) {
            $this->addTextField(
                $criteriaFieldSet,
                'city',
                __('City')->render()
            );
        }

        if ($this->isPaypal()) {
            $this->addTextField(
                $criteriaFieldSet,
                'paypal_payer_id',
                __('Paypal Payer Id')->render()
            );
        }
    }
}
