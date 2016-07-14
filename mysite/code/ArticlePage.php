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

    private static $has_many = [
        'Comments' => 'ArticleComment',
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
    private static $allowed_actions = [
        'CommentForm', 'handleComment'
    ];

    public function CommentForm() {
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('Name','')
                    ->setAttribute('placeholder','Name*')
                    ->addExtraClass('form-control'),
                EmailField::create('Email','')
                    ->setAttribute('placeholder', 'Email*')
                    ->addExtraClass('form-control'),
                TextareaField::create('Comment','')
                    ->setAttribute('placeholder', 'Comment*')
                    ->addExtraClass('form-control')
            ),
            FieldList::create(
                FormAction::create('handleComment', 'Post Comment')
                    ->setUseButtonTag(true)
                    ->addExtraClass('btn btn-default-color btn-lg')
            ),
            RequiredFields::create('Name','Email','Comment')
        );

        $form->addExtraClass('form-style');

        $data = Session::get("FormData.{$form->getName()}.data");

        return $data ? $form->loadDataFrom($data) : $form;
    }

    public function handleComment($data, $form)
    {
        Session::set("FormData.{$form->getName()}.data", $data);
        $existing = $this->Comments()->filter([
            'Comment' => $data['Comment'],
        ]);
        if($existing->exists() && strlen($data['Comment']) > 20) {
            $form->sessionMessage('That comment already exists !!! Spamer !!!', 'bad');

            return $this->redirectBack();
        }

        $comment = ArticleComment::create();
        $comment->ArticlePageID = $this->ID;

        /**
         * $form has access to Article model class
         * and is aware of all the fields in the database
         * and since form fields match those in the database
         * we can simply call a $form->saveInto method and
         * it will save all the fields into the database
         * WICKED !!!!
         */

        $form->saveInto($comment);
        $comment->write();

        Session::clear("FormData.{$form->getName()}.data");
        $form->sessionMessage('thanks for your comment', 'good');

        return $this->redirectBack();
    }
}