<?php

namespace common\modules\pages\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 * @property string $alias
 * @property integer $view
 * @property integer $position
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 */
class BaseCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'view', 'position', 'status'], 'required'],
            [['parent_id', 'view', 'position', 'status', 'created', 'updated'], 'integer'],
            [['title', 'alias', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('pages', 'Идентификатор'),
            'title' => Yii::t('pages', 'Заголовок'),
            'parent_id' => Yii::t('pages', 'Родитель'),
            'alias' => Yii::t('pages', 'Псевдоним'),
            'view' => Yii::t('pages', 'Вид'),
            'position' => Yii::t('pages', 'Позиция'),
            'status' => Yii::t('pages', 'Статус'),
            'created' => Yii::t('pages', 'Дата создания'),
            'updated' => Yii::t('pages', 'Дата редактирования'),
            'meta_title' => Yii::t('pages', 'Meta Title'),
            'meta_keywords' => Yii::t('pages', 'Meta Keywords'),
            'meta_description' => Yii::t('pages', 'Meta Description'),
        ];
    }
}
