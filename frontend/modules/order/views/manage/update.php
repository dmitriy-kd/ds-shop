<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\order\models\Orders */

$this->title = 'Изменить информацию о заказе: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    	<?php echo $form->field($model, 'products')->label('Список товаров'); ?>
    	<?php echo $form->field($model, 'quantityOrdered')->label('Заказанное количество'); ?>
    	<?php echo $form->field($model, 'amount')->label('Сумма заказа'); ?>
    	<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>

</div>
