
<table class="table table-bordered">
	<tr class="table-headers">
		<td>Наименование</td>
		<td>Количество</td>
		<td>Закупочная цена</td>
	</tr>
	<?php for ($j = 0; $j < count($orderFile); $j++): ?>
	<tr class="table-items">
		<td><?php echo $orderFile[$j]['name']; ?></td>
		<td><?php echo $quantity[$j]; ?></td>
		<td><?php echo $orderFile[$j]['startPrice']; ?></td>
	</tr>
	<?php endfor; ?>
</table>
<h4>Общая сумма: <?php echo $order->amount; ?></h4>
<p style="font-size:16px;">Дата создания заказа: <?php echo date('Y-m-d | H:i', $order->created_at); ?></p>