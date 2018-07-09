<?php

namespace app\controllers;

use Yii;
use app\models\Note;
use app\models\NoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Access;
use yii\web\ForbiddenHttpException;



/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
			'access' => [
				'class' => AccessControl::class,
				'only' => ['my', 'create', 'update', 'delete', 'shared'],
				'rules' => [
					[
						'roles' => ['@'],
						'allow' => true,
					],
				],
			],
			
			'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
	
	public function actionShared()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(['user' => \Yii::$app->user->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	
	public function actionMy()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search([
			'NoteSearch' => [
				'author' => \Yii::$app->user->id,
			]
		]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Note models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Note model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);		
		
		if (!$model) {			
			throw new NotFoundHttpException('Not found');
		}
		
		$level = Access::getAccessLevel($model);
		
		//var_dump($model);
		//exit;
		
		if ($level === Access::LEVEL_DENIED) {			
			throw new ForbiddenHttpException('No access');
		}
		
		$viewName = ($level === Access::LEVEL_EDIT) ? 'view' : 'view-guest';
		
		return $this->render($viewName, [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Note();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		if (!$model) {			
			throw new NotFoundHttpException('Not found');
		}		
		$level = Access::getAccessLevel($model);
		
		if ($level !== Access::LEVEL_EDIT) {			
			throw new ForbiddenHttpException('No access');
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {		
		$model = $this->findModel($id);
		
		if (!$model) {			
			throw new NotFoundHttpException('Not found');
		}		
		$level = Access::getAccessLevel($model);
		
		if ($level !== Access::LEVEL_EDIT) {			
			throw new ForbiddenHttpException('No access');
		}
		
		$model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
