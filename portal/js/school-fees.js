(function() {
	$(document).ready(function() {

		//Generate school invoice
		var feedBack = $('#error_feed');
		  var school_fees_gen = $("#school_fees_gen")[0];
		  school_fees_gen.addEventListener('submit', function(e) {

		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", "ajax/school-fees-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText=="ok") {
		      		feedBack.fadeIn(150).text(data).delay(5000).fadeOut(50);	
		      		window.location.href="school-fees-invoice?INVOICE="
						+val;
		      	}else{
		      		feedBack.fadeIn(150).text(ajax.responseText).delay(5000).fadeOut(50);
		      	}	        
		      } else {
		      	feedBack.fadeIn(150).text("Error " + ajax.status + " occurred when trying to contact the server.<br \/>").delay(5000).fadeOut(50);
		      }
		    };
		    ajax.send(new FormData(school_fees_gen));

		    e.preventDefault();return false;
		  },false);
	});
})();