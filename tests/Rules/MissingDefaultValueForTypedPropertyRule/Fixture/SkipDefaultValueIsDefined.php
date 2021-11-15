<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDefaultValueForTypedPropertyRule\Fixture;

final class SkipDefaultValueIsDefined extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $property = '';

    protected ?string $property2 = null;
}
