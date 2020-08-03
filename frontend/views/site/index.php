<?php

use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'DS shop';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Shop</h1>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Заказы</h2>

                <p>Создание и управление заявками на заказ поставки товара.</p>

                <p><a class="btn btn-default" href="<?php echo Url::to(['/order/manage/index']); ?>">Открыть панель заказов &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Товары</h2>

                <p>Добавление, удаление и редактирование товаров. Проверка остатков.</p>

                <p><a class="btn btn-default" href="<?php echo Url::to(['/product/manage/index']); ?>">Открыть панель товаров &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Продажи</h2>

                <p>Просмотр списка продаж.</p>

                <p><a class="btn btn-default" href="<?php echo Url::to(['/sale/manage/index']); ?>">Открыть панель продаж &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
