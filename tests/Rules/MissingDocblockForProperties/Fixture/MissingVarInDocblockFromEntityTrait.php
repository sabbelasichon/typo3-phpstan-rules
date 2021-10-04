<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Fixture;

use Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Source\EntityTraitWithoutVarAnnotationProperty;

final class MissingVarInDocblockFromEntityTrait extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    use EntityTraitWithoutVarAnnotationProperty;
}
