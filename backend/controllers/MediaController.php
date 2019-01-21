<?php

namespace backend\controllers;

class MediaController extends \yii\web\Controller
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
			'files-get' => [
				'class' => 'vova07\imperavi\actions\GetFilesAction',
				'url' => \Yii::$app->homeUrl . 'videos/', // Directory URL address, where files are stored.
				'path' => '@backend/web/videos', // Or absolute path to directory where files are stored.
			],
			'file-upload' => [
				'class' => 'vova07\imperavi\actions\UploadFileAction',
				'url' => \Yii::$app->homeUrl . 'videos/', // Directory URL address, where files are stored.
				'path' => '@backend/web/videos', // Or absolute path to directory where files are stored.
				'uploadOnlyImage' => false, // For any kind of files uploading.
			],
			'file-delete' => [
				'class' => 'vova07\imperavi\actions\DeleteFileAction',
				'url' => \Yii::$app->homeUrl . ' videos/', // Directory URL address, where files are stored.
				'path' => '@backend/web/videos', // Or absolute path to directory where files are stored.
			],
		];
	}

}
