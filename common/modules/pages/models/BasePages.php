<?php

namespace common\modules\pages\models;

use Yii;
use yii\db\ActiveRecord;
use common\modules\user\models\User;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $alias
 * @property integer $author_id
 * @property string $snippet
 * @property string $content
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class BasePages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'category_id'], 'integer'],
            [['title', 'content', 'status', 'category_id'], 'required'],
            [['snippet', 'content'], 'string'],
            [['title', 'alias', 'meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pages', 'Идентификатор'),
            'category_id' => Yii::t('pages', 'Категория'),
            'title' => Yii::t('pages', 'Заголовок'),
            'alias' => Yii::t('pages', 'Псевдоним'),
            'author_id' => Yii::t('pages', 'Автор'),
            'snippet' => Yii::t('pages', 'Фрагмент'),
            'content' => Yii::t('pages', 'Содержание'),
            'status' => Yii::t('pages', 'Статус'),
            'created' => Yii::t('pages', 'Дата создания'),
            'updated' => Yii::t('pages', 'Дата редактирования'),
            'meta_title' => Yii::t('pages', 'Meta Title'),
            'meta_description' => Yii::t('pages', 'Meta Description'),
            'meta_keywords' => Yii::t('pages', 'Meta Keywords'),
        ];
    }
}
