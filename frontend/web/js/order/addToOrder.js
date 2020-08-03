$(document).ready(function(){
				$(".add-to-order").click(function(){
					var id = $(this).attr("data-id");
					$.post("/order/cart/ajax?id="+id, {}, function(data){
						$("#order-count").html(data);
					});
					return false;
				});
			});