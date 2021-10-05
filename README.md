[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/schreiberten)

# TYPO3 PHPStan Rules

Set of (opinionated) rules for PHPStan in TYPO3 Projects

- See [Rules Overview](docs/typo3_rules.md)

## Install

```bash
composer require ssch/typo3-phpstan-rules --dev
```

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set for the version independent rules.

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include general_typo3_rules.neon in your project's PHPStan config:

```neon
includes:
    - vendor/ssch/typo3-phpstan-rules/config/general_typo3_rules.neon
```

</details>

In order to load the TYPO3 version dependent rules, include them manually in your PHPStan config:

```neon
includes:
    - vendor/ssch/typo3-phpstan-rules/config/v11/rules.neon
    - vendor/ssch/typo3-phpstan-rules/config/v10/rules.neon
    - vendor/ssch/typo3-phpstan-rules/config/v9/rules.neon
    - vendor/ssch/typo3-phpstan-rules/config/v8/rules.neon
```

They are not building on each other, so include only the one for your targeted version.
