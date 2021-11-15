<?php

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Source;

trait EntityTraitWithoutVarAnnotationProperty
{
    protected ?string $otherProperty = null;
}
