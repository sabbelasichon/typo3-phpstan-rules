<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseMagicConstantFileAndDirInConfigurationFilesRule;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\DoNotUseMagicConstantFileAndDirInConfigurationFilesRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<DoNotUseMagicConstantFileAndDirInConfigurationFilesRule>
 */
final class DoNotUseMagicConstantFileAndDirInConfigurationFilesRuleTest extends AbstractServiceAwareRuleTestCase
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
        $invalidFile = __DIR__ . '/MyExtension/ext_localconf.php';

        yield [
            $invalidFile,
            [
                [sprintf('Do not use __DIR__ constant in file "%s"', $invalidFile), 3],
                [sprintf('Do not use __FILE__ constant in file "%s"', $invalidFile), 4],
            ],
        ];

        yield [__DIR__ . '/MySecondExtension/ext_localconf.php', []];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            DoNotUseMagicConstantFileAndDirInConfigurationFilesRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
