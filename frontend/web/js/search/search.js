$(document).ready(function(){
	$('#search-text').keyup(function(){
		var txt = $(this).val();
		if (txt != '')
		{
			$.ajax({
				url:"fetch",
				method:"post",
				data:{search:txt},
				dataType:"text",
				success:function(data)
				{
					$('.table').hide();
					$('.table-search').html(data);
				}
			});
		}
		else 
		{
			$('.table-search').html('');
			
		}
	});
});