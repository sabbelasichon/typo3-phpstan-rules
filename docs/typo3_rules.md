# 7 Rules Overview

## DoNotUseConstantsInConfigurationFilesRule

Do not use constants TYPO3_MODE and TYPO3_REQUESTTYPE in ext_localconf.php or ext_tables.php

- class: [`Ssch\Typo3PhpstanRules\Rules\DoNotUseConstantsInConfigurationFilesRule`](../src/Rules/DoNotUseConstantsInConfigurationFilesRule.php)

```php
if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
}
```

:x:

<br>

```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
```

:+1:

<br>

## DoNotUseDeclareInConfigurationFilesRule

Do not use declare statements in ext_localconf.php or ext_tables.php

- class: [`Ssch\Typo3PhpstanRules\Rules\DoNotUseDeclareInConfigurationFilesRule`](../src/Rules/DoNotUseDeclareInConfigurationFilesRule.php)

```php
declare(strict_types=1)

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
```

:x:

<br>

```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
```

:+1:

<br>

## DoNotUseImplicitVariableInConfigurationFilesRule

Do not use $_EXTKEY and $_EXTCONF in ext_localconf.php or ext_tables.php

- class: [`Ssch\Typo3PhpstanRules\Rules\DoNotUseImplicitVariableInConfigurationFilesRule`](../src/Rules/DoNotUseImplicitVariableInConfigurationFilesRule.php)

```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$_EXTKEY] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
```

:x:

<br>

```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['my_extension_key'] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
```

:+1:

<br>

## DoNotUseMagicConstantFileAndDirInConfigurationFilesRule

Do not use __FILE__ constant in ext_localconf.php or ext_tables.php

- class: [`Ssch\Typo3PhpstanRules\Rules\DoNotUseMagicConstantFileAndDirInConfigurationFilesRule`](../src/Rules/DoNotUseMagicConstantFileAndDirInConfigurationFilesRule.php)

```php
__DIR__ . '/Resources/Private/Templates/Template.html;
```

:x:

<br>

```php
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('my_extension') . '/Resources/Private/Templates/Template.html;
```

:+1:

<br>

## DoNotUseUseInConfigurationFilesRule

Do not use statements but FQN in ext_localconf.php or ext_tables.php

- class: [`Ssch\Typo3PhpstanRules\Rules\DoNotUseUseInConfigurationFilesRule`](../src/Rules/DoNotUseUseInConfigurationFilesRule.php)

```php
use \Prefix\MyExtension\PageRendererHooks;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = PageRendererHooks::class . '->renderPreProcess';
```

:x:

<br>

```php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$packageKey] = \Prefix\MyExtension\PageRendererHooks::class . '->renderPreProcess';
```

:+1:

<br>

## MissingDefaultValueForTypedPropertyRule

Missing default value for property "property" in class "MissingDefaultValueForTypedProperty"

- class: [`Ssch\Typo3PhpstanRules\Rules\MissingDefaultValueForTypedPropertyRule`](../src/Rules/MissingDefaultValueForTypedPropertyRule.php)

```php
final class MissingDefaultValueForTypedProperty extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $property;
}
```

:x:

<br>

```php
final class MissingDefaultValueForTypedProperty extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected string $property = '';
}
```

:+1:

<br>

## MissingVarAnnotationForPropertyInEntityClassRule

Missing var annotation for property "property" in class "MissingDocblock"

- class: [`Ssch\Typo3PhpstanRules\Rules\MissingVarAnnotationForPropertyInEntityClassRule`](../src/Rules/MissingVarAnnotationForPropertyInEntityClassRule.php)

```php
final class MissingDocblock extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    protected ?string $property = null;
}
```

:x:

<br>

```php
final class MissingDocblock extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string|null
     */
    protected ?string $property = null;
}
```

:+1:

<br>
