<?php

use yii\helpers\Html;

$name = isset($options['name']) ? $options['name'] : Html::getInputName($model, $attribute);
$value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($model, $attribute);

?>

<input type="hidden" name="<?= $name ?>" id="<?= $options['id'] ?>" class="<?= $options['class'] ?>" value="<?= $value ?>">
<input type="text" id="materialize_date_input-<?= $options['id'] ?>" class="<?= $options['class'] ?> datepicker" value="<?= $value == null ? '' : date('M d, Y', $value)?>" placeholder="Aug 16, 2023">

<?php $this->registerJs("
    $('.datepicker').datepicker();
    var Format = {
        to: function(date){
            var tDate = new Date(date);
            var currnetTimeZoneOffsetInHours = tDate.getTimezoneOffset() * 60; // Minets to seconds
            return Date.parse(tDate) / 1000 - currnetTimeZoneOffsetInHours;
        },
    };
    $('#materialize_date_input-".$options['id']."').on('change', function(e){
        $('#".$options['id']."').val(Format.to(this.value));
    });
",$this::POS_READY);?>