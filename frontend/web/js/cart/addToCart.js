$(document).ready(function(){
				$(".add-to-cart").click(function(){
					var id = $(this).attr("data-id");
					$.post("/sale/cart/ajax?id="+id, {}, function(data){
						$("#cart-count").html(data);
					});
					return false;
				});
			});