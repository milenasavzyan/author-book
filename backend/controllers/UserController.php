<?php
namespace backend\controllers;

use backend\models\UserSearch;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\IdentityInterface;


class UserController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException("User not found with ID: $id");
        }

        return $this->render('view', [
            'user' => $user,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = User::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException("User not found.");
        }

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'User information updated successfully.');
                    return $this->redirect(['index', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update user information.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        /* @var ActiveRecord|IdentityInterface $identityClass */
        $identityClass = Yii::$app->user->identityClass;
        $identityClass::findOne(['id' => $id])->delete();
        return $this->redirect(['index']);
    }
}
