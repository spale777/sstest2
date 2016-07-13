<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/11/2016
 * Time: 7:21 PM
 */

class ArticleHolder extends Page
{
    private static $has_many = [
        'Categories' => 'ArticleCategory'
    ];

    private static $allowed_children = ['ArticlePage'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Categories', GridField::create(
            'Categories',
            'Article categories',
            $this->Categories(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}
class ArticleHolder_Controller extends Page_Controller
{

}