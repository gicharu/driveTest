<?php

namespace frontend\controllers;

use beastbytes\wizard\WizardBehavior;
use common\models\Questions;
use yii\db\Expression;

class WizardController extends \yii\web\Controller {
	
	public $questions;
	
	public function init() {
		$this->questions = Questions::find()
		->orderBy(new Expression('RAND()'))
		->limit(10)
		->asArray()
		->all();
	}
	
	
	public function beforeAction($action) {
		$config = [
			'steps'       => ['question'],
			'timeout'     => 30,
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
	 * Quiz step expired
	 * @param WizardEvent The event
	 */
	public function quizAfterWizard($event)
	{
// 		$event->data = $this->render('result', ['models' => $event->stepData['question']]);
		return $this->redirect('quiz');
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
	 * @param WizardEvent The event
	 */
	public function quizWizardStep($event)
	{
		$model = Questions::findOne($this->questions[$event->n]['id']);
		$t = count($this->questions);
		if(\Yii::$app->request->isPost) {
// 			print_r($_POST); die;
			if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
				$event->data     = $model;
				$event->nextStep = ($event->n < $t - 1
						? WizardBehavior::DIRECTION_REPEAT
						: WizardBehavior::DIRECTION_FORWARD
						);
				$event->handled  = true;
				return; 
			} 
		}
		$event->data = $this->render('question', compact('event', 'model', 't'));
	}
	
	
}
