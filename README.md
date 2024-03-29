Relevanssi Extras plugin for WordPress
======================================

![PHP](https://img.shields.io/badge/PHP-v5.6%20to%20v8.2-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-v4.1%20to%20v6.4-blue.svg)
[![GitHub Issues](https://img.shields.io/github/issues/michael-milette/wordpress-relevanssi_extras.svg)](https://github.com/michael-milette/wordpress-relevanssi_extras/issues)
[![Contributions welcome](https://img.shields.io/badge/contributions-welcome-green.svg)](#contributing)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](#license)

# Table of Contents

- [Relevanssi Extras plugin for WordPress](#relevanssi-extras-plugin-for-wordpress)
- [Table of Contents](#table-of-contents)
- [Basic Overview](#basic-overview)
- [Requirements](#requirements)
- [Download Relevanssi Extras](#download-relevanssi-extras)
- [Installation](#installation)
- [Usage](#usage)
- [Updating](#updating)
- [Uninstallation](#uninstallation)
- [Language Support](#language-support)
- [FAQ](#faq)
  - [Frequently Asked Questions](#frequently-asked-questions)
    - [Are there any security considerations?](#are-there-any-security-considerations)
  - [Other questions](#other-questions)
- [Contributing](#contributing)
  - [Contributors](#contributors)
  - [Pending Features](#pending-features)
- [Motivation for this plugin](#motivation-for-this-plugin)
- [Further Information](#further-information)
- [License](#license)

# Basic Overview

Relevanssi Extras for WordPress:

* Enables ignoring of hyphens;
* Adds the ability to limit the number of search results per page;
* Enable you to exclude specific pages from results.

IMPORTANT: Although we expect everything to work, this ALPHA release has not been fully tested in every situation. If you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/wordpress-relevanssi_extras/issues).

[(Back to top)](#table-of-contents)

# Requirements

This plugin requires WordPress 4.1+ from https://wordpress.org/

[(Back to top)](#table-of-contents)

# Download Relevanssi Extras

The most recent DEVELOPMENT release can be found at:
https://github.com/michael-milette/wordpress-relevanssi_extras

[(Back to top)](#table-of-contents)

# Installation

Install the plugin, like any other plugin, to the following folder:

    /wp-content/plugins/wordpress-relevanssi_extras

[(Back to top)](#table-of-contents)

# Usage

Once installed and activated, Pages (not Posts) will have a new checkbox setting in the sidebar called "DO NOT INCLUDE this page in search results". It will be in a section called "Exclude Relevanssi Page Search".

When enabled, the page will not be included i Relevanssi search results. This is useful if you do not want a particular page to appear in search results such as a **thank you**, **payment** or other page on your site.

There are no other configurable settings for this plugin at this time.

[(Back to top)](#table-of-contents)

# Updating

There are no special considerations required for updating the plugin.

The first public ALPHA version was released on 2017-11-01.

For more information on latest releases, see the [CHANGELOG.md](https://github.com/michael-milette/wordpress-relevanssi_extras/blob/master/CHANGELOG.md) file on GitHub.

[(Back to top)](#table-of-contents)

# Uninstallation

Uninstalling the plugin by going into the following:

Dashboard > Plugins > Installed Plugins > Relevanssi Extras

...and click Deactivate, and then Delete. You may also need to manually delete the following folder:

    /wp-content/plugins/wordpress-relevanssi_extras

[(Back to top)](#table-of-contents)

# Language Support

This plugin only supports the English language. However, this will not prevent it from working in other languages.

This plugin has not been tested for right-to-left (RTL) language support.
If you want to use this plugin with a RTL language and it doesn't work as-is,
feel free to prepare a pull request and submit it to the project page at:

https://github.com/michael-milette/wordpress-relevanssi_extras

[(Back to top)](#table-of-contents)

# FAQ

## Frequently Asked Questions

IMPORTANT: Although we expect everything to work, this ALPHA release has not been fully tested in every situation. If you find a problem, please help by reporting it in the [Bug Tracker](https://github.com/michael-milette/wordpress-relevanssi_extras/issues).

### Are there any security considerations?

There are no known security considerations at this time.

## Other questions

Got a burning question that is not covered here? If you can't find your answer, open a new issue on [Github](https://github.com/michael-milette/wordpress-relevanssi_extras/issues)

[(Back to top)](#table-of-contents)

# Contributing

If you are interested in helping, please take a look at our [contributing](https://github.com/michael-milette/wordpress-relevanssi_extras/blob/master/CONTRIBUTING.md) guidelines for details on our code of conduct and the process for submitting pull requests to us.

## Contributors

Michael Milette - Author and Lead Developer

## Pending Features

Some of the features we are considering for future releases include:

* Adding configurable option to specify the number of results per page (current hard coded).
* Add support for language translations for plugin strings.

If you could use any of these features, or have other requirements, consider contributing or hiring us to accelerate development.

[(Back to top)](#table-of-contents)

# Motivation for this plugin

The development of this plugin was motivated through our own experience in WordPress development and topics discussed in the various WordPress forums. The project is sponsored and supported by TNG Consulting Inc.

[(Back to top)](#table-of-contents)

# Further Information

For further information regarding the Relevanssi Extras plugin for WordPress, support or to report a bug, please visit the [project page](https://github.com/michael-milette/wordpress-relevanssi_extras).

[(Back to top)](#table-of-contents)

# License

Copyright © 2017-2024 TNG Consulting Inc. - https://www.tngconsulting.ca/

This file is part of Relevanssi Extras for WordPress.

Relevanssi Extras is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Relevanssi Extras is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Relevanssi Extras.  If not, see <https://www.gnu.org/licenses/>.

[(Back to top)](#table-of-contents)
