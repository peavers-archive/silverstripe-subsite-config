<?php

/**
 * Class SubSitePassword
 *
 * Provides settings in the CMS to enable basic password authentication
 */
class SubSitePassword extends DataExtension
{
    private static $db = array(
        'RequirePassword' => "Enum(array('enable', 'disable'))"
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.SubsiteConfig', array(

            OptionsetField::create("RequirePassword", "Require password")
                ->setSource(array("enable" => "Enable password", "disable" => "Disable password"))
                ->setDescription("<strong>Note:</strong> This is a basic login function only.")
        ));
    }
}

/**
 * Class ControllerExtension
 */
class ControllerExtension extends Extension
{
    /**
     *
     * If enabled, calls the Silverstripe BasicAuth function on any page load. Regardless of setting, only show in production.
     *
     * @return array
     */
    public function index()
    {
        if (SiteConfig::current_site_config()->RequirePassword == "enable" && Director::isLive()) {
            BasicAuth::requireLogin();
        }

        return array();
    }
}