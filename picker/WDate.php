<?php

namespace uraankhayayaal\materializecomponents\picker;

use yii\widgets\InputWidget;

class WDate extends InputWidget
{
    public function run(){
        return $this->render('index', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'field' => $this->field,
            'name' => $this->name,
            'value' => $this->value,
            'options' => $this->options,
        ]);
    }
}