<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/13/2016
 * Time: 11:58 PM
 */
class Region extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'HTMLText',
    ];

    private static $has_one = [
        'Photo' => 'Image',
        'RegionsPage' => 'RegionsPage',
    ];

    private static $summary_fields = [
        'GridThumbnail' => '',
        'Title' => 'Title of region',
        'Description' => 'Short description',
    ];

    public function getGridThumbnail()
    {
        if($this->Photo()->exists()){
            return $this->Photo()->CroppedImage(150, 75);
        }

        return '(no image)';
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            HtmlEditorField::create('Description'),
            $photo = UploadField::create('Photo')
        );

        $photo->setFolderName('region-photos');
        $photo->getValidator()->setAllowedExtensions([
            'png', 'jpg', 'jpeg', 'gif',
        ]);

        return $fields;
    }

    /**
     * Link method that return a base link from a has_one relation with RegionsPage
     * then appends show/ and then the ID of the region final result is root/regions/show/ID
     */
    public function Link()
    {
        return $this->RegionsPage()->Link('show/'.$this->ID);
    }

    /**
     * First we get the current controller witch is in this case RegionsPage_Controller
     * then we get SSHTTPRequest object that has method param() that returns the parameter
     * that we specified in this case the ID that is in the url $Action/$ID/$id
     * then we compare that with the current region being showed if that evaluates to true then we
     * return 'current' as a class of the link else we will return 'link' as a class of the anchor
     */
    public function LinkingMode()
    {
        return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
    }
}
