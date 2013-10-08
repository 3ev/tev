# 3ev Core TYPO3 Extension

**Version:** 1.1.1

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
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/3ev/tev"
        }
    ]
}
```

If your `composer.json` sits outside of your TYPO3 directory, you'll need to add:

```json
{
    "extra": {
        "installer-paths": {
            "path/to/typo3/typo3conf/ext/{$name}/": ["type:typo3-cms-extension"]
        }
    }
}
```

## Dependencies

- [TYPO3 Fluid Extensions](https://github.com/FluidTYPO3)
- [Phingy](https://github.com/3ev/phingy)
- [RealURL](http://git.typo3.org/TYPO3v4/Extensions/realurl.git)
