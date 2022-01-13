<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules;

use PHPStan\Analyser\Scope;

final class FileResolver
{
    public function isConfigurationFile(Scope $scope): bool
    {
        $fileName = basename($scope->getFile());

        return 'ext_tables.php' === $fileName || 'ext_localconf.php' === $fileName;
    }
}
