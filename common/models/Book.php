<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property int|null $published_year
 *
 * @property Author[] $authors
 */

class Book extends ActiveRecord
{
    public $imageFile;
    public $author_ids;

    public static function tableName()
    {
        return 'book';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['publication_year'], 'integer'],
            [['image', 'title'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->imageFile instanceof UploadedFile) {
            $uploadPath = Yii::getAlias('@uploads');
            $fileName = uniqid() . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . '/' . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                return $fileName;
            }
        }
        return null;
    }

    public function getImageUrl()
    {
        if ($this->image) {
            return Yii::getAlias('@web/uploads') . '/' . $this->image;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->imageFile !== null) {
                $this->image = $this->upload();
            }
            return true;
        }
        return false;
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('authorBooks');
    }
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'id']);
    }

}
