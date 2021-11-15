<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDefaultValueForTypedPropertyRule\Fixture;

final class MissingDefaultValue extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $property;
}
