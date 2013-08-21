# 3EV Core TYPO3 Extension

**Version:** 0.0.0

Contains common setup and functionality that's useful for all 3ev TYPO3 sites.

- Sets up core TypoScript configuration common to all projects
- Includes TypoScript from core system extensions
- Sets up base RealURL configuration
- Adds some common utility classes

It is a required dependency of all site extensions.

## Installation

Install into TYPO3 with Composer. Add the following config to your `composer.json`:

```json
{
    "require": {
        "3ev/tev": "master"
    },
    "repositories": {
        {
            "type": "vcs",
            "url": "https://github.com/3ev/tev"
        }
    },
    "extra": {
        "installer-paths": {
            "htdocs/typo3conf/ext/{$name}/": [
                "3ev/tev"
            ]
        }
    }
}
```

## Dependencies

- [TYPO3 Fluid Extensions](https://github.com/FluidTYPO3)
- [Phingy](https://github.com/3ev/phingy)
