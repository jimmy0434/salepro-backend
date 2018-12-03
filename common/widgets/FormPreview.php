<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/3/2018
 * Time: 11:31 AM
 */

namespace common\widgets;


use yii\base\Widget;
use yii\helpers\Html;

class FormPreview extends Widget
{
    public $form;

    public function run(){
        return $this->render("form-preview",["form" => $this->form]);
    }

    public function createInputField($field){
        /**
         * @var $id integer
         * @var $name string
         * @var $oldName string
         * @var $label string
         * @var $note string
         * @var $type string
         * @var $dataType string
         * @var $placeholder string
         * @var $required string
         * @var $validation string
         * @var $value string
         * @var $options array
         */
        extract($field);
        ob_start();
        ?>
        <div class="form-group">
            <label for="<?= $name ?>"><?= $label.($required?' <span class="text-danger">*</span>':'') ?></label>
            <?php
            switch($type){
                case "text":
                    echo Html::textInput($name,null, ['placeholder' => $placeholder, 'class' => 'form-control']);
                    break;
                case "textarea":
                    echo Html::textarea($name,null, ['placeholder' => $placeholder, 'class' => 'form-control']);
                    break;
                case "dropdownlist":
                    echo Html::dropDownList($name,null, $options, ['class' => 'form-control']);
                    break;
                case "checkbox":
                    echo Html::checkbox($name,null);
                    break;
                case "radio":
                    echo Html::radioList($name,null, $options);
                    break;
            }
            ?>
        </div>
        <?php
        echo ob_get_clean();
    }

    public function renderForm($form, $parent = null){
        echo '<h2>'.$form['name'].($parent?' <small>many `'.$form['name'].'` related to one `'.$parent['name'].'`</small>':'').'</h2>';
        $fields = $form['fields'];
        if(!empty($fields) && is_array($fields)){
            foreach($fields as $field){
                /**
                 * @var $id integer
                 * @var $name string
                 * @var $oldName string
                 * @var $label string
                 * @var $note string
                 * @var $type string
                 * @var $dataType string
                 * @var $placeholder string
                 * @var $required string
                 * @var $validation string
                 * @var $value string
                 * @var $options array
                 */
                extract($field);
                switch($type){
                    case 'separator':
                        echo '<hr>';
                    break;
                    case 'title':
                        echo '<h3>'.$value.'</h3>';
                        break;
                    case 'subform':
                        $this->renderForm($field, $form);
                        break;
                    default:
                        $this->createInputField($field);
                        break;
                }
            }
        }
    }
}