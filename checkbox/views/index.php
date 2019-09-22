<?php

use yii\helpers\Html;

?>
		<p>
		    <label>
		    <input type="hidden" name="<?= $model->formName() ?>[<?= $attribute ?>]" value="0" />
		    <input type="checkbox" id="<?= Html::getInputId($model, $attribute); ?>" name="<?= $model->formName() ?>[<?= $attribute ?>]" <?= ($model->$attribute) ? 'checked' : ''; ?>  value="1">
		    <span for="<?= Html::getInputId($model, $attribute); ?>"><?= $model->getAttributeLabel($attribute); ?></span>
		    </label>
		</p>