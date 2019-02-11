<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property string $question
 * @property string $description
 * @property int $score
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Answers[] $answers
 */
class Questions extends \yii\db\ActiveRecord
{
	const SCORE = [
		1 => 'Easy',
		5 => 'Medium',
		10 => 'Difficult'
	];
	
	
	public $currentQuestion;
	public $expired = false;
	
	public function behaviors() {
		return [
			['class' => TimestampBehavior::className()],
			['class' => BlameableBehavior::className()]
		];
	}
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['question', 'description'], 'string'],
            [['score', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'description' => 'Description',
            'score' => 'Score',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
    
    public function beforeDelete() {
    	Answers::deleteAll(['questionId' => $this->id]);
    	return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['questionId' => 'id']);
    }
    public function getCorrectAnswer() {
    	$rsAnswer = Answers::find()->where(['questionId' => $this->id, 'correct' => 1])->one();
    	return $rsAnswer->id;
    }
    
    public function getCreatedDate()
    {
    	return date('d-m-Y', $this->created_at);
    }
    public function getScoreText()
    
    {
    	return self::SCORE[$this->score];
    }
    
    public function fields()
    {
    	return array_merge(parent::fields(), ['createdDate', 'scoreText']);
    }
    
   
}
