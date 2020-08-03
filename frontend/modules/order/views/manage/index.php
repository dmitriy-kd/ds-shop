<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать заявку на заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style="margin-bottom:10px;">
        <a href="<?php echo Url::to(['/order/manage/index', 'status' => 0]);?>" class="<?php echo ($_SESSION['statusOrder'] == 0) ? "active" : "";?> btn btn-default">Не отправленные</a>
        <a href="<?php echo Url::to(['/order/manage/index', 'status' => 1]);?>" class="<?php echo ($_SESSION['statusOrder'] == 1) ? "active" : "";?> btn btn-default">Отправленные</a>
        <a href="<?php echo Url::to(['/order/manage/index', 'status' => 2]);?>" class="<?php echo ($_SESSION['statusOrder'] == 2) ? "active" : "";?> btn btn-default">Полученные</a>
        <a href="<?php echo Url::to(['/order/manage/index', 'status' => 3]);?>" class="<?php echo ($_SESSION['statusOrder'] == 3) ? "active" : "";?> btn btn-default">Отмененные</a>
    </div>
    <div class="col">
    <table class="table table-bordered">
        <tr>
            <td>№</td>
            <td>ID</td>
            <td>Наименования</td>
            <td>Заказанные количества</td>
            <td>Заказ создан</td>
            <td>Заказ обновлен&nbsp;<a href="<?php echo Url::to(['/order/manage/index', 'status' => $_SESSION['statusOrder'], 'sort' => ($sort == "DESC") ? "ASC" : "DESC"]);?>"><span class="glyphicon glyphicon-sort"></span></a></td>
            <td>Сумма заказа</td>
            <td>Статус заказа</td>
            <td>Действия</td>         
        </tr>
        <?php for ($i = 0; $i < count($productsName); $i++): ?>
        <tr>
            
            <td>#</td>
            <td><?php echo $orders[$i]['id']; ?></td>
            <td>
                <?php 
                    $names = '';
                    for ($k = 0; $k < count($productsName[$i]); $k++) {
                        $names .= $productsName[$i][$k];
                        $names .= ',';
                    }
                    echo substr($names, 0, strlen($names) - 1);
                ?>        
            </td>
            <td><?php echo $orders[$i]['quantityOrdered']; ?></td>
            <td><?php echo date('d-m-Y H:i', $orders[$i]['created_at']); ?></td>
            <td><?php echo date('d-m-Y H:i', $orders[$i]['updated_at']); ?></td>
            <td><?php echo $orders[$i]['amount']; ?></td>
            <td><?php  
            
                switch($orders[$i]['status'])
                {

                    case 0:
                        echo 'Заказ не обработан';
                        break;
                    case 1:
                        echo 'Заявка заказа отправлена';
                        break;
                    case 2:
                        echo 'Заказ получен';
                        break;
                    case 3:
                        echo 'Заказ отменен';
                        break;

                } 
            
            ?></td>
            <td>
                <a href="/order/manage/view?id=<?php echo $orders[$i]['id']; ?>" title="Просмотр" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp;&nbsp;
                <a href="/order/manage/update?id=<?php echo $orders[$i]['id']; ?>" title="Изменить" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;&nbsp;
                <a href="/order/manage/order-file?id=<?php echo $orders[$i]['id']; ?>" title="Выгрузить файл" aria-label="Upload" data-pjax="0"><span class="glyphicon glyphicon-circle-arrow-down"></span></a>&nbsp;&nbsp;&nbsp;
                <a href="/order/manage/send-file?id=<?php echo $orders[$i]['id']; ?>" title="Отправить письмом" aria-label="Send" data-pjax="0"><span class="glyphicon glyphicon-envelope"></span></a>&nbsp;&nbsp;&nbsp;
                <br>
                <a href="/order/manage/approve?id=<?php echo $orders[$i]['id']; ?>" title="Провести поставку" aria-label="Approve" data-pjax="0"><span class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;&nbsp;
                <a href="/order/manage/cancel?id=<?php echo $orders[$i]['id']; ?>" title="Отменить заказ" aria-label="Cancel" data-pjax="0"><span class="glyphicon glyphicon-remove"></span></a>&nbsp;&nbsp;&nbsp;
                <a href="/order/manage/delete?id=<?php echo $orders[$i]['id']; ?>" title="Удалить" aria-label="Delete" data-pjax="0" data-confirm="Вы уверены что хотите удалить данный заказ?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
            </td>

        </tr>
        <?php endfor; ?>
    </table>
</div>

</div>