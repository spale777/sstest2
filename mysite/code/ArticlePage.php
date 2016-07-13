<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/11/2016
 * Time: 7:21 PM
 */
class ArticlePage extends Page
{
    private static $can_be_root = false;

    private static $db = [
        'Date' => 'Date',
        'Teaser' => 'Text',
        'Author' => 'Varchar',
    ];

    private static $has_one = [
        'Photo' => 'Image',
        'Brochure' => 'File',
    ];

    private static $many_many = [
        'Categories' => 'ArticleCategory',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', DateField::create('Date', 'Date of Creation')
            ->setConfig('showcalendar', true)
            , 'Content');
        $fields->addFieldTotab('Root.Main', TextareaField::create('Teaser'), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('Author', 'Author of article'), 'Content');
        $fields->addFieldToTab('Root.Includes', $photo = UploadField::create('Photo','Article Photo'));
        $fields->addFieldToTab('Root.Includes', $brochure = UploadField::create('Brochure', 'Brochure (PDF only)'));
        $fields->addFieldToTab('Root.Categories', CheckboxSetField::create(
            'Categories',
            'Selected categories',
            $this->Parent()->Categories()->map('ID', 'Title')
        ));

        $photo->getValidator()->setAllowedExtensions(['png', 'gif', 'jpg', 'jpeg']);
        $photo->setFolderName('travel-photos');
        $brochure->getValidator()->setAllowedExtensions(['pdf',]);
        $brochure->setFolderName('travel-brochures');

        return $fields;
    }

    public function CategoriesList(){
        if($this->Categories()->exists()){
            return implode(', ', $this->Categories()->column('Title'));
        }
    }
}
class ArticlePage_Controller extends Page_Controller
{

}