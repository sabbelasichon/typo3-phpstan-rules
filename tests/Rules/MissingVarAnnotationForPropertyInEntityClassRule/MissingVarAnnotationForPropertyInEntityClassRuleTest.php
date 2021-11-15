<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\MissingVarAnnotationForPropertyInEntityClassRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<MissingVarAnnotationForPropertyInEntityClassRule>
 */
final class MissingVarAnnotationForPropertyInEntityClassRuleTest extends AbstractServiceAwareRuleTestCase
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
            __DIR__ . '/Fixture/MissingDocblock.php',
            [[
                'Missing var annotation for property "property" in class "Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Fixture\MissingDocblock"',
                7,
            ]],
        ];

        yield [
            __DIR__ . '/Fixture/MissingVarInDocblock.php',
            [[
                'Missing var annotation for property "property" in class "Ssch\Typo3PhpstanRules\Tests\Rules\MissingVarAnnotationForPropertyInEntityClassRule\Fixture\MissingVarInDocblock"',
                7,
            ]],
        ];

        yield [__DIR__ . '/Fixture/SkipDocblockIsValid.php', []];
        yield [__DIR__ . '/Fixture/SkipMissingDocblockNotInEntity.php', []];
        yield [__DIR__ . '/Fixture/SkipDocblockIsValidInEntityTrait.php', []];
        yield [__DIR__ . '/Fixture/SkipMissingDocblockNotInEntityFromTrait.php', []];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            MissingVarAnnotationForPropertyInEntityClassRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
