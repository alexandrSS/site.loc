<?php

namespace backend\modules\pages\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\behaviors\TransliterateBehavior;
use common\behaviors\PurifierBehavior;
use common\modules\pages\models\BasePages;
use common\modules\user\models\User;

class Pages extends BasePages
{

    /**
     * Статус страницы
     * -Скрыта
     * -Опубликована
     */
    const PAGES_STATUS_HIDDEN = 0;
    const PAGES_STATUS_PUBLISHED = 1;

    /**
     * @var Читабельный статус страницы
     */
    protected $_pagesStatus;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
            'transliterateBehavior' => [
                'class' => TransliterateBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['title' => 'alias'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['title' => 'alias'],
                ]
            ],
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'textAttributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
                    ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
                ],
                'purifierOptions' => [
                    'HTML.AllowedElements' => Yii::$app->params['allowHtmlTags']
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public static function getPagesStatusArray()
    {
        return [
            self::PAGES_STATUS_HIDDEN => Yii::t('category', 'Скрыта'),
            self::PAGES_STATUS_PUBLISHED => Yii::t('category', 'Опубликована')
        ];
    }

    /**
     * Читабельный статус страницы
     * @return mixed
     */
    public function getPagesStatus()
    {
        if($this->_pagesStatus === NULL){
            $categoryStatus = self::getPagesStatusArray();
            $this->_pagesStatus = $categoryStatus[$this->status];
        }
        return $this->_pagesStatus;
    }


    /**
     * @return Автор страницы.
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }


    /**
     * @return Категория страницы.
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }



    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert)){
            return false;
        }

        // Если новая запись
        if($this->isNewRecord){
            // Определяем автора
            $this->author_id = Yii::$app->user->id;

        }

        return true;

    }
}