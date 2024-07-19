<?php

namespace backend\controllers;

use backend\models\BookSearch;
use common\models\Author;
use common\models\Book;
use Yii;
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

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $authorIds = Yii::$app->request->post('Book')['author_ids'];
            if (!empty($authorIds) && is_array($authorIds)) {
                foreach ($authorIds as $authorId) {
                    $author = Author::findOne($authorId);
                    if ($author !== null) {
                        $model->link('authors', $author);
                    }
                }
            }

            if ($model->validate()) {
                if ($model->save()) {
                    if ($model->imageFile) {
                        $model->imageFile->saveAs(Yii::getAlias('@uploads') . '/' . $model->image);
                    }
                    Yii::$app->session->setFlash('success', 'Book created successfully.');
                    return $this->redirect(['index', 'id' => $model->id]);
                } else {
                    Yii::error('Failed to save book.');
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

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $currentImage = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                if (!empty($currentImage)) {
                    unlink(Yii::getAlias('@uploads') . '/' . $currentImage);
                }
                // Save new image file
                $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs(Yii::getAlias('@uploads') . '/' . $model->image);
                $model->save(false); // Save again to update the image attribute in database
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