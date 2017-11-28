<?php

namespace app\models;

use carono\yii2file\FileUploadTrait;
use Yii;

/**
 * This is the model class for table "file_upload".
 */
class FileUpload extends \app\models\base\FileUpload
{
    use FileUploadTrait;

    public function getImageUrl()
    {
        if ($this->fileExist()) {
            return [join('/', ['images', $this->id, $this->getFileName()])];
        } else {
            return '/images/product.png';
        }
    }
}
