<?php

namespace common\models;

use Yii;
use kartik\builder\TabularForm;

/**
 * This is the model class for table "answers".
 *
 * @property int $id
 * @property int $questionId
 * @property string $answer
 * @property int $correct
 *
 * @property Questions $question
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['questionId', 'answer'], 'required'],
            [['questionId', 'correct'], 'integer'],
            [['answer'], 'string'],
            [['questionId'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['questionId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questionId' => 'Question ID',
            'answer' => 'Answer',
            'correct' => 'Correct',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'questionId']);
    }
    
    public function getFormAttribs() {
    	$attribs = [
    		'id'=>[ // primary key attribute
    			'type'=>TabularForm::INPUT_HIDDEN,
    			'columnOptions'=>['hidden'=>true]
    		], 
    		'answer'=> [
    			'type' => TabularForm::INPUT_TEXT
    		],
    		'correct'=> [
    			'type' => TabularForm::INPUT_DROPDOWN_LIST,
    			'items' => [0 => 'No', 1 => 'Yes']
    		],
    		'questionId' => [
    			'type'=>TabularForm::INPUT_HIDDEN, 
    			'columnOptions'=>['hidden'=>true]
    		],
    		
    	];
    	if($this->isNewRecord) {
    		unset($attribs['id']);
    	}
    	return $attribs;
    	
    }
}
