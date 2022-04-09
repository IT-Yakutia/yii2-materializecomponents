<?php

namespace uraankhayayaal\materializecomponents\checkbox;

use Yii;

class WCheckbox extends \yii\base\Widget
{
    public $model;
    public $attribute;
    public $disabled = false;

    public function run()
    {
        return $this->render('index', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'disabled' => $this->disabled,
        ]);
    }
}
