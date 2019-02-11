<?php
use yii\helpers\Html;
$this->title = "Quiz results";
?>
<h2>Quiz Results</h2>
<h3> You have answered <?= $score ?> out of <?= count($resultsArray)?> questions correctly</h3>
<?= \nullref\datatable\DataTable::widget([
    'data' => $resultsArray,
    'columns' => [
        'question',
        [
        	'data' => 'correct',
        	'title' => 'Result'
        ]
    ],
]) ?>