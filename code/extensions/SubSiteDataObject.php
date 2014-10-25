<?php

class SubSiteDataObject extends DataExtension
{

    static $db = array(
        'SubsiteID' => 'Int'
    );

    function updateCMSFields(FieldList $fields)
    {
        $fields->removebyName('SubsiteID');
    }

    function getSubsite()
    {
        if (class_exists('Subsite')) {
            return Subsite::get()->byID($this->owner->SubsiteID);
        } else return null;
    }

    function setSubsite(DataObject $subsite)
    {
        if ($subsite->ClassName === 'Subsite')
            $this->owner->SubsiteID = $subsite->ID;
    }

    function onBeforeWrite()
    {
        if (!$this->owner->SubsiteID && class_exists('Subsite')) {
            $this->owner->SubsiteID = Subsite::currentSubsiteID();
        }
    }

    function augmentSQL(SQLQuery &$query, DataQuery &$dataQuery = null)
    {
        $baseTable = ClassInfo::baseDataClass($dataQuery->dataClass());
        if (class_exists('Subsite')) {
            $currentSubsiteID = Subsite::currentSubsiteID();
            $query->addWhere("\"$baseTable\".\"SubsiteID\" = '$currentSubsiteID'");
        }
    }
}
