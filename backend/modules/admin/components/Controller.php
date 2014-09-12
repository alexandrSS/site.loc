<?php
namespace backend\modules\admin\components;

use yii\filters\AccessControl;

/**
 * Основной контроллер backend-приложения.
 * От данного контроллера унаследуются все остальные контроллеры backend-приложения.
 */
class Controller extends \yii\web\Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => [ 'BackendController' ]
					]
				]
			]
		];
	}
}