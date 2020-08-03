<?php

	namespace frontend\modules\product\models\forms;

	use Yii;
	use yii\base\Model;
	use frontend\modules\product\models\Products;
	use frontend\models\User;
	use Intervention\Image\ImageManager;

	class ProductsForm extends Model
	{
		//public $id;
		public $name;
		public $startPrice;
		public $finishPrice;
		public $picture;
		public $leftovers;
		public $barcode;

		private $user;

		public function rules()
		{

			return [
				[['name', 'finishPrice', 'leftovers'], 'required'],
				[['name'], 'string','min' => 2],
				[['startPrice', 'finishPrice'], 'number'],
				[['picture'], 'file',
					'skipOnEmpty' => true,
					'extensions' => ['jpg', 'png'],
					'checkExtensionByMimeType' => true],
				[['leftovers', 'barcode'], 'integer'],

			];

		}

		public function save()
		{

			if ($this->validate()) {

				$product = new Products();
				$product->name = $this->name;
				$product->startPrice = $this->startPrice;
				$product->finishPrice = $this->finishPrice;
				$product->picture = Yii::$app->storage->saveUploadedFile($this->picture);
				$product->leftovers = $this->leftovers;
				$product->barcode = $this->barcode;
				$this->resizePicture($product->getImage());
				if ($product->save(false)) {

					return true;

				} //аргумент false отключит проверку валидации в модели frontend\models\Post код по уроку
				return false;
				/*
				$post->save(false);
				return $post->getImage();
				*/
			}

		}

		public function resizePicture($path)
		{
			if ($path == '/uploads/img/no-image.jpg') {
				return false;
			}

			$width = Yii::$app->params['productPicture']['maxWidth'];
			$height = Yii::$app->params['productPicture']['maxHeight'];

			$manager = new ImageManager(array('driver' => 'imagick'));

			$image = $manager->make('C:\OSPanel\domains\ds.com\frontend\web' . $path);

			$image->resize($width, $height, function($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();

			})->save();

		}
		/*
		public function getProduct($id)
		{

			$model = Products::findOne($id);
			$this->id = $model->id;
			$this->name = $model->name;
			$this->startPrice = $model->startPrice;
			$this->finishPrice = $model->finishPrice;
			$this->picture = $model->picture;
			$this->leftovers = $model->leftovers;
			$this->barcode = $model->barcode;
			
			return true;
		}

		public function saveUpdate()
		{



		}
		*/

	}