<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Questions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question') ?>

    <?= $form->field($model, 'description')->widget(Widget::className(), [
    'settings' => [
        'minHeight' => 200,
    	'imageUpload' => Url::to(['/image/image-upload']),
    	'imageDelete' => Url::to(['/image/file-delete']),
    	'imageManagerJson' => Url::to(['/image/images-get']),
    	'fileUpload' => Url::to(['/default/file-upload']),
    	'fileDelete' => Url::to(['/default/file-delete']),
    	'fileManagerJson' => Url::to(['/default/files-get']),
        'plugins' => [
            'clips',
        	'imagemanager',
        	'filemanager',
        	'html','formatting','bold','italic','deleted','unorderedlist','orderedlist',
        	'outdent','indent','image','file','link','alignment','horizontalrule'
        ],
        'clips' => [
            ['Lorem ipsum...', 'Lorem...'],
            ['red', '<span class="label-red">red</span>'],
            ['green', '<span class="label-green">green</span>'],
            ['blue', '<span class="label-blue">blue</span>'],
        ],
    ],
]);?>

    <?= $form->field($model, 'score')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
