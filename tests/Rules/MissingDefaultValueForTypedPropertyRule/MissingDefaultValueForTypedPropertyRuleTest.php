<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingDefaultValueForTypedPropertyRule;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\MissingDefaultValueForTypedPropertyRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<MissingDefaultValueForTypedPropertyRule>
 */
final class MissingDefaultValueForTypedPropertyRuleTest extends AbstractServiceAwareRuleTestCase
{
    /**
     * @dataProvider provideData()
     * @param array<string|int> $expectedErrorMessagesWithLines
     */
    public function testRule(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    public function provideData(): Iterator
    {
        yield [
            __DIR__ . '/Fixture/MissingDefaultValue.php',
            [[
                'Missing default value for property "property" in class "Ssch\Typo3PhpstanRules\Tests\Rules\MissingDefaultValueForTypedPropertyRule\Fixture\MissingDefaultValue"',
                7,
            ]],
        ];

        yield [__DIR__ . '/Fixture/SkipDefaultValueIsDefined.php', []];
        yield [__DIR__ . '/Fixture/SkipNotAnExtbaseEntityClass.php', []];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            MissingDefaultValueForTypedPropertyRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
