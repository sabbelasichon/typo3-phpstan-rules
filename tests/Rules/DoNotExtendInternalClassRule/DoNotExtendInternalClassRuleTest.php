<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Ssch\Typo3PhpstanRules\Rules\DoNotExtendInternalClassRule;

/**
 * @extends RuleTestCase<DoNotExtendInternalClassRule>
 */
final class DoNotExtendInternalClassRuleTest extends RuleTestCase
{
    /**
     * @dataProvider provideDataWithoutErrors()
     */
    public function testRuleWithoutErrors(string $filePath): void
    {
        $this->analyse([$filePath], []);
    }

    /**
     * @dataProvider provideDataWithErrors()
     * @param list<array{0: string, 1: int, 2?: string}> $expectedErrorMessagesWithLines
     */
    public function testRuleWithErrors(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    public function provideDataWithoutErrors(): Iterator
    {
        yield [__DIR__ . '/Fixture/ClassDoesNotExtendAnotherClass.php'];
        yield [__DIR__ . '/Fixture/ClassDoesNotExtendInternalClass.php'];
    }

    public function provideDataWithErrors(): Iterator
    {
        yield [
            __DIR__ . '/Fixture/ClassExtendInternalClass.php',
            [[
                'Class Ssch\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Fixture\ClassExtendInternalClass extends @internal class TYPO3\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Source\MyInternalClass.', 9, ],
            ],
        ];
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DoNotExtendInternalClassRule::class);
    }
}
