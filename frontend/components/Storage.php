<?php

	namespace frontend\components;

	use Yii;
	use yii\base\Component;
	use yii\web\UploadedFile;
	use yii\helpers\FileHelper;

	class Storage extends Component implements StorageInterface
	{

		private $fileName;

		public function saveUploadedFile(UploadedFile $file = null)
		{

			if($file === null) {

				return $this->fileName = 'img/no-image.jpg';
			}

			$path = $this->preparePath($file);

			if ($path && $file->saveAs($path)) {

				return $this->fileName;

			}

		}

		protected function preparePath(UploadedFile $file)
		{

			$this->fileName = $this->getFileName($file);

			$path = $this->getStoragePath() . $this->fileName;

			$path = FileHelper::normalizePath($path);

			if (FileHelper::createDirectory(dirname($path))) {

				return $path;

			}

		}

		protected function getFileName(UploadedFile $file)
		{

			$hash = sha1_file($file->tempName);

			$name = substr_replace($hash, '/', 2, 0);
			$name = substr_replace($name, '/', 5, 0);
			return $name . '.' . $file->extension;

		}

		protected function getStoragePath()
		{

			return Yii::getAlias(Yii::$app->params['storagePath']);

		}

		public function getFile(string $fileName)
		{

			return Yii::$app->params['storageUri'].$fileName;

		}

	}