<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

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
	
    <div style="margin-bottom:10px;">
    	<p>
    		Выберите дату продажи:
    	</p>

    	<form id="w0" action="/sale/manage/index" method="post">
			<input type="hidden" name="_csrf-frontend" value="f0gERmRvxgQy602uXd2P23hRlStV2aBGfd3Vvx3EdkcFJ3QeCRyedXGPFfcyrbnrOSbxZD6W12tLq4L1ZYIwEQ==">

			<input type="date" id="dateform-datetest" class="form-control" name="dateTest">

			<button type="submit" class="btn btn-primary" style="margin-top:10px">Выбрать</button>
    	</form>

    </div>
	

<div>
    <table class="table table-bordered">
        <tr>
            <td>№</td>
            <td>ID</td>
            <td>Наименования</td>
            <td>Количества</td>
            <td>Цена за шт</td>
            <td>Сумма чека</td>
            <td>Дата продажи</td>         
        </tr>
        <?php if ($productsName): ?>
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
                    echo substr($names, 0, strlen($names) - 1);
                ?>        
            </td>
            <td><?php echo $sales[$i]['quantityProducts']; ?></td>
            <td><?php echo $sales[$i]['priceProducts']; ?></td>
            <td><?php echo $sales[$i]['amount']; ?></td>
            <td><?php echo date('d-m-Y H:i', $sales[$i]['dateSale']); ?></td>
        </tr>
        <?php endfor; ?>
    	<?php endif; ?>
    </table>
</div>

</div>
