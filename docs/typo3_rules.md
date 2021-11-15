# 2 Rules Overview

## MissingDefaultValueForTypedPropertyRule

Missing default value for property "%s" in class "%s"

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

Missing var annotation for property "%s" in class "%s"

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
