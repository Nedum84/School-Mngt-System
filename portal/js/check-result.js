(function() {
	$(document).ready(function() {

		$(document).on('click','#check_result',function() {
			var st_class=$('#st_class').val().trim();
			var st_term=$('#st_term').val().trim();
			var st_session=$('#st_session').val().trim();
			var st_pin=$('#st_pin').val().trim();
			$.post('ajax/st-process.php',
				{st_class:st_class,st_term:st_term,st_session:st_session,st_pin:st_pin},
				function(data) {
					if (data=="ok") {
						window.location.href="view-result?st_class="
						+st_class+"&st_session="+st_session+"&st_term="+st_term+"&st_pin="+st_pin;
					}else{
						$('#error_feed').fadeIn(150).text(data).delay(5000).fadeOut(50);
					}
				});
		});

		var session="<option value='none'>Select Session </option>"
		for (var i = 2017; i <2050; i++) {
			session+='<option value="'+i+'/'+(i+1)+'">'+i+'/'+(i+1)+'</option>';
		}
		$('.session_drop').html(session);

		function _(x){
			return document.getElementById(x);
		}
	});
})();