<?php

namespace backend\controllers;

use backend\models\BookSearch;
use common\models\Author;
use common\models\Book;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BookController extends SiteController
{
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $book = Book::findOne($id);
        if (!$book) {
            throw new \yii\web\NotFoundHttpException("Book not found with ID: $id");
        }

        return $this->render('view', [
            'book' => $book,
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) {
                        $authorIds = $model->author_ids;
                        foreach ($authorIds as $authorId) {
                            $author = Author::findOne($authorId);
                            if ($author !== null) {
                                $model->link('authors', $author);
                            }
                        }

                        if ($model->imageFile) {
                            $imageName = Yii::$app->security->generateRandomString(10) . '.' . $model->imageFile->extension;
                            $uploadPath = Yii::getAlias('@uploads') . '/' . $imageName;
                            if ($model->imageFile->saveAs($uploadPath)) {
                                $model->image = $imageName;
                                $model->save(false);
                            } else {
                                Yii::error('Failed to upload image.');
                            }
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Book created successfully.');
                        return $this->redirect(['index', 'id' => $model->id]);
                    } else {
                        Yii::error('Failed to save book.');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Error: ' . $e->getMessage());
                }
            } else {
                Yii::error('Validation error: ' . print_r($model->errors, true));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    public function actionDelete($id)
    {
        $model = Book::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $imageToDelete = $model->image;

        if ($model->delete()) {
            if (!empty($imageToDelete)) {
                unlink(Yii::getAlias('@uploads') . '/' . $imageToDelete);
            }
            Yii::$app->session->setFlash('success', 'Book deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete book.');
        }

        return $this->redirect(['index']);
    }

}
