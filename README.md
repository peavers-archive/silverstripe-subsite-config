# Subsite Config Extension

## Maintainer

[Chris Turner](mailto:chris.turner@minedu.govt.nz)

## Requirements

master: SilverStripe 3.1.x

## Installation

1. Via composer:
1. Rebuild database schema (dev/build?flush=1)

## Features

- Creates a new field editable by those in a 'Developer' group in SiteConfig, $SubSiteConstant
- Provides a simple method to compare $SubSiteConstant with values set in _config.yml

## Details

### SubSiteConfig

A data extension on SiteConfig adds a tab to allow the developer to set a constant for their subsite. In order to be able to set this constant you must be a part of the Developer group on that instance.
SubSiteConfig has a simple method called display which accepts two values

```php
public function display($key, $value)
{
    if (in_array(SiteConfig::current_site_config()->owner->SubSiteConstant, Config::inst()->get($key, $value))) {
        //Display to the current subsite
        return true;
    } else {
        //Don't display to the current subsite
        return false;
    }
}
```

Can be easily called from anywhere in your code

```php
if (SubSiteConfig::display('DisplayOn', 'values')) {
    //Do something
}
```

What your module _config.yml might contain

```
DisplayOn:
  values:
   - SUBSITE_SOMETHING_1
   - SUBSITE_SOMETHING_2
   - SUBSITE_SOMETHING_3
   - SUBSITE_SOMETHING_4
   - SUBSITE_SOMETHING_5
```

In each *SiteConfig -> Subsite Config -> Subsite Constant* field for your subsites simple enter SUBSITE_SOMETHING_*n*

## Restricting viewable items

### Model Admin

```php
class ExampleModel extends ModelAdmin
{
    public function subsiteCMSShowInMenu()
    {
        if (SubSiteConfig::display('DisplayOn', 'values')) {
            return true;
        } else {
            return false;
        }
    }
}
```

### Tabs/Fields and other settings

```php
class ExamplePage extends Page {

 public function updateCMSFields(FieldList $fields)
    {
        if (SubSiteConfig::display('DisplayOn', 'values')) {

            $fields = parent::getCMSFields();

            $fields->addFieldsToTab("Root.Main", array(
                TextField::create('Example', 'Example text'),
            ));

            return $fields;
        }
    }
}
```

