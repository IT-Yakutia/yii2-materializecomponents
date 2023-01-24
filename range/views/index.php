<?php

use yii\helpers\Html;

?>
    <div class="form-group <?= !empty($model->getErrors($attribute)) ? 'red-text' : '' ?>">
        <p class="range-field">
            <label>
                <span for="<?= Html::getInputId($model, $attribute); ?>"><?= $model->getAttributeLabel($attribute); ?></span>
                <input type="range" name="<?= $model->formName() ?>[<?= $attribute ?>]" id="<?= Html::getInputId($model, $attribute); ?>" min="<?= $minValue ?>" max="<?= $maxValue ?>" />
            </label>
        </p>
        <?php foreach ($model->getErrors($attribute) as $key => $error) { ?>
            <p class="help-block"><?= $error ?></p>
        <?php } ?>
    </div>