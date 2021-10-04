<?php

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Source;

trait EntityTraitWithoutVarAnnotationProperty
{
    protected ?string $otherProperty = null;
}
