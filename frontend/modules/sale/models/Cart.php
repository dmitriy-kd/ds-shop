<?php

	namespace frontend\modules\sale\models;

	use yii\db\ActiveRecord;
	use frontend\modules\product\models\Products;
	use frontend\modules\order\models\Orders;

	class Cart extends ActiveRecord
	{

		public static function addProduct($id)
		{
			
			$id = intval($id);
			
			$productsInCart = array();
			
			if(isset($_SESSION['products']))
			{
				$productsInCart = $_SESSION['products'];
			}
			
			if(array_key_exists($id, $productsInCart))
			{
				$productsInCart[$id] ++;
			} else {
				$productsInCart[$id] = 1;
			}
			
			$_SESSION['products'] = $productsInCart;
			
			return self::countItems();
			
		}

		public static function countItems()
		{
			
			if(isset($_SESSION['products'])) {
				$count = 0;
				foreach($_SESSION['products'] as $id => $quantity){
					$count = $count + $quantity;
				}
				
				return $count;
			} else {
				return 0;
			}
			
		}

		public static function getProducts()
		{
			if(isset($_SESSION['products']))
			{
				return $_SESSION['products'];
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

					$_SESSION['productInfo'.$i] = $products;

				}

				return (array_key_last($keys));

			}

			return false;
			

		}

		public static function deleteProduct($id, $i)
		{
			

			unset($_SESSION['products'][$id]);
			unset($_SESSION['productInfo'.$i]);

			return true;

		}

		public static function clear()
		{

			$keys = self::getProducts();

			for ($i = 0; $i < count($keys); $i++)
			{

				unset($_SESSION['productInfo'.$i]);

			}

			unset($_SESSION['products']);


			return true;

		}

		public static function sale()
		{

			$keys = self::getProducts();
			$model = new Sales();
			$products = '';
			$quantityProducts = '';
			$priceProducts = '';
			$amount = 0;
			$orderAmount = 0;

			for ($i = 0; $i < count($keys); $i++)
			{

				$products .= $_SESSION['productInfo'.$i]['id'];
				$products .= ',';

				$leftovers = Products::find()->where(['id' => $_SESSION['productInfo'.$i]['id']])->one();
				
				$quantityProducts .= $keys[$_SESSION['productInfo'.$i]['id']];
				$quantityProducts .= ',';

				$leftovers->leftovers = $leftovers->leftovers - $keys[$_SESSION['productInfo'.$i]['id']];

				$leftovers->save();

				$priceProducts .= $_SESSION['productInfo'.$i]['finishPrice'];
				$priceProducts .= ',';

				$amount += $_SESSION['productInfo'.$i]['finishPrice'] * $keys[$_SESSION['productInfo'.$i]['id']];
				$orderAmount += $_SESSION['productInfo'.$i]['startPrice'] * $keys[$_SESSION['productInfo'.$i]['id']];

			}

			$products = substr($products, 0, strlen($products) - 1);
			$quantityProducts = substr($quantityProducts, 0, strlen($quantityProducts) - 1);
			$priceProducts = substr($priceProducts, 0, strlen($priceProducts) - 1);

			$model->products = $products;
			$model->quantityProducts = $quantityProducts;
			$model->priceProducts = $priceProducts;
			$model->amount = $amount;
			$model->dateSale = time();

			$order = new Orders();

			$order->products = $products;
			$order->quantityOrdered = $quantityProducts;
			$order->created_at = time();
			$order->updated_at = time();
			$order->status = 0;
			$order->amount = $orderAmount;
			$order->save();
			
			if ($model->save()) {
				return true;
			}
			return false;
			

		}

	}