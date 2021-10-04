<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Fixture;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class SkipDocblockIsValid extends AbstractEntity
{
    /**
     * @var string|null
     */
    protected ?string $property = null;
}
