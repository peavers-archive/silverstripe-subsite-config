<?php

/**
 * Class SubSitePassword
 *
 * Provides settings in the CMS to enable basic password authentication
 */
class SubSitePassword extends DataExtension
{
    private static $db = array(
        'PasswordSetting' => 'Int'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.SubsiteConfig', array(

            OptionsetField::create("PasswordSetting", "Require password:")
                ->setSource(array(0 => "Disable password", 1 => "Enable password"))
                ->setDescription("This will only display in a live enviroment due to issues with external debugging tools. The enviroment is currently: <strong>" . Director::get_environment_type() . "</strong>")
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
        if (SiteConfig::current_site_config()->RequirePassword == 1 && Director::isLive()) {
            BasicAuth::requireLogin();
        }

        return array();
    }
}