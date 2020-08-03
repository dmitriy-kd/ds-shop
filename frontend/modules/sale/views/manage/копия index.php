<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продажи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оформить продажу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<div>
    <table class="table table-bordered">
        <tr>
            <td>№</td>
            <td>ID</td>
            <td>Наименования</td>
            <td>Количества</td>
            <td>Цена за шт</td>
            <td>Сумма чека</td>
            <td>Дата продажи&nbsp;<a href="<?php echo Url::to(['/sale/manage/index', 'sort' => ($sort == "DESC") ? "ASC" : "DESC"]);?>"><span class="glyphicon glyphicon-sort"></span></a></td>         
        </tr>
        <?php for ($i = 0; $i < count($productsName); $i++): ?>
        <tr>
            <td>#</td>
            <td><?php echo $sales[$i]['id']; ?></td>
            <td>
                <?php 
                    $names = '';
                    for ($k = 0; $k < count($productsName[$i]); $k++) {
                        $names .= $productsName[$i][$k];
                        $names .= ',';
                    }
                    echo $names;
                ?>        
            </td>
            <td><?php echo $sales[$i]['quantityProducts']; ?></td>
            <td><?php echo $sales[$i]['priceProducts']; ?></td>
            <td><?php echo $sales[$i]['amount']; ?></td>
            <td><?php echo date('d-m-Y H:i', $sales[$i]['dateSale']); ?></td>
        </tr>
        <?php endfor; ?>
    </table>
</div>

</div>
