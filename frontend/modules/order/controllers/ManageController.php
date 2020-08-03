<?php

namespace frontend\modules\order\controllers;

use Yii;
use frontend\modules\order\models\Orders;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\product\models\Products;
use kartik\mpdf\Pdf;

/**
 * ManageController implements the CRUD actions for Orders model.
 */
class ManageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex($sort = 'DESC', $status = 0)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find(),
        ]);
        
        $_SESSION['statusOrder'] = $status;

        $productsName = new Orders();

        $productsName = $productsName->getProductsName($sort, $status);
        
        $orders = Orders::find()->where(['status' => $_SESSION['statusOrder']])->orderBy('updated_at '.$sort)->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'productsName' => $productsName,
            'orders' => $orders,
            'sort' => $sort,
            //'status' => $status,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        $products = Products::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->updated_at = time();

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Заказ изменён');
                return $this->redirect(['view', 'id' => $model->id]);
            }

            Yii::$app->session->setFlash('fail', 'Произошла ошибка');
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionOrderFile($id)
    {

        $order = new Orders();

        $orderFile = $order->createOrderFile($id);
        $quantity = $order->getQuantityOrdered($id);

        $order = $order->find()->where(['id' => $id])->one();
        

        $content = $this->renderPartial('_reportView', [
            'orderFile' => $orderFile,
            'quantity' => $quantity,
            'order' => $order,
        ]);

        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'mode' => 'utf-8',
        //выставляем кодировку
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Order №' . $id],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['ЗАКАЗ №' . $id], 
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);

        return $pdf->render(); 

    }

    public function actionSendFile($id)
    {
        $order = new Orders();

        $orderFile = $order->createOrderFile($id);
        $quantity = $order->getQuantityOrdered($id);

        $order = $order->find()->where(['id' => $id])->one();

        $result = Yii::$app->mailer->compose()
                ->setFrom('test.php.up123@gmail.com')
                ->setTo(Yii::$app->params['productsProviderEmail'])
                ->setSubject('Заказ на поставку товара ИП Ким Д.Д. номер заявки '.$id)
                ->setTextBody('Добрый день!')
                ->setHtmlBody($this->renderPartial('_reportView', [
                    'orderFile' => $orderFile,
                    'quantity' => $quantity,
                    'order' => $order,
                ]))
                ->send();
            if ($result) {
                $order->updated_at = time();
                $order->status = 1;
                $order->save();

                Yii::$app->session->setFlash('success', 'Заявка отправлена поставщику');
            } else {

                Yii::$app->session->setFlash('fail', 'Произошла ошибка при отправке письма');

            }

            return $this->redirect('/order/manage/index');

    }


    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionApprove($id)
    {

        $order = Orders::find()->where(['id' => $id])->one();

        if ($order->approveOrder()) {

            Yii::$app->session->setFlash('success', 'Заказ получен');

        } else {

            Yii::$app->session->setFlash('fail', 'Произошла ошибка');

        }

        return $this->redirect('/order/manage/index');

    }

    public function actionCancel($id)
    {

        $order = Orders::find()->where(['id' => $id])->one();

        if ($order->cancelOrder()) {

            Yii::$app->session->setFlash('success', 'Заказ отменен');

        } else {

            Yii::$app->session->setFlash('fail', 'Произошла ошибка');

        }

        return $this->redirect('/order/manage/index');

    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFetch()
    {

        $connect = mysqli_connect("localhost", "root", "", "dsdb");
        $output = '';
        $sql = "SELECT * FROM products WHERE name LIKE '%".$_POST["search"]."%' OR barcode LIKE '%".$_POST["search"]."%'";  //
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0)
        {

            $output .= '
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><a href="/product/manage/index?sort=id" data-sort="id">ID</a></th>
                                <th><a href="/product/manage/index?sort=name" data-sort="name">Наименование</a></th>
                                <th><a href="/product/manage/index?sort=picture" data-sort="picture">Картинка</a></th>
                                <th><a href="/product/manage/index?sort=startPrice" data-sort="startPrice">Закупочная цена</a></th>
                                <th><a href="/product/manage/index?sort=finishPrice" data-sort="finishPrice">Розничная цена</a></th>
                                <th><a href="/product/manage/index?sort=leftovers" data-sort="leftovers">Остаток</a></th>
                                <th><a href="/product/manage/index?sort=barcode" data-sort="barcode">Штрихкод</a></th>
                                <th class="action-column">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody class="search-result">';

                while ($product = mysqli_fetch_array($result))
                {

                    $output .= '<tr data-key="'.$product['id'].'">
                        <td>'.$product['id'].'</td>
                        <td><a href="/product/manage/view?id='.$product['id'].'">'.$product['id'].'</a></td>
                        <td>'.$product['name'].'</td>
                        <td><img src="/uploads/'.$product['picture'].'" width="130px" alt=""></td>
                        <td>'.$product['startPrice'].'</td>
                        <td>'.$product['finishPrice'].'</td>
                        <td>'.$product['leftovers'].'</td>
                        <td>'.$product['barcode'].'</td>
                        <td>
                            &nbsp;&nbsp;<a href="#" data-id="'.$product['id'].'" class="add-to-order" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-plus"></span></a>&nbsp;&nbsp;
                        </td>
                    </tr>';

                }

                $output .= '</tbody>
                <script>
                $(document).ready(function(){
                $(".add-to-order").click(function(){
                    var id = $(this).attr("data-id");
                    $.post("/order/cart/ajax?id="+id, {}, function(data){
                        $("#order-count").html(data);
                    });
                    return false;
                    });
                    });
                </script>
                ';

                echo $output;die;
            }
            else
            {
                echo 'Нет результатов';die;
            }

    }
}
