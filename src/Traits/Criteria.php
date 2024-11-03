<?php

declare(strict_types=1);

namespace Infrangible\CustomerBlock\Traits;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
trait Criteria
{
    protected function getModuleKey(): string
    {
        return 'Infrangible_CustomerBlock';
    }

    protected function getResourceKey(): string
    {
        return 'infrangible_customerblock';
    }

    protected function getMenuKey(): string
    {
        return 'infrangible_customerblock_manage';
    }

    protected function getObjectName(): string
    {
        return 'Criteria';
    }

    protected function getObjectField(): ?string
    {
        return 'criteria_id';
    }

    protected function getTitle(): string
    {
        return __('Criteria')->render();
    }

    protected function allowAdd(): bool
    {
        return true;
    }

    protected function allowEdit(): bool
    {
        return true;
    }

    protected function allowView(): bool
    {
        return false;
    }

    protected function allowDelete(): bool
    {
        return true;
    }

    protected function getObjectNotFoundMessage(): string
    {
        return __('Could not find criteria with id: %s')->render();
    }
}
