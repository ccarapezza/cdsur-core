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
            if(!mkdir(Yii::getAlias('@webroot').'/products-images/'.$subfolderName, 0777)) {
                die('Fallo al crear las carpetas...');
            }
            $this->imageFile->saveAs(Yii::getAlias('@webroot').'/products-images/'. $subfolderName . '/' . $fileName);
            return true;
        } else {
            return false;
        }
    }
}