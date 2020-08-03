<?php

namespace frontend\modules\order\models;

use Yii;
use frontend\modules\product\models\Products;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string|null $products
 * @property string $quantityOrdered
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['products', 'quantityOrdered', 'created_at', 'updated_at', 'status'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['products', 'quantityOrdered'], 'string'],
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
            'quantityOrdered' => 'Quantity Ordered',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }


    public function getProductsName($sort, $status)
    {

        $orders = $this->find()->where(['status' => $status])->orderBy('updated_at '.$sort)->all();
        $productsKeys = array();

        for ($i = 0; $i < count($orders); $i++)
        {

            $products = $orders[$i]['products'];
            $productsIds = explode(',', $products);
            //unset($productsIds[array_key_last($productsIds)]);
            $productsKeys[$i] = $productsIds;

        }

        for ($j = 0; $j < count($productsKeys); $j++)
        {

            for ($k = 0; $k < count($productsKeys[$j]); $k++)
            {

                $product = Products::find()->where(['id' => $productsKeys[$j][$k]])->one();
                $productsName[$j][$k] = $product->name;

            }

        }

        return $productsName;

    }


    /* для одного
    public function getProductsName()
    {

        $productsKeys = array();

        $productsIds = explode(',', $this->products);
        unset($productsIds[array_key_last($productsIds)]);

        for ($i = 0; $i < count($productsIds); $i++)
        {

            $product = Products::find()->where(['id' => $productsIds[$i]])->one();
            $productsName[$i] = $product->name;

        }

        for ($i = 0; $i < count($orders); $i++)
        {

            $products = $orders[$i]['products'];
            $productsIds = explode(',', $products);
            unset($productsIds[array_key_last($productsIds)]);
            $productsKeys[$i] = $productsIds;

        }

        for ($j = 0; $j < count($productsKeys); $j++)
        {

            for ($k = 0; $k < count($productsKeys[$j]); $k++)
            {

                $product = Products::find()->where(['id' => $productsKeys[$j][$k]])->one();
                $productsName[$j][$k] = $product->name;

            }

        }

        return $productsName;

    }
    */


    public function createOrderFile($id)
    {

        $order = $this->find()->where(['id' => $id])->one();
        $productsInfo = array();

        $ids = explode(',', $order->products);
        //unset($ids[array_key_last($ids)]);
        /*$quantity = explode(',', $order->quantityOrdered);
        unset($quantity[array_key_last($quantity)]);
        */
        for ($i = 0; $i < count($ids); $i++)
        {

            $products = Products::find()->where(['id' => $ids[$i]])->one();
            $productsInfo[$i] = $products;

        }
        /*
        if (file_exists('C:\OSPanel\domains\ds.com\frontend\web\files\order№' . $order->id) != true)
        {
            mkdir('C:\OSPanel\domains\ds.com\frontend\web\files\order№' . $order->id);
        }

        if (!file_exists('C:\OSPanel\domains\ds.com\frontend\web\files\order№' . $order->id . '\Order.txt')) 
        {
        
        $fp = fopen('C:\OSPanel\domains\ds.com\frontend\web\files\order№' . $order->id . '\Order.txt', 'a');
        $header = 'Заказ на поставку товара №' . $order->id . "\n";
        $body = 'Наименования           Количество              Закупочная цена' . "\n";
        fwrite($fp, $header);
        
        for ($j = 0; $j < count($productsInfo); $j++)
        {

            $body .= $productsInfo[$j]['name'] . '              ' . $quantity[$j] . '               ' . $productsInfo[$j]['startPrice'] . "\n";
        
        }
        $body .= "\n" . 'Общая сумма: ' . $order->amount;
        $body .= "\n" . 'Дата создания: ' . date('Y-m-d H:i', $order->created_at);
        fwrite($fp, $body);
        fclose($fp);
        }
        */

        return $productsInfo;
    }

    public function getQuantityOrdered($id)
    {

        $order = $this->find()->where(['id' => $id])->one();
        $quantity = explode(',', $order->quantityOrdered);
        //unset($quantity[array_key_last($quantity)]);
        return $quantity;

    }

    public function approveOrder()
    {

        $productsIds = explode(',', $this->products);
        //unset($productsIds[array_key_last($productsIds)]);

        $quantity = explode(',', $this->quantityOrdered);
        //unset($quantity[array_key_last($quantity)]);

        for ($i = 0; $i < count($productsIds); $i++)
        {

            $product = Products::find()->where(['id' => $productsIds[$i]])->one();

            $product->leftovers = $product->leftovers + $quantity[$i];

            $product->save();

        }

        $this->status = 2;
        $this->updated_at = time();
        
        if ($this->save()) {

            return true;

        }

        return false;  

    }

    public function cancelOrder()
    {

        $this->status = 3;
        $this->updated_at = time();
        if ($this->save()) {

            return true;

        }

        return false;

    }
}
