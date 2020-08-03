<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JqueryAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p style="display:inline-block;">
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
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
                            <a href="/product/manage/view?id=<?php echo $product->id; ?>" title="Просмотр" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp;&nbsp;
                            <a href="/product/manage/update?id=<?php echo $product->id; ?>" title="Изменить" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;&nbsp;
                            <a href="/product/manage/delete?id=<?php echo $product->id; ?>" title="Удалить" aria-label="Delete" data-pjax="0" data-confirm="Вы уверены что хотите удалить данный товар?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
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
?>