<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/14/2016
 * Time: 1:04 AM
 */
class ArticleCategory extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
    ];

    private static $has_one = [
        'ArticleHolder' => 'ArticleHolder',
    ];

    private static $belongs_many_many = [
        'Articles' => 'ArticlePage',
    ];

    public function getCMSFields()
    {
        return FieldList::create(
            TextField::create('Title')
        );
    }
    public function Link()
    {
        return $this->ArticleHolder()->Link(
            'category/'.$this->ID
        );
    }
}