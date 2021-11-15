<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Fixture;

use Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Source\EntityTraitWithoutVarAnnotationProperty;

final class SkipMissingDocblockNotInEntityFromTrait
{
    use EntityTraitWithoutVarAnnotationProperty;
}
