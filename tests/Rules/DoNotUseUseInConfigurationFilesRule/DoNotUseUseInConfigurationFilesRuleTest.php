<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseMagicConstantFileAndDirInConfigurationFilesRuleTest;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\DoNotUseUseInConfigurationFilesRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<DoNotUseUseInConfigurationFilesRule>
 */
final class DoNotUseUseInConfigurationFilesRuleTest extends AbstractServiceAwareRuleTestCase
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

        yield [$invalidFile, [[sprintf('Do not use statements but FQN in file "%s"', $invalidFile), 2]]];

        yield [__DIR__ . '/MySecondExtension/ext_localconf.php', []];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            DoNotUseUseInConfigurationFilesRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
