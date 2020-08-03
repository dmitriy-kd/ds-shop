<?php

	namespace frontend\modules\order\controllers;

	use Yii;
	use yii\web\Controller;
	use frontend\modules\order\models\Cart;

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

		}

		public function actionDelete($id, $i)
		{

			Cart::deleteProduct($id, $i);
			return $this->redirect('/order/cart/index');

		}

		public function actionCheckout()
		{

			if (Cart::order()) {

				Yii::$app->session->setFlash('success', 'Заказ оформлен!');
				Cart::clear();

			}
			Yii::$app->session->setFlash('fail', 'Произошла ошибка!');

			return $this->redirect('/order/manage/index');

		}


	}