<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/14/2016
 * Time: 6:53 PM
 */
class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'FacebookLink' => 'Varchar',
        'TwitterLink' => 'Varchar',
        'GoogleLink' => 'Varchar',
        'YouTubeLink' => 'Varchar',
        'FooterContent' => 'Text',
    ];

    public function updateCMSFields(FieldList $fields){
        $fields->addFieldsToTab('Root.Social', [
            TextField::create('FacebookLink', 'Facebook'),
            TextField::create('TwitterLink','Twitter'),
            TextField::create('GoogleLink','Google'),
            TextField::create('YoutubeLink', 'Youtube'),
        ]);
        $fields->addFieldTotab('Root.Main',
            TextareaField::create('FooterContent', 'Content for footer')
        );

    }
}