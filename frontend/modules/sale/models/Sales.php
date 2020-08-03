<?php

namespace frontend\modules\sale\models;

use Yii;
use frontend\modules\product\models\Products;

/**
 * This is the model class for table "sales".
 *
 * @property int $id
 * @property string|null $products
 * @property string $quantityProducts
 * @property string $priceProducts
 * @property int $amount
 * @property int $dateSale
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products', 'quantityProducts', 'priceProducts', 'amount', 'dateSale'], 'required'],
            [['amount', 'dateSale'], 'integer'],
            [['products', 'quantityProducts', 'priceProducts'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'products' => 'Products',
            'quantityProducts' => 'Quantity Products',
            'priceProducts' => 'Price Products',
            'amount' => 'Amount',
            'dateSale' => 'Date Sale',
        ];
    }

    public function getProductName($dateTest)
    {

        $sales = $this->find()->where(['between', 'dateSale', $dateTest, $dateTest+86400])->all();

        $salesCount = count($sales);
        $productsKeys = array();

        for ($j = 0; $j < $salesCount; $j++)
        {
            

                $productsIds = $sales[$j]['products'];
                $products = explode(',', $productsIds);
                //unset($products[array_key_last($products)]);
                $productsKeys[$j] = $products;
            
            

        }


        for ($i = 0; $i < count($productsKeys); $i++)
        {
            for ($k = 0; $k < count($productsKeys[$i]); $k++) {

            $product = Products::find()->where(['id' => $productsKeys[$i][$k]])->one();
            $productsName[$i][$k] = $product->name;

            }

        }
        

        return $productsName;

    }

}
