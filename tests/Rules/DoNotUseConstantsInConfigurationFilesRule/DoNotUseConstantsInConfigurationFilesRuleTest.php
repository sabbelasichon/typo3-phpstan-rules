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
     * @param list<array{0: string, 1: int, 2?: string}> $expectedErrorMessagesWithLines
     */
    public function testRule(string $filePath, array $expectedErrorMessagesWithLines): void
    {
        $this->analyse([$filePath], $expectedErrorMessagesWithLines);
    }

    public function provideData(): Iterator
    {
        $invalidFile = __DIR__ . '/MyExtension/ext_tables.php';

        yield [
            $invalidFile,
            [[sprintf('Do not use constant TYPO3_MODE or TYPO3_REQUESTTYPE in file "%s"', $invalidFile), 3]], ];
    }

    protected function getRule(): Rule
    {
        return $this->getRuleFromConfig(
            DoNotUseConstantsInConfigurationFilesRule::class,
            __DIR__ . '/config/configured_rule.neon'
        );
    }
}
