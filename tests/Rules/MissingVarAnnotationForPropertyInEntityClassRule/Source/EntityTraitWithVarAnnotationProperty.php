<?php

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Source;

trait EntityTraitWithVarAnnotationProperty
{
    /**
     * @var string|null
     */
    protected ?string $otherProperty = null;
}
