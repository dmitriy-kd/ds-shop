<?php

namespace frontend\modules\product\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\modules\product\models\Products;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\product\models\forms\ProductsForm;
use yii\filters\AccessControl;

/**
 * ManageController implements the CRUD actions for Products model.
 */
class ManageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex($sort = 'DESC')
    {
        /*
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find(),
        ]);
        */
        
        $products = Products::find()->orderBy('leftovers ' . $sort)->all();

        return $this->render('index', [
            'products' => $products,
            'sort' => $sort,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsForm();

        if ($model->load(Yii::$app->request->post())) {

            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Товар добавлен');
                return $this->redirect(['/product/manage/index']);

            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $picture = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if ($_FILES["Products"]["name"]["picture"] == '') {

                $model->picture = $picture->picture;
                

                if ($model->save()) {

                    return $this->redirect(['view', 'id' => $model->id]);

                }

            }

                $model->picture = UploadedFile::getInstance($model, 'picture');
               /*
                echo '<pre>';
                var_dump($model);
                echo '</pre>';die;
                */
                 if ($model->saveImage() && $model->save()) {

                    return $this->redirect(['view', 'id' => $model->id]);

                }


            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /*
    public function actionTest()
    {
        $search = Search::searchProduct();
        $products = Products::find()->all();

        return $this->render('test', [
            'search' => $search,
            'products' => $products,
        ]);

    }
    */
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
                            <a href="/product/manage/view?id='.$product['id'].'" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp;&nbsp;
                            <a href="/product/manage/update?id='.$product['id'].'" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;&nbsp;
                            <a href="/product/manage/delete?id='.$product['id'].'" title="Delete" aria-label="Delete" data-pjax="0" data-confirm="Вы уверены что хотите удалить данный товар?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>';

                }

                $output .= '</tbody>';

                echo $output;die;
            }
            else
            {
                echo 'Нет результатов';die;
            }

    }
}
