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

    public function Regions()
    {
        $page = RegionsPage::get()->first();

        if($page){
            return $page->Regions();
        }
    }
}
class ArticleHolder_Controller extends Page_Controller
{
    private static $allowed_actions = [
        'category', 'date', 'region'
    ];

    protected $articleList;

    public function init()
    {
        parent::init();

        $this->articleList = ArticlePage::get()->filter([
            'ParentID' => $this->ID
        ])->sort('Date DESC');
    }

    public function category(SS_HTTPRequest $r)
    {
        $category = ArticleCategory::get()->byID(
            $r->param('ID')
        );

        if(!$category){
            return $this->httpError(404, 'That category was not found');
        }

        $this->articleList = $this->articleList->filter([
            'Categories.ID' => $category->ID
        ]);

        return [
            'SelectedCategory' => $category
        ];
    }

    public function region(SS_HTTPRequest $r)
    {
        $region = Region::get()->byID(
            $r->param('ID')
        );

        if(!$region){
            return $this->httpError(404, 'That region was not found');
        }

        $this->articleList = $this->articleList->filter([
            'Region.ID' => $region->ID
        ]);

        return [
            'SelectedRegion' => $region
        ];
    }

    public function PaginatedArticles($num = 10)
    {
        return PaginatedList::create(
            $this->articleList,
            $this->getRequest()
        )->setPageLength($num);
    }
}