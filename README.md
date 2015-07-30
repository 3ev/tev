# 3ev Core TYPO3 Extension

Contains common setup and functionality that's useful for all 3ev TYPO3 sites.

- Sets up core TypoScript configuration common to all projects
- Includes TypoScript from core system extensions
- Sets up base RealURL configuration
- Adds options to pages to apply routing parameters
- Adds some common utility classes

It is a required dependency of all site extensions.

## Installation

Install into TYPO3 with Composer. Add the following config to your `composer.json`:

```json
{
    "require": {
        "3ev/tev": "master"
    }
}
```

## Dependencies

- [TYPO3 Fluid Extensions](https://github.com/FluidTYPO3)
- [Phingy](https://github.com/3ev/phingy)
- [RealURL](http://git.typo3.org/TYPO3v4/Extensions/realurl.git)
