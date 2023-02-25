<?php
use yii\helpers\Html;
?>

<?= Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']); ?>
<?php if($model->{$widget->th_attribute}) { ?>
<?= Html::activeHiddenInput($model, $widget->th_attribute, ['class' => 'photo-field']); ?>
<?php } ?>

<div>
	<!-- Modal Trigger -->
	<a class="modal-trigger change-img" href="#modal-<?= $elementId ?>">
	<?= Html::img(
	    $model->{$widget->attribute} != ''
	        ? $model->{$widget->attribute}
	        : $widget->noPhotoImage,
	    [
	    	'style' => 'max-width: 100%;',
	        'id' => $modelThumbnailId,
	        'class' => 'thumbnail',
	        'data-no-photo' => $widget->noPhotoImage,
	    ]
	); ?>
	<div id="preloader-<?= $elementId ?>" class="preloader-wrapper big active hide">
    	<div class="spinner-layer spinner-blue-only">
      		<div class="circle-clipper left">
        		<div class="circle"></div>
      		</div>
      		<div class="gap-patch">
        		<div class="circle"></div>
      		</div>
      		<div class="circle-clipper right">
        		<div class="circle"></div>
      		</div>
    	</div>
  	</div>
	</a>
</div>

<!-- Modal Structure -->
<div id="modal-<?= $elementId ?>" class="modal modal-fixed-footer">
<div class="modal-content">

	<div class="file-field input-field">
      <div class="btn">
        <span>Выберите изображение</span>
        <input type="file" id="<?= $fileInputId ?>" class="<?= $fileInputClass ?>" data-cropp-id="<?= $elementId ?>" data-cropp-wrapper-id="<?= $filePreviewWrapperId ?>" name="file-<?= $elementId ?>" multiple>
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
	<div id="<?= $filePreviewWrapperId ?>"></div>

</div>
<div class="modal-footer">
	<a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="getImgDelete(<?= '\''.Html::getInputId($model, $widget->attribute).'\''; ?>, <?= '\''.$elementId.'\''; ?>)">Очистить</a>
	<a href="#!" class="modal-close waves-effect waves-green btn" onclick="getImgCrop(<?= '\''.$elementId.'\''; ?>);">Обрезать</a>
</div>
</div>