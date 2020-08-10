<?php

namespace frontend\modules\sale\controllers;

use Yii;
use frontend\modules\sale\models\Sales;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\product\models\Products;
use frontend\modules\sale\models\forms\DateForm;

/**
 * ManageController implements the CRUD actions for Sales model.
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
     * Lists all Sales models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dateTest = time();

        if (Yii::$app->request->post()) {

            $dateTest = strtotime($_POST['dateTest']);

        }

        $productsName = new Sales();
        $productsName = $productsName->getProductName($dateTest);

        $sales = Sales::find()->where(['between', 'dateSale', $dateTest, $dateTest+86400])->all();

        return $this->render('index', [
            'productsName' => $productsName,
            'sales' => $sales,
            
        ]);
    }

    /**
     * Displays a single Sales model.
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
     * Creates a new Sales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $products = Products::find()->all();

        $model = new Sales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Updates an existing Sales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sales model.
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

    /**
     * Finds the Sales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sales::findOne($id)) !== null) {
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
                            &nbsp;&nbsp;<a href="#" data-id="'.$product['id'].'" class="add-to-cart" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-plus"></span></a>&nbsp;&nbsp;
                        </td>
                    </tr>';

                }

                $output .= '</tbody>
                <script>
                $(document).ready(function(){
                $(".add-to-cart").click(function(){
                    var id = $(this).attr("data-id");
                    $.post("/sale/cart/ajax?id="+id, {}, function(data){
                        $("#cart-count").html(data);
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
