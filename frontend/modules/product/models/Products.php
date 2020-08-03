<?php

namespace frontend\modules\product\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $startPrice
 * @property float|null $finishPrice
 * @property string|null $picture
 */
class Products extends \yii\db\ActiveRecord
{



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'startPrice' => 'Start Price',
            'finishPrice' => 'Finish Price',
            'picture' => 'Picture',
            'leftovers' => 'Leftovers',
            'barcode' => 'Barcode'
        ];
    }

    public function getImage()
    {

    	return Yii::$app->storage->getFile($this->picture);

    }

    public function saveImage()
    {
    	
    	$file = Yii::$app->storage->saveUploadedFile($this->picture);

    	return $this->picture = $file;

    }
}
