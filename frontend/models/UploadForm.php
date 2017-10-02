<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($fileName, $subfolderName)
    {
        
        if ($this->validate()) {
            $folderName = Yii::getAlias('@webroot').'/products-images/'.$subfolderName;
            if(!file_exists($folderName)){
                if(!mkdir($folderName, 0777)) {
                    die('Fallo al crear las carpetas...');
                }
            }
            $this->imageFile->saveAs($folderName . '/' . $fileName);
            return true;
        } else {
            return false;
        }
    }
}