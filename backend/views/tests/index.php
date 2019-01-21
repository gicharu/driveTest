<?php

use yii\helpers\Html;
use nullref\datatable\DataTable;
use yii\helpers\Url;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Question', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTable::widget([
        'data' => $dataProvider->getModels(),
        'columns' => [
            ['data' => 'id', 'visible' => false],
            'question',
            'score',
        	['data' => 'createdDate', 'title' => 'Created on'],
            //'updated_at',
            //'created_by',
            //'updated_by',

        	[
        		'class' => 'nullref\datatable\LinkColumn',
        		'url' => Url::to(['tests/update']),
        		'options' => [
        			'class' => 'btn btn-success btn-xs text-center',
        			//'value' => \yii\helpers\Url::to('copy?'),
        			'title' => 'Update EVA attribute'
        		],
        		'queryParams' => ['id'],
        		'label' => Icon::show('pencil') .  '</i>Edit',
        	],
        	[
        		'class' => 'nullref\datatable\LinkColumn',
        		'url' => Url::to(['tests/delete']),
        		'options' => [
        			'class' => 'btn btn-danger btn-xs text-center',
        			//'value' => \yii\helpers\Url::to('copy?'),
        			'title' => 'delete EVA attribute'
        		],
        		'queryParams' => ['id'],
        		'label' => Icon::show('trash') .  '</i>Delete',
        	],
        ],
    ]); ?>
</div>
