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
    /**
     * Array of public functions that you are allowed to call from the url
     * by default all public functions are blacklisted this is the way to
     * whitelist them and allow them to be called from url
     */
    public static $allowed_actions = [
        'show',
    ];

    /**
     * We made a public function show() to get data of a region that is requested
     * we pass it SS_HTTPRequest object so we can pull the requested id
     * we query the datable and place results in a $region variable
     * if no region variable is set or no region was returned we throw 404 error
     * and a message httpError method is accessible from all controllers
     * and lastly return array of objects so we can show them in a template
     */
    public function show(SS_HTTPRequest $request)
    {
        $region = Region::get()->byID($request->param('ID'));

        if(!$region) {
            return $this->httpError(404, 'That region could not be found');
        }


        /**
         * Here we can overload properties set by other models in this example Title
         * if we want to show this regions title instead of generic title regions we
         * need to overload it with $regions->Title that way $Title in the template will
         * show its new title that is the title of the region being accessed
         */
        return [
            'Region' => $region,
            'Title' => $region->Title
        ];
    }

}