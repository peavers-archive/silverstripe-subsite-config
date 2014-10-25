<?php

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
                ->setDescription("<strong>Note:</strong> This is a basic login function only.")
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