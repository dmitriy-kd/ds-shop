<?php

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\helpers\Url;
use frontend\modules\order\models\Cart;

/* @var $this yii\web\View */
/* @var $model frontend\modules\order\models\Orders */

$this->title = 'Создать заказ';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <p style="display:inline-block;">
        <a href="/order/cart/index" class="btn btn-success">Список&nbsp;<span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;(<span id="order-count"><?php echo Cart::countItems(); ?></span>)</a>    
    </p>
    <p style="display:inline-block;">
        <?= Html::a('Товары с нулевым остатком', ['leftovers-zero'], ['class' => 'btn btn-default']) ?>
    </p>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Поиск по наименованию и штрихкоду:</span>
            <input type="text" name="search-text" id="search-text" class="form-control">
        </div>
    </div>

    <div>
        <table class="table table-striped table-bordered">
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
            <tbody class="search-result">
                <?php foreach($products as $product): ?>
                    <tr data-key="<?php echo $product->id; ?>">
                        <td><?php echo $product->id; ?></td>
                        <td><a href="/product/manage/view?id=<?php echo $product->id; ?>"><?php echo $product->id; ?></a></td>
                        <td><?php echo $product->name; ?></td>
                        <td><img src="/uploads/<?php echo $product->picture; ?>" width="130px" alt=""></td>
                        <td><?php echo $product->startPrice; ?></td>
                        <td><?php echo $product->finishPrice; ?></td>
                        <td><?php echo $product->leftovers; ?></td>
                        <td><?php echo $product->barcode; ?></td>
                        <td>
                            &nbsp;&nbsp;<a href="#" data-id="<?php echo $product->id; ?>" class="add-to-order" title="Добавить в заказ" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-plus"></span></a>&nbsp;&nbsp;
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table-search">
        
        </table>
    </div>

    

</div>
<?php $this->registerJsFile('@web/js/search/search.js', [
        'depends' => JqueryAsset::className()
    ]);
    $this->registerJsFile('@web/js/order/addToOrder.js', [
    	'depends' => JqueryAsset::className()
    ]); 
?>

</div>
