<?php

	namespace frontend\modules\order\models;

	use yii\db\ActiveRecord;
	use frontend\modules\product\models\Products;

	class Cart extends ActiveRecord
	{

		public static function addProduct($id)
		{
			
			$id = intval($id);
			
			$productsInCart = array();
			
			if(isset($_SESSION['orders']))
			{
				$productsInCart = $_SESSION['orders'];
			}
			
			if(array_key_exists($id, $productsInCart))
			{
				$productsInCart[$id] ++;
			} else {
				$productsInCart[$id] = 1;
			}
			
			$_SESSION['orders'] = $productsInCart;
			
			return self::countItems();
			
		}

		public static function countItems()
		{
			
			if(isset($_SESSION['orders'])) {
				$count = 0;
				foreach($_SESSION['orders'] as $id => $quantity){
					$count = $count + $quantity;
				}
				
				return $count;
			} else {
				return 0;
			}
			
		}

		public static function getProducts()
		{
			if(isset($_SESSION['orders']))
			{
				return $_SESSION['orders'];
			}
			return false;
			
		}

		public static function getProductsInfo()
		{

			$keys = self::getProducts();
			if ($keys) {

				$keys = array_keys($keys);

				for($i = 0; $i < count($keys); $i++)
				{

					$products = Products::find()->where(['id' => $keys[$i]])->one();

					$_SESSION['orderInfo'.$i] = $products;

				}

				return (array_key_last($keys));

			}

			return false;
			

		}

		public static function deleteProduct($id, $i)
		{
			

			unset($_SESSION['orders'][$id]);
			unset($_SESSION['orderInfo'.$i]);

			return true;

		}

		public static function clear()
		{

			$keys = self::getProducts();

			for ($i = 0; $i < count($keys); $i++)
			{

				unset($_SESSION['orderInfo'.$i]);

			}

			unset($_SESSION['orders']);


			return true;

		}

		public static function order()
		{

			$keys = self::getProducts();
			$model = new Orders();
			$products = '';
			$quantityOrdered = '';
			$amount = 0;

			for ($i = 0; $i < count($keys); $i++)
			{

				$products .= $_SESSION['orderInfo'.$i]['id'];
				$products .= ',';
				
				$quantityOrdered .= $keys[$_SESSION['orderInfo'.$i]['id']];
				$quantityOrdered .= ',';

				$amount += $_SESSION['orderInfo'.$i]['startPrice'] * $keys[$_SESSION['orderInfo'.$i]['id']];

			}

			$products = substr($products, 0, strlen($products) - 1);
			$quantityOrdered = substr($quantityOrdered, 0, strlen($quantityOrdered) - 1);

			$model->products = $products;
			$model->quantityOrdered = $quantityOrdered;
			$model->created_at = time();
			$model->updated_at = time();
			$model->status = 0;
			$model->amount = $amount;
			$model->save();
			
			if ($model->save()) {
				return true;
			}
			return false;
			

		}

	}