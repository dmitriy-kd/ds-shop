<?php 
	use yii\helpers\Url;
	use yii\helpers\Html;
	$amount = 0;
 ?>

						<div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
						
                            <h2 class="title text-center">Список</h2>
							<?php if($_SESSION['orderInfo0']): ?>
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
									<td><?php echo $_SESSION['orderInfo'.$i]['id']; ?></td>
									<td><a href="<?php echo Url::to(['/product/manage/view', 'id' => $_SESSION['orderInfo'.$i]['id']]) ?>"><?php echo $_SESSION['orderInfo'.$i]['name']; ?></a></td>
									<td><?php echo $_SESSION['orderInfo'.$i]['startPrice']; ?></td>
									<td><?php echo $_SESSION['orderInfo'.$i]['finishPrice']; ?></td>
									<td><?php echo $quantity[$_SESSION['orderInfo'.$i]['id']]; ?></td>
									<td><?php echo $_SESSION['orderInfo'.$i]['barcode']; ?></td>
									<td><a href="<?php echo Url::to(['/order/cart/delete', 'id' => $_SESSION['orderInfo'.$i]['id'], 'i' => $i]); ?>">Удалить товар из корзины</a></td>
									<?php $amount += $_SESSION['orderInfo'.$i]['startPrice'] * $quantity[$_SESSION['orderInfo'.$i]['id']];?>
								</tr>

								<?php endfor; ?>

								<tr>
									<td colspan="3">Сумма заявки:</td>
									<td><?php echo $amount; ?></td>
								</tr>
							</table>
							<?php else: ?>
								<p>Список пуст</p>
							<?php endif; ?>
                        </div><!--features_items-->
                        <?php echo Html::a('Назад', ['/order/manage/create'], ['class' => 'btn btn-default']); ?>

						<?php echo Html::a('Оформить заказ', ['/order/cart/checkout'], ['class' => 'btn btn-primary']); ?>
						

                    </div>