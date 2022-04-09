<?php

use yii\helpers\Html;

?>
	<div class="form-group <?= !empty($model->getErrors($attribute)) ? 'red-text' : '' ?>">
		<p>
		    <label>
		    <input type="hidden" name="<?= $model->formName() ?>[<?= $attribute ?>]" value="0" <?= ($disabled == 'disabled') ? 'disabled' : ''; ?> />
		    <input type="checkbox" id="<?= Html::getInputId($model, $attribute); ?>" name="<?= $model->formName() ?>[<?= $attribute ?>]" <?= ($model->$attribute) ? 'checked' : ''; ?> <?= ($disabled == 'disabled') ? 'disabled' : ''; ?> value="1">
		    <span for="<?= Html::getInputId($model, $attribute); ?>"><?= $model->getAttributeLabel($attribute); ?></span>
		    </label>
		</p>
		<?php foreach ($model->getErrors($attribute) as $key => $error) { ?>
			<p class="help-block"><?= $error ?></p>
		<?php } ?>
	</div>