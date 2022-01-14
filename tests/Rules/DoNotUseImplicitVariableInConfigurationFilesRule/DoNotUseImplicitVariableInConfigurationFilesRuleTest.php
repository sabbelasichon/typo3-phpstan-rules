<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseMagicConstantFileAndDirInConfigurationFilesRule;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\DoNotUseImplicitVariableInConfigurationFilesRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<DoNotUseImplicitVariableInConfigurationFilesRule>
 */
final class DoNotUseImplicitVariableInConfigurationFilesRuleTest extends AbstractServiceAwareRuleTestCase
{
    /**
     * @dataProvider provideData()
     *
     * @param array<string|int> $expectedErrorMessagesWithLines
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
                [sprintf('Do not use implicit variable "$_EXTCONF" in file "%s"', $invalidFile), 3],
                [sprintf('Do not use implicit variable "$_EXTKEY" in file "%s"', $invalidFile), 5],
            ],
        ];

        yield [__DIR__ . '/MySecondExtension/ext_localconf.php', []];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            DoNotUseImplicitVariableInConfigurationFilesRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
