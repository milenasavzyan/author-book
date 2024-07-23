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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->save(false);

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $authorIds = $model->author_ids;
            foreach ($authorIds as $authorId) {
                $author = Author::findOne($authorId);
                if ($author !== null) {
                    $model->link('authors', $author);
                }
            }

            if ($model->validate()) {
                $imageFile = $model->imageFile;

                $imageName = Yii::$app->security->generateRandomString(10) . '.' . $imageFile->extension;

                $uploadPath = Yii::getAlias('@uploads') . '/' . $imageName;
                if ($imageFile->saveAs($uploadPath)) {
                    $model->image = $imageName;
                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Book created successfully.');
                        return $this->redirect(['index', 'id' => $model->id]);
                    } else {
                        Yii::error('Failed to save book.');
                    }
                } else {
                    Yii::error('Failed to upload image.');
                }
            }

            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Book::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->validate()) {
                if ($model->save()) {
                    if ($model->imageFile) {
                        $model->imageFile->saveAs(Yii::getAlias('@uploads') . '/' . $model->image);
                    }
                }
            }

            $authorIds = Yii::$app->request->post('Book')['author_ids'];
            $model->unlinkAll('authors', true);
            if (!empty($authorIds) && is_array($authorIds)) {
                foreach ($authorIds as $authorId) {
                    $author = Author::findOne($authorId);
                    if ($author !== null) {
                        $model->link('authors', $author);
                    }
                }
            }

            Yii::$app->session->setFlash('success', 'Book updated successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
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
