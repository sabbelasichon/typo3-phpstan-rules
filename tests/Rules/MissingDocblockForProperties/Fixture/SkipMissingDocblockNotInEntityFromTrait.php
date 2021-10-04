<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Fixture;

use Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Source\EntityTraitWithoutVarAnnotationProperty;

final class SkipMissingDocblockNotInEntityFromTrait
{
    use EntityTraitWithoutVarAnnotationProperty;
}
