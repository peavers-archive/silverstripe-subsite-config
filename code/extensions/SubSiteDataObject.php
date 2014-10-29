<?php

/**
 * Class SubsiteDataObject
 */
class SubsiteDataObject extends DataExtension
{

    static $db = array(
        'SubsiteID' => 'Int'
    );

    /**
     * @param FieldList $fields
     */
    function updateCMSFields(FieldList $fields)
    {
        $fields->removebyName('SubsiteID');
    }

    /**
     * @return null
     */
    function getSubsite()
    {
        if (class_exists('Subsite')) {
            return Subsite::get()->byID($this->owner->SubsiteID);
        } else return null;
    }

    /**
     * @param DataObject $subsite
     */
    function setSubsite(DataObject $subsite)
    {
        if ($subsite->ClassName === 'Subsite')
            $this->owner->SubsiteID = $subsite->ID;
    }

    /**
     *
     */
    function onBeforeWrite()
    {
        if (!$this->owner->SubsiteID && class_exists('Subsite')) {
            $this->owner->SubsiteID = Subsite::currentSubsiteID();
        }
    }

    /**
     * @param SQLQuery $query
     * @param DataQuery $dataQuery
     */
    function augmentSQL(SQLQuery &$query, DataQuery &$dataQuery = null)
    {
        $baseTable = ClassInfo::baseDataClass($dataQuery->dataClass());
        if (class_exists('Subsite')) {
            $currentSubsiteID = Subsite::currentSubsiteID();
            $query->addWhere("\"$baseTable\".\"SubsiteID\" = '$currentSubsiteID'");
        }
    }
}
