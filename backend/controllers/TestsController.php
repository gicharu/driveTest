<?php

namespace backend\controllers;

use Yii;
use common\models\Questions;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\data\ArrayDataProvider;
use common\models\Answers;
use yii\base\Model;

/**
 * TestsController implements the CRUD actions for Questions model.
 */
class TestsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Questions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Questions::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Questions model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Questions();
		$answerModel = new Answers();
// 		VarDumper::dump(array_fill(0, 4, $answerModel), 20, true); die;
        $dataProvider = new ArrayDataProvider([
        	'allModels' => array_fill(0, 4, $answerModel)
        ]);
        $transaction = \Yii::$app->db->beginTransaction();
        $transactionStatus = true;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$answerModels = $dataProvider->getModels();
        	$postData = \Yii::$app->request->post($answerModel->formName());
        	if(Model::loadMultiple($answerModels, \Yii::$app->request->post())) {
        		$transactionStatus = false;
//         		die;
        		for ($key = 0; $key <= (count($answerModels) - 1); $key++) {
//         		VarDumper::dump($key,10,true); 
        			unset($answerModels[$key]->id);
        			$answerModels[$key]->setIsNewRecord(true);
        			$answerModels[$key]->questionId = $model->id;
        			$answerModels[$key]->answer = $postData[$key]['answer'];
        			$answerModels[$key]->correct = $postData[$key]['correct'];
        			if($answerModels[$key]->save()) {
        				$transactionStatus = true;
        			}
        		}
        	}
//         	die;
        	if($transactionStatus) {
        		$transaction->commit();
        		Yii::$app->session
        		->setFlash('success', 'Question added successfully');
        		return $this->redirect(['index']);
        	}
        	if($transactionStatus == false) {
        		$transaction->rollBack();
        		\Yii::error($answerModel->getErrors());
        		Yii::$app->session
        		->setFlash('danger', 'An error occurred while saving the question, contact your administrator');
        	}
        }

        return $this->render('create', [
            'model' => $model,
        	'dataProvider' => $dataProvider,
        	'answerModel' => $answerModel
        ]);
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
        	'query' => Answers::find()->where(['questionId' => $model->id])
        ]);
        $transaction = \Yii::$app->db->beginTransaction();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$transactionStatus = true;
        	$answerModels = $dataProvider->getModels();
			$postData = $_POST['Answers']; 
			sort($postData);
     
        	foreach ($answerModels as $key => $answerModel) {
        		$answerModel->answer = $postData[$key]['answer'];
        		$answerModel->correct = $postData[$key]['correct'];
        		if(false == $answerModel->save()) {
        			$transactionStatus = false;
        		}
        	}
        	if($transactionStatus) {
        		$transaction->commit();
        		Yii::$app->session
        		->setFlash('success', 'Question saved successfully');
            	return $this->redirect(['index']);
        	}
        	if($transactionStatus == false) {
        		$transaction->rollBack();
        		Yii::$app->session
        		->setFlash('danger', 'An error occurred while saving the question, contact your administrator');
        	}
        }

        return $this->render('update', [
            'model' => $model,
        	'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    	if($this->findModel($id)->delete()) {
    		Yii::$app->session
    		->setFlash('success', 'Question deleted successfully');
    	} else {
    		Yii::$app->session
    		->setFlash('danger', 'An error occurred while deleting the question, contact your administrator');
    	}

        return $this->redirect(['index']);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
