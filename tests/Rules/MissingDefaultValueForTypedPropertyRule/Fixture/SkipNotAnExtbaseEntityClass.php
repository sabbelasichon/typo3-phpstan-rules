<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDefaultValueForTypedPropertyRule\Fixture;

use Ssch\Typo3PhpstanRules\Tests\Rules\MissingDefaultValueForTypedPropertyRule\Source\AbstractNotAnExtbaseEntity;

final class SkipNotAnExtbaseEntityClass extends AbstractNotAnExtbaseEntity
{
    protected string $property = '';
}
