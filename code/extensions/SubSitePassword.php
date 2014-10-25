<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 10/25/2014
 * Time: 4:31 PM
 */
class SubSitePassword extends DataExtension
{
    private static $db = array(
        'RequirePassword' => "Enum(array('enable', 'disable'))"
    );

    public function canEdit($member = null)
    {
        return Permission::check('SUBSITE_DEVELOPER_EDIT');
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.SubsiteConfig', array(

            OptionsetField::create("RequirePassword", "Require password")
                ->setSource(array("enable" => "Enable password", "disable" => "Disable password"))
                ->setDescription("<strong>Note:</strong> This should not be used for secure services.")
        ));
    }
}

class ControllerExtension extends Extension
{
    public function index()
    {
        if (SiteConfig::current_site_config()->RequirePassword == "enable") {
            BasicAuth::requireLogin();
        }

        return array();
    }
}