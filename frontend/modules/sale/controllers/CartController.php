<?php

	namespace frontend\modules\sale\controllers;

	use Yii;
	use yii\web\Controller;
	use frontend\modules\sale\models\Cart;

	class CartController extends Controller
	{


		public function actionIndex()
		{

			$lastKey = Cart::getProductsInfo();
			$quantity = Cart::getProducts();



			return $this->render('index', [
				'quantity' => $quantity,
				'lastKey' => $lastKey,
			]);

		}

		public function actionAjax($id)
		{

			echo Cart::addProduct($id);die;
			return true;

		}

		public function actionDelete($id, $i)
		{

			Cart::deleteProduct($id, $i);
			return $this->redirect('/sale/cart/index');

		}

		public function actionCheckout()
		{

			if (Cart::sale()) {

				Yii::$app->session->setFlash('success', 'Продажа совершена!');
				Cart::clear();

			}
			Yii::$app->session->setFlash('fail', 'Произошла ошибка!');

			return $this->redirect('/sale/manage/index');

		}


	}