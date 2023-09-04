<?php

declare(strict_types=1);

namespace Rules\AllowTableOnStandardPagesMustBeInExtTablesFileRule;

use Iterator;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Ssch\Typo3PhpstanRules\Rules\AllowTableOnStandardPagesMustBeInExtTablesFileRule;

/**
 * @extends RuleTestCase<AllowTableOnStandardPagesMustBeInExtTablesFileRule>
 */
final class AllowTableOnStandardPagesMustBeInExtTablesFileRuleTest extends RuleTestCase
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

    public function provideDataWithoutErrors(): Iterator
    {
        yield [__DIR__ . '/Fixture/ext_tables.php'];
        yield [__DIR__ . '/Fixture/other_class_same_method_name.php'];
    }

    public function provideDataWithErrors(): Iterator
    {
        yield [
            __DIR__ . '/Fixture/not_in_ext_tables.php',
            [['You must define allowTableOnStandardPages in ext_tables.php', 3]],
        ];
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(AllowTableOnStandardPagesMustBeInExtTablesFileRule::class);
    }
}
