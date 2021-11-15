<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Fixture;

use Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Source\EntityTraitWithVarAnnotationProperty;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class SkipDocblockIsValidInEntityTrait extends AbstractEntity
{
    use EntityTraitWithVarAnnotationProperty;
}
