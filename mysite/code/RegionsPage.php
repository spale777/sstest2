<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/13/2016
 * Time: 11:54 PM
 */
class RegionsPage extends Page
{
    private static $has_many = [
        'Regions' => 'Region',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Regions', GridField::create(
            'Regions',
            'Regions on this page',
            $this->Regions(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}
class RegionsPage_Controller extends Page_Controller
{

}