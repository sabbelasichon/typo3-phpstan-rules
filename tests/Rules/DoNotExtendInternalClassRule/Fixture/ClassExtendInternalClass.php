<?php
declare(strict_types=1);


namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Fixture;

use TYPO3\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Source\MyInternalClass;

final class ClassExtendInternalClass extends MyInternalClass
{

}
