<?php
declare(strict_types=1);


namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseNullableConstructorRule\Fixture;


use Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseNullableConstructorRule\Source\MyService;

final class ClassWithProperConstructor
{
    public function __construct(MyService $myService)
    {
    }
}
