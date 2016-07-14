<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/14/2016
 * Time: 2:19 AM
 */
class ArticleComment extends DataObject
{
    private static $db = [
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'Comment' => 'Text',
    ];

    private static $has_one = [
        'ArticlePage' => 'ArticlePage',
    ];
}
