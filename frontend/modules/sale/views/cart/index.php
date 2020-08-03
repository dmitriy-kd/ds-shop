<?php 
	use yii\helpers\Url;
	use yii\helpers\Html;
	$amount = 0;
 ?>
						<div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
						
                            <h2 class="title text-center">Корзина</h2>
							<?php if($_SESSION['productInfo0']): ?>
							<p>Вы выбрали следующие товары:</p>
							<table class="table-bordered table-striped table">
								<tr>
									<th>ID</th>
									<th>Наименование</th>
									<th>Закупочная стоимость</th>
									<th>Розничная стоимость</th>
									<th>Количество</th>
									<th>Штрихкод</th>
									<th>Удаление</th>
								</tr>

								<?php for ($i = 0; $i <= $lastKey; $i++): ?>

								<tr>
									<td><?php echo $_SESSION['productInfo'.$i]['id']; ?></td>
									<td><a href="<?php echo Url::to(['/product/manage/view', 'id' => $_SESSION['productInfo'.$i]['id']]) ?>"><?php echo $_SESSION['productInfo'.$i]['name']; ?></a></td>
									<td><?php echo $_SESSION['productInfo'.$i]['startPrice']; ?></td>
									<td><?php echo $_SESSION['productInfo'.$i]['finishPrice']; ?></td>
									<td><?php echo $quantity[$_SESSION['productInfo'.$i]['id']]; ?></td>
									<td><?php echo $_SESSION['productInfo'.$i]['barcode']; ?></td>
									<td><a href="<?php echo Url::to(['/sale/cart/delete', 'id' => $_SESSION['productInfo'.$i]['id'], 'i' => $i]); ?>">Удалить товар из корзины</a></td>
									<?php $amount += $_SESSION['productInfo'.$i]['finishPrice'] * $quantity[$_SESSION['productInfo'.$i]['id']];?>
								</tr>

								<?php endfor; ?>

								<tr>
									<td colspan="3">Общая стоимость:</td>
									<td><?php echo $amount; ?></td>
								</tr>
							</table>
							<?php else: ?>
								<p>Корзина пуста</p>
							<?php endif; ?>
                        </div><!--features_items-->
                        <?php echo Html::a('Назад', ['/sale/manage/create'], ['class' => 'btn btn-default']); ?>

						<?php echo Html::a('Провести продажу', ['/sale/cart/checkout'], ['class' => 'btn btn-primary']); ?>
						

                    </div>