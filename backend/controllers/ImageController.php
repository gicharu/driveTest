<?php

namespace backend\controllers;

class ImageController extends \yii\web\Controller
{
	public function actions()
	{
		return [
			'images-get' => [
				'class' => 'vova07\imperavi\actions\GetImagesAction',
				'url' => \Yii::$app->homeUrl . 'images/', // Directory URL address, where files are stored.
				'path' => '@backend/web/images', // Or absolute path to directory where files are stored.
			],
			'image-upload' => [
				'class' => 'vova07\imperavi\actions\UploadFileAction',
				'url' => \Yii::$app->homeUrl . 'images/', // Directory URL address, where files are stored.
				'path' => '@backend/web/images', // Or absolute path to directory where files are stored.
			],
			'file-delete' => [
				'class' => 'vova07\imperavi\actions\DeleteFileAction',
				'url' => 'http://my-site.com/statics/', // Directory URL address, where files are stored.
				'path' => '/var/www/my-site.com/web/statics', // Or absolute path to directory where files are stored.
			],
		];
	}

}
