<?php

namespace uraankhayayaal\materializecomponents\range;

use Yii;

class WRange extends \yii\base\Widget
{
    public $model;
    public $attribute;
    public $disabled = false;
    public $minValue = 0;
    public $maxValue = 5;

    public function run()
    {
        return $this->render('index', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'disabled' => $this->disabled,
            'minValue' => $this->minValue,
            'maxValue' => $this->maxValue,
        ]);
    }
}
