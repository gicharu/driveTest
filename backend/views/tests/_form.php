<?php

use common\models\Questions;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\builder\TabularForm;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use yii\helpers\VarDumper;
VarDumper::dump(Yii::$app->request, 10, true); die;
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
    	'imageUpload' => Url::to(['/media/image-upload']),
    	'imageDelete' => Url::to(['/media/file-delete']),
    	'imageManagerJson' => Url::to(['/media/images-get']),
    	'fileUpload' => Url::to(['/media/file-upload']),
    	'fileDelete' => Url::to(['/media/file-delete']),
    	'fileManagerJson' => Url::to(['/media/files-get']),
    	
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

    <?= $form->field($model, 'score')->dropDownList(Questions::SCORE) ?>
	
	<?=
	TabularForm::widget([
		'dataProvider'=>$dataProvider,
		'form'=>$form,
		'attributes'=>$answerModel->formAttribs,
		'gridSettings'=>['condensed'=>true],
		'checkboxColumn' => false,
		'actionColumn' => false
	]);
	?>

    <div class="form-group">
        <?= Html::submitButton(Icon::show('save') . 'Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a(Icon::show('times') . 'Cancel', ['tests/index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
