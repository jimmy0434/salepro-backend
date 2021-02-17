<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/25/2019
 * Time: 11:17 AM
 */

namespace backend\widgets;


use common\models\File;
use yii\base\Widget;

class FileSelector extends Widget
{
    public $model;
    public $property;
    public $title;
    public $fileName;
    public $ext;
    public $name;

    public function run()
    {
        if ($this->model->hasProperty($this->property)) {
            $model = $this->model;
            $property = $this->property;
            $fileId = $model->$property;
            $file = null;
            if ($fileId) {
                $file = File::findOne($fileId);
            }
            return $this->render('file-selector', ['file' => $file, 'model' => $model, 'property' => $property, 'fileId' => $fileId, 'title' => $this->title, 'fileName' => $this->fileName, 'ext' => $this->ext, 'name'=>$this->name]);
        }
        return null;
    }
}
