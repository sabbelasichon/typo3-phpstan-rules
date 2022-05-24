<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseDeclareInConfigurationFilesRule;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\DoNotUseDeclareInConfigurationFilesRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<DoNotUseDeclareInConfigurationFilesRule>
 */
final class DoNotUseDeclareInConfigurationFilesRuleTest extends AbstractServiceAwareRuleTestCase
{
    /**
     * @dataProvider provideData()
     * @param list<array{0: string, 1: int, 2?: string}> $expectedErrorMessagesWithLines
     */
    public function testRule(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    public function provideData(): Iterator
    {
        $extTablesFile = __DIR__ . '/MyExtension/ext_tables.php';

        yield [$extTablesFile, [[sprintf('Do not use declare statements in file "%s"', $extTablesFile), 3]]];

        yield [__DIR__ . '/MySecondExtension/ext_tables.php', []];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            DoNotUseDeclareInConfigurationFilesRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
