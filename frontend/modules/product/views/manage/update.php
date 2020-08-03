<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\product\models\Products */

$this->title = 'Изменить информацию о продукте: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php $form = ActiveForm::begin(); ?>

   		<?php echo $form->field($model, 'name')->label('Наименование'); ?>

   		<?php echo $form->field($model, 'startPrice')->label('Закупочная цена'); ?>
   		
   		<?php echo $form->field($model, 'finishPrice')->label('Розничная цена'); ?>
   		
   		<?php echo $form->field($model, 'picture')->fileInput()->label('Картинка'); ?>

   		<?php echo $form->field($model, 'leftovers')->label('Остаток'); ?>

   		<?php echo $form->field($model, 'barcode')->label('Штрихкод'); ?>

   		<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>

   	<?php ActiveForm::end(); ?>

</div>
