<?php

namespace backend\modules\pages\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\behaviors\TransliterateBehavior;
use common\behaviors\PurifierBehavior;
use common\modules\pages\models\BaseCategory;

class Category extends BaseCategory
{
    /**
     * Ключи кэша которые использует модель.
     */
    const CACHE_CATEGORIES_LIST_DATA = 'categoriesListData';

    /**
     * Вид страниц
     * -Страница с текстом
     * -Статьи
     */
    const PAGE_TEXT = 1;
    const PAGE_ARTICLES = 2;

    /**
     * Позиция категории
     * -Верхнее меню
     * -Левое меню
     */
    const CATEGORY_POSITION_TOP = 1;
    const CATEGORY_POSITION_LEFT = 2;

    /**
     * Статус категории
     * -Скрыта
     * -Опубликована
     */
    const CATEGORY_STATUS_HIDDEN = 0;
    const CATEGORY_STATUS_PUBLISHED = 1;

    /**
     * @var Читабельный вид страницы
     */
    protected $_pageView;

    /**
     * @var Читабельная позиция категории
     */
    protected $_categoryPosition;

    /**
     * @var Читабельный статус категории
     */
    protected $_categoryStatus;

    /**
     * @var Читабельный статус категории
     */
    protected $_parentList;

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
     * @inheritdoc
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @return array Массив доступных страниц
     */
    public static function getPageViewArray()
    {
        return [
            self::PAGE_TEXT => Yii::t('category', 'Страница с текстом'),
            self::PAGE_ARTICLES => Yii::t('category', 'Статьи'),
        ];
    }

    /**
     * @return array Массив доступных позиций меню
     */
    public static function getCategoryPositionArray()
    {
        return [
            self::CATEGORY_POSITION_TOP => Yii::t('category', 'Верхнее меню'),
            self::CATEGORY_POSITION_LEFT => Yii::t('category', 'Левое меню')
        ];
    }

    /**
     * @return array
     */
    public static function getCategoryStatusArray()
    {
        return [
            self::CATEGORY_STATUS_HIDDEN => Yii::t('category', 'Скрыта'),
            self::CATEGORY_STATUS_PUBLISHED => Yii::t('category', 'Опубликована')
        ];
    }

    /**
     * Читабельный вид страницы
     * @return mixed
     */
    public function getPageView()
    {
        if($this->_pageView === NULL){
            $pageView = self::getPageViewArray();
            $this->_pageView = $pageView[$this->view];
        }
        return $this->_pageView;
    }

    /**
     * Читабельная позиция категории
     * @return mixed
     */
    public function getCategoryPosition()
    {
        if($this->_categoryPosition === NULL){
            $categoryPosition = self::getCategoryPositionArray();
            $this->_categoryPosition = $categoryPosition[$this->position];
        }
        return $this->_categoryPosition;
    }

    /**
     * Читабельный статус котегории
     * @return mixed
     */
    public function getCategoryStatus()
    {
        if($this->_categoryStatus === NULL){
            $categoryStatus = self::getCategoryStatusArray();
            $this->_categoryStatus = $categoryStatus[$this->status];
        }
        return $this->_categoryStatus;
    }

    /**
     * Читабельный статус котегории
     * @return mixed
     */
    public function getParentList()
    {
        if(!empty($this->parent_id)){
            if($this->_parentList === NULL){
                $parentList = self::getParentListArray();
                $this->_parentList = $parentList[$this->parent_id];
            }
            return $this->_parentList;
        }
        return $this->_parentList = NULL;
    }
     /**
     * @return array [[DropDownList]] массив категорий.
     */
    public static function getCategoryArray()
    {
        $key = self::CACHE_CATEGORIES_LIST_DATA;
        $value = Yii::$app->getCache()->get($key);
        if ($value === false || empty($value)) {
            $value = self::find()->select(['id', 'title'])->published()->asArray()->all();
            $value = ArrayHelper::map($value, 'id', 'title');
            Yii::$app->cache->set($key, $value);
        }
        return $value;
    }

    public static function getParentListArray($parent_id = null, $level = 0)
    {
        if (empty($parent_id)) {
            $parent_id = null;
        }

        $categories = Category::find()->where(['parent_id' => $parent_id])->all();

        $list = array();

        foreach ($categories as $category) {

            $category->title = str_repeat(' - ', $level) . $category->title;

            $list[$category->id] = $category->title;

            $list = ArrayHelper::merge($list, Category::getParentListArray($category->id, $level + 1));
        }

        return $list;
    }



    public static function getMenu($parent_id = null, $level = 0)
    {
        if (empty($parent_id)) {
            $parent_id = null;
        }

        $categories = Category::find()->where(['parent_id' => $parent_id])->all();

        $list = array();

        foreach ($categories as $category) {

            //$category->title = str_repeat(' - ', $level) . $category->title;

            //$list[]['label'] = $category->title;
            //$list[]['alias'] = $category->alias;
            $list[] = array(
                'label' => $category->title,
                'url' => $category->alias
            );

            $list = ArrayHelper::merge($list, self::getMenu($category->id, $level + 1));
        }

        return $list;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            Yii::$app->getCache()->delete(self::CACHE_CATEGORIES_LIST_DATA);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete($insert)
    {
        if(parent::beforeDelete($insert)) {
            Yii::$app->getCache()->delete(self::CACHE_CATEGORIES_LIST_DATA);
            return true;
        }
        return false;
    }
}