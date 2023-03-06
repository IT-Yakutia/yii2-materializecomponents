<?php

use yii\helpers\Html;

$name = isset($options['name']) ? $options['name'] : Html::getInputName($model, $attribute);
$value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($model, $attribute);

?>

<input type="text" name="<?= $name ?>" id="<?= $options['id'] ?>" class="<?= $options['class'] ?> timepicker" value="<?= $value ?>">

<?php $this->registerJs("
    $('.timepicker').timepicker({
        twelveHour: false
    });
",$this::POS_READY);?>