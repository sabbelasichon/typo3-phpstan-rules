<?php

declare(strict_types=1);

namespace Ssch\Typo3PhpstanRules;

use PHPStan\Analyser\Scope;

final class FileResolver
{
    public function isConfigurationFile(Scope $scope): bool
    {
        return $this->isExtTablesFile($scope) || $this->isExtLocalConfFile($scope);
    }

    public function isExtTablesFile(Scope $scope): bool
    {
        return $this->getFileNameFromScope($scope) === 'ext_tables.php';
    }

    private function isExtLocalConfFile(Scope $scope): bool
    {
        return $this->getFileNameFromScope($scope) === 'ext_localconf.php';
    }

    private function getFileNameFromScope(Scope $scope): string
    {
        return basename($scope->getFile());
    }
}
