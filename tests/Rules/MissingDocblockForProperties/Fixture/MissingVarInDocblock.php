<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Fixture;

final class MissingVarInDocblock extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * This is only a description
     */
    protected ?string $property = null;
}
