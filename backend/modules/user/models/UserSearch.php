<?php

namespace backend\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\user\models\User;

/**
 * Модель поиска по [[User]] записям.
 */
class UserSearch extends Model
{
    /**
     * @var string Логин пользователя.
     */
    public $username;

    /**
     * @var string E-mail пользователя.
     */
    public $email;

    /**
     * @var string Роль пользователя.
     */
    public $role;

    /**
     * @var string Статус пользователя.
     */
    public $status;
    /**
     * @var string Дата создания.
     */
    public $created_at;
    /**
     * @var string Дата обновления.
     */
    public $updated_at;

    public function rules()
    {
        return [
            // Безопасные атрибуты
            [['username', 'email'], 'string'],

            // Роль [[role]]
            ['role', 'in', 'range' => array_keys(User::getRoleArray())],

            // Статус [[status]]
            ['status', 'in', 'range' => array_keys(User::getStatusArray())],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }



    /**
     * Поиск записей по переданным критериям.
     * @param array|null Массив с критериями для выборки.
     * @return ActiveDataProvider dataProvider с результатами поиска.
     */
    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->getModule('user')->recordsPerPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'username', true);
        $this->addCondition($query, 'email', true);
        $this->addCondition($query, 'role');
        $this->addCondition($query, 'status');

        return $dataProvider;
    }

    /**
     * Функция добавления условий поиска.
     * @param Query $query Экземпляр выборки.
     * @param string $attribute Имя отрибута по которому нужно искать.
     * @param boolean $partialMatch Тип добавляемого сравнения. Строгое совпадение или частичное.
     */
    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
