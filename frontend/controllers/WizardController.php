<?php

namespace frontend\controllers;

use beastbytes\wizard\WizardBehavior;
use common\models\Questions;
use yii\db\Expression;
use yii\helpers\VarDumper;
use beastbytes\wizard\WizardEvent;

class WizardController extends \yii\web\Controller {
	
	public $questions;
	
	public function init() {
		$session = \Yii::$app->session;
		if(isset( $session['questions'])) {
			$this->questions = $session['questions'];
		} else {
			$this->questions = Questions::find()
			->orderBy(new Expression('RAND()'))
			->limit(10)
			->asArray()
			->all();
			$session['questions'] = $this->questions;
			
		}
	}
	
	
	public function beforeAction($action) {
		$config = [
			'steps'       => ['question'],
			'timeout'     => 60,
			'forwardOnly' => true,
			'events'      => [
				WizardBehavior::EVENT_WIZARD_STEP => [$this, $action->id.'WizardStep'],
				WizardBehavior::EVENT_AFTER_WIZARD => [$this, $action->id.'AfterWizard'],
				WizardBehavior::EVENT_STEP_EXPIRED => [$this, $action->id.'StepExpired']
			]
		];
		
		if (!empty($config)) {
			$config['class'] = WizardBehavior::className();
			$this->attachBehavior('wizard', $config);
		}
		return parent::beforeAction($action);
		
	}
	
	public function actionQuiz($step = null) {
		//if ($step===null) $this->resetWizard();
		return $this->step($step);
	}
	
	/**
	 * @param WizardEvent The event
	 */
	public function invalidStep($event)
	{
		$event->data = $this->render('invalidStep', compact('event'));
		$event->continue = false;
	}
	
	
	/**
	 * @param $event WizardEvent
	 */
	public function quizAfterWizard($event)
	{
		$quizMap = \Yii::$app->session['quizMap'];
		$rsQuestions = Questions::find()
		->where(['IN', 'id', array_flip($quizMap)])
		->all();
		$resultsArray = [];
		$score = 0;
		foreach ($rsQuestions as $question) {
			$correct = 'Fail';
			if($question->correctAnswer == $quizMap[$question->id]) {
				$correct = 'Pass';
				$score++;
			}
			$resultsArray[] = ['question' => $question->question, 'correct' => $correct];
		}
// 		VarDumper::dump($resultsArray, 10,1); die;
		$event->data = $this->render('result', [
			'resultsArray' => $resultsArray,
			'score' => $score
			
		]);
// 		return $this->redirect('quiz');
	}
	
	/**
	 * Quiz step expired
	 * @param WizardEvent The event
	 */
	public function quizStepExpired($event)
	{
		$n = count($event->stepData) - 1;
		$event->stepData[$n]->expired = true;
	}
	
	/**
	 * Process steps from the quiz
	 * @param $event WizardEvent The event
	 */
	public function quizWizardStep($event)
	{
		$model = Questions::findOne($this->questions[$event->n]['id']);
		$t = count($this->questions);
		if(\Yii::$app->request->isPost) {
// 			var_dump($model->correctAnswer); die;
			$session = \Yii::$app->session;
			$quizMap = is_null($session['quizMap']) ? [] : $session['quizMap'];
			$quizMap[$_POST['Questions']['id']] =  isset($_POST['answer']) ? $_POST['answer'] : '';
			$session['quizMap'] = $quizMap;
// 			if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
				$event->data     = $model;
				$event->nextStep = ($event->n < $t - 1
						? WizardBehavior::DIRECTION_REPEAT
						: WizardBehavior::DIRECTION_FORWARD
						);
				$event->handled  = true;
				return; 
// 			} 
		}
		$event->data = $this->render('question', compact('event', 'model', 't'));
	}
	
	
}
