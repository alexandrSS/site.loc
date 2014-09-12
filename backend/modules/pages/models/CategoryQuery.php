<?php
namespace backend\modules\pages\models;

use yii\db\ActiveQuery;

/**
 * Class CategoryQuery
 * @package common\modules\blogs\models\query
 * Класс кастомных запросов модели [[Category]]
 */
class CategoryQuery extends ActiveQuery
{
	/**
	 * Выбираем только опубликованные записи.
	 * @param ActiveQuery $query
	 */
	public function published()
	{
		$this->andWhere('status = :status', [':status' => Category::CATEGORY_STATUS_PUBLISHED]);
		return $this;
	}

	/**
	 * Выбираем только неопубликованные записи.
	 * @param ActiveQuery $query
	 */
	public function unpublished()
	{
		$this->andWhere('status = :status', [':status' => Category::CATEGORY_STATUS_HIDDEN]);
		return $this;
	}
}