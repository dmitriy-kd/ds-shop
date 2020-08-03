
	$('input[type=radio][name=orderStatus').change(function () {

		switch (this.value) {

			case '0':
				$.post("/order/manage/index?status="+0, {}, function(data) {
					$('.table').html(data);
				});
				break;
			case '1':
				alert('Отправленные');
				break;
			case '2':
				$.post("/order/manage/index?status="+2);
				break;
			case '3':
				$.post("/order/manage/index?status="+3, {}, function(data) {
					$('.orders-index').html(data);
				});
				break;
		}

	});
