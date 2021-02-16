# Quick Login extension for phpBB

Extension for phpBB 3.3 that adds a simple quick login popup lightbox using JavaScript.

[![Build Status](https://github.com/david63/quicklogin/workflows/Tests/badge.svg)](https://github.com/phpbb-extensions/david63/quicklogin)
[![License](https://poser.pugx.org/david63/quicklogin/license)](https://packagist.org/packages/david63/quicklogin)
[![Latest Stable Version](https://poser.pugx.org/david63/quicklogin/v/stable)](https://packagist.org/packages/david63/quicklogin)
[![Latest Unstable Version](https://poser.pugx.org/david63/quicklogin/v/unstable)](https://packagist.org/packages/david63/quicklogin)
[![Total Downloads](https://poser.pugx.org/david63/quicklogin/downloads)](https://packagist.org/packages/david63/quicklogin)
[![CodeFactor](https://www.codefactor.io/repository/github/david63/quicklogin/badge)](https://www.codefactor.io/repository/github/david63/quicklogin)

[![Compatible](https://img.shields.io/badge/compatible-phpBB:3.3.x-blue.svg)](https://shields.io/)

![Screenshot](screenshot.png)

## Minimum Requirements
* phpBB 3.3.0
* PHP 7.1.3

## Features
- Just a simple lightbox popup for quick login actions.
- Changes the behaviour of the normal login button in the header.
- Only activates on pages where there is no normal login form (not when trying to access the UCP for example).

## Install
1. [Download the latest release](https://github.com/david63/quicklogin/archive/3.2.zip) and unzip it.
2. Unzip the downloaded release and copy it to the `ext` directory of your phpBB board.
3. Navigate in the ACP to `Customise -> Manage extensions`.
4. Look for `Quick Login` under the Disabled Extensions list and click its `Enable` link.

## Uninstall
1. Navigate in the ACP to `Customise -> Manage extensions`.
2. Click the `Disable` link for `Quick Login`.
3. To permanently uninstall, click `Delete Data`, then delete the quicklogin folder from `phpBB/ext/paybas/`.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2021 - David Wood