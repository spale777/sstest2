<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/14/2016
 * Time: 11:29 PM
 */

class Property extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'PricePerNight' => 'Currency',
        'Bedrooms' => 'Int',
        'Bathrooms' => 'Int',
        'FeaturedOnHomepage' => 'Boolean',
        'AvailableStart' => 'Date',
        'AvailableEnd' => 'Date',
        'Description' => 'Text'
    ];

    private static $has_one = [
        'Region' => 'Region',
        'PrimaryPhoto' => 'Image',
    ];

    private static $summary_fields = [
        'Title' => 'Title',
        'Region.Title' => 'Region',
        'PricePerNight.Nice' => 'Price',
        'FeaturedOnHomepage.Nice' => 'Featured?',
    ];

    public function searchableFields()
    {
        return [
            'Title' => [
                'filter' => 'PartialMatchFilter',
                'title' => 'Title',
                'field' => 'TextField'
            ],
            'RegionID' => [
                'filter' => 'ExactMatchFilter',
                'title' => 'Region',
                'field' => DropdownField::create('RegionID')
                            ->setSource(
                                Region::get()->map('ID','Title')
                            )
                            ->setEmptyString('-- Any Region --')
            ],
            'FeaturedOnHomepage' => [
                'filter' => 'ExactMatchFilter',
                'title' => 'Only featured'
            ],

        ];
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title'),
            TextareaField::create('Description'),
            CurrencyField::create('PricePerNight', 'Price Per Night'),
            DropdownField::create('Bedrooms', 'Number Of Bedrooms')
                ->setSource(ArrayLib::valuekey(range(1,10))),
            DropdownField::create('Bathrooms', 'Number of Bathrooms')
                ->setSource(ArrayLib::valuekey(range(1,10))),
            DropdownField::create('RegionID', 'Region')
                ->setSource(Region::get()->map('ID', 'Title'))
                ->setEmptyString('-- Select a region --'),
            CheckboxField::create('FeaturedOnHomepage', 'Feature on Homepage')
        ]);

        $fields->addFieldToTab('Root.Photos', $upload = UploadField::create(
            'PrimaryPhoto', 'Primary Photo'
        ));

        $upload->getValidator()->setAllowedExtensions([
            'jpg', 'jpeg', 'gif', 'png',
        ]);
        $upload->setFolderName('property-photos');

        return $fields;
    }
}