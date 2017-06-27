<?php

namespace app\models;

use Yii;
use carono\yii2file\FileUpload as BaseFileUpload;

/**
 * This is the model class for table "file_upload".
 */
class FileUpload extends BaseFileUpload
{
    public function getImageUrl()
    {
        if ($this->fileExist()) {
            return [join('/', ['images', $this->id, $this->getFullName()])];
        } else {
            return '/images/product.png';
        }
    }
}
