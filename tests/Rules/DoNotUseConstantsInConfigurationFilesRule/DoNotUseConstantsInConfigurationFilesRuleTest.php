<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotUseConstantsInConfigurationFilesRule;

use Iterator;
use PHPStan\Rules\Rule;
use Ssch\Typo3PhpstanRules\Rules\DoNotUseConstantsInConfigurationFilesRule;
use Symplify\PHPStanExtensions\Testing\AbstractServiceAwareRuleTestCase;

/**
 * @extends AbstractServiceAwareRuleTestCase<DoNotUseConstantsInConfigurationFilesRule>
 */
final class DoNotUseConstantsInConfigurationFilesRuleTest extends AbstractServiceAwareRuleTestCase
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
        $invalidFile = __DIR__ . '/MyExtension/ext_tables.php';

        yield [$invalidFile, [[sprintf('Do not use declare statements in file "%s"', $invalidFile), 3]]];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            DoNotUseConstantsInConfigurationFilesRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
