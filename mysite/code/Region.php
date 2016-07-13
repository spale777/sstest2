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
        'Description' => 'Text',
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
            TextareaField::create('Description'),
            $photo = UploadField::create('Photo')
        );

        $photo->setFolderName('region-photos');
        $photo->getValidator()->setAllowedExtensions([
            'png', 'jpg', 'jpeg', 'gif',
        ]);

        return $fields;
    }
}
