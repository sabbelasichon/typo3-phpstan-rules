<?php

declare(strict_types=1);

use Ssch\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Source\MyInternalClass;

class_alias(
    MyInternalClass::class,
    'TYPO3\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Source\MyInternalClass',
);
