<?php
declare(strict_types=1);


namespace Ssch\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Fixture;


use Ssch\Typo3PhpstanRules\Tests\Rules\DoNotExtendInternalClassRule\Source\MyExternalClass;

final class ClassDoesNotExtendInternalClass extends MyExternalClass
{

}
