<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);
    $rectorConfig->phpVersion(PhpVersion::PHP_74);

    $rectorConfig->rule(TypedPropertyRector::class);
    $rectorConfig->rule(AddSeeTestAnnotationRector::class);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,
        SetList::PRIVATIZATION,
        SetList::CODING_STYLE,
        SetList::CODE_QUALITY,
    ]);

    $rectorConfig->skip(['*/Fixture/*', '*/Source/*']);
};
