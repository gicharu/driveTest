<?php

use common\models\Answers;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\Questions */
/* @var $dataProvider ArrayDataProvider */
/* @var $answerModel Answers */

$this->title = 'Add Question';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	'dataProvider' => $dataProvider,
    	'answerModel' => $answerModel
    ]) ?>

</div>
