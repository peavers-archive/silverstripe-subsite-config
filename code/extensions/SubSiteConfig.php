<?php

/**
 * Created by PhpStorm.
 * User: turnerc
 * Date: 10/09/14
 * Time: 10:51 AM
 */

/**
 * Class SubSiteConfig
 *
 * Requires users to have developer access to modify. Removes the chance of CMS administrators changing values.
 */
class SubSiteConfig extends DataExtension implements PermissionProvider
{

    private static $db = array(
        'SubSiteConstant' => 'Varchar(255)',
    );

    /**
     *
     * Check that you have entered values in a config file that match the constant set in the subsite Settings by the developer
     *
     * @param string $key Name of the array in the _config.yml file
     * @param string $value Array value set under the name
     * @return bool
     */
    public function display($key, $value)
    {
        if (in_array(SiteConfig::current_site_config()->SubSiteConstant, Config::inst()->get($key, $value))) {
            //Display to the current subsite
            return true;
        } else {
            //Don't display to the current subsite
            return false;
        }
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.SubsiteConfig', array(
            TextField::create('SubSiteConstant', 'Subsite Constant')
                ->setAttribute('placeholder', 'SOMETHING_SOMETHING_ID')
                ->setDescription('Used as a guarantee for module loading. <a href="https://moe-webservices.atlassian.net/wiki/display/EV/Subsites" target="_blank">Details here</a>'),
        ));

        if (!Permission::check('SUBSITE_DEVELOPER_EDIT')) {
            $fields->makeFieldReadonly('SubSiteConstant');
        }
    }

    public function canEdit($member = null)
    {
        return Permission::check('SUBSITE_DEVELOPER_EDIT');
    }

    public function providePermissions()
    {
        return array(
            'SUBSITE_DEVELOPER_EDIT' => array(
                'name'     => 'Edit developer settings',
                'category' => 'Developer Specific Settings'
            ),
        );
    }

}