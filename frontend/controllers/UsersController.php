<?php

namespace frontend\controllers;

use Yii;
use app\models\Users;
use app\models\Address;
use app\models\Model;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$user = $this->findModel($id);
		
        return $this->render('view', [
            'model' => $user,
			'addresses' => $user->addresses,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new Users();
		$addresses = [new Address];
		

        if ($user->load(Yii::$app->request->post())) {

            $addresses = Model::createMultiple(Address::classname());
            Model::loadMultiple($addresses, Yii::$app->request->post());

            // validate all models
            $valid = $user->validate();
            $valid = Model::validateMultiple($addresses) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $user->save(false)) {
                        foreach ($addresses as $add) {
                            $add->user = $user->id;
                            if (! ($flag = $add->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $user->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
		}
		
        return $this->render('create', [
			'user' => $user,
			'addresses' => $addresses,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $addresses = $user->addresses;

        if ($user->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($addresses, 'id', 'id');
            $addresses = Model::createMultiple(Address::classname(), $addresses);
            Model::loadMultiple($addresses, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($addresses, 'id', 'id')));

            // validate all models
            $valid = $user->validate();
            $valid = Model::validateMultiple($addresses) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $user->save(false)) {
                        if (!empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($addresses as $address) {
                            $address->user = $user->id;
                            if (! ($flag = $address->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $user->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'user' => $user,
            'addresses' => (empty($addresses)) ? [new Address] : $addresses
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
