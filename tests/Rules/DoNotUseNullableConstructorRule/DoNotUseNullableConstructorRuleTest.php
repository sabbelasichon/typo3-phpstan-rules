<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseNullableConstructorRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Ssch\Typo3PhpstanRules\Rules\DoNotUseNullableConstructorRule;

/**
 * @extends RuleTestCase<DoNotUseNullableConstructorRule>
 */
final class DoNotUseNullableConstructorRuleTest extends RuleTestCase
{
    /**
     * @dataProvider provideDataWithErrors()
     * @param list<array{0: string, 1: int, 2?: string}> $expectedErrorMessagesWithLines
     */
    public function testRuleWithErrors(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    /**
     * @dataProvider provideDataWithoutErrors()
     */
    public function testRuleWithoutErrors(string $filePath): void
    {
        $this->analyse([$filePath], []);
    }

    public function provideDataWithErrors(): Iterator
    {
        yield [
            __DIR__ . '/Fixture/ClassWithNullableConstructor.php',
            [['Do not use nullable argument in constructor', 12]],
        ];

        yield [
            __DIR__ . '/Fixture/ClassWithNullableUnionTypeConstructor.php',
            [['Do not use nullable argument in constructor', 12]],
        ];
    }

    public function provideDataWithoutErrors(): Iterator
    {
        yield [__DIR__ . '/Fixture/ClassWithProperConstructor.php'];

        yield [__DIR__ . '/Fixture/ClassWithNullableStringConstructor.php'];
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DoNotUseNullableConstructorRule::class);
    }
}
