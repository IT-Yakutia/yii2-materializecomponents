<?php

namespace uraankhayayaal\materializecomponents\imgcropper\actions;

use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Yii;

class UploadAction extends Action
{
    public $path;
    public $url;
    public $uploadParam = 'file';
    public $maxSize = 10485760;
    public $extensions = 'jpeg, jpg, png, gif';
    public $jpegQuality = 75;
    public $pngCompressionLevel = 9;
    public $width = 100;
    public $height = 100;
    public $thWidth = 42;
    public $thHeight = 42;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->url === null) {
            throw new InvalidConfigException('MISSING_ATTRIBUTE');
        } else {
            $this->url = rtrim($this->url, '/') . '/';
        }
        if ($this->path === null) {
            throw new InvalidConfigException('MISSING_ATTRIBUTE');
        } else {
            $this->path = rtrim(Yii::getAlias($this->path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $imageShortSize = Yii::$app->formatter->asShortSize($this->maxSize);
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $model = new DynamicModel(compact($this->uploadParam));
            $model->addRule($this->uploadParam, 'image', [
                'maxSize' => $this->maxSize,
                'tooBig' => "Размер изображения должно быть не больше {$imageShortSize}",
                'extensions' => explode(', ', $this->extensions),
                'wrongExtension' => 'EXTENSION_ERROR'
            ])->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError($this->uploadParam)
                ];
            } else {
                $model->{$this->uploadParam}->name = uniqid() . '.' . $model->{$this->uploadParam}->extension;
                $request = Yii::$app->request;

                $width = $request->post('width', $this->width);
                $height = $request->post('height', $this->height);
                $x = $request->post('x', 0);
                $y = $request->post('y', 0);

                $image = Image::crop(
                    $file->tempName . $request->post('filename'),
                    intval($width),
                    intval($height),
                    [$x<0?0:$x, $y<0?0:$y]
                )/*->resize(
                    new Box($width, $height)
                )*/;

                if (!file_exists($this->path) || !is_dir($this->path))
                    \yii\helpers\FileHelper::createDirectory($this->path, $mode = 0775, $recursive = true);

                $saveOptions = [
                    'jpeg_quality' => $this->jpegQuality,
                    'png_compression_level' => $this->pngCompressionLevel,
                    'resolution-units' => ImageInterface::RESOLUTION_PIXELSPERINCH,
                    'resolution-x' => 72,
                    'resolution-y' => 72,
                ];
                if ($image->save($this->path . $model->{$this->uploadParam}->name, $saveOptions)) {
                    // generate a thumbnail image
                    $thumbnail = Image::thumbnail($this->path . $model->{$this->uploadParam}->name, $this->thWidth, $this->thHeight);
                    $thumbnail->save(Yii::getAlias($this->path . 'th_' . $model->{$this->uploadParam}->name), ['quality' => 50]);
                    $result = [
                        'filelink' => $this->url . $model->{$this->uploadParam}->name,
                        'th_filelink' => $this->url . 'th_' . $model->{$this->uploadParam}->name
                    ];
                } else {
                    $result = [
                        'error' => 'Невозможно сохранить изобаржение в диск сервера'
                    ];
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException('ONLY_POST_REQUEST');
        }
    }
}
