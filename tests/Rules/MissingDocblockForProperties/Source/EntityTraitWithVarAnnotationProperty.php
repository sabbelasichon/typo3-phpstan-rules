<?php

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDocblockForProperties\Source;

trait EntityTraitWithVarAnnotationProperty
{
    /**
     * @var string|null
     */
    protected ?string $otherProperty = null;
}
