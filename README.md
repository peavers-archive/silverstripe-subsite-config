# Subsite Extensions

## Maintainer

[Chris Turner](mailto:chris.turner@minedu.govt.nz)

## Requirements

master: SilverStripe 3.1.x

## Installation

1. Via composer
1. Rebuild database schema (dev/build?flush=1)

## Features

### SubSiteConfig
Restricts viewing of settigns designed for a specific subsite.

### SubSitePassword
Enables basic authentication on each subsite. This is useful for when moving into production but not ready for release.

### SubSiteDataObject
Keeps dataobjects to their own subsites. This may have been made obsolete in recent SubSite module updates from Silverstripe.

## Further details
See https://gitlab.cwp.govt.nz/modules/subsite-config/wikis/pages for details