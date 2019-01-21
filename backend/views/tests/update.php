<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use common\models\Answers;

/* @var $this yii\web\View */
/* @var $model common\models\Questions */
/* @var $dataProvider ActiveDataProvider */
/* @var $answerModel Answers */

$this->title = 'Update Question: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	'dataProvider' => $dataProvider,
    	'answerModel' => new Answers(['isNewRecord' => false])
    ]) ?>

</div>
