<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/11/2016
 * Time: 6:41 PM
 */
class HomePage extends Page
{

}
class HomePage_Controller extends Page_Controller
{
    public function LatestArticles($count = 3)
    {
        return ArticlePage::get()
                    ->sort('Created','DESC')
                    ->limit($count);
    }
}