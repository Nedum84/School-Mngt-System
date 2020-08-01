(function() {
	$(document).ready(function () {
		$(document).ajaxStart(function () {
			//$('#loader').show(); show_opacity();
		}).ajaxStop(function () {
			$('#add_result').removeAttr('disabled').removeClass('addBtnOpacity').html('<i class="fa fa-upload"></i> Upload Result');
		});
		//result curriculum toogle
		$('.contents .curriculum_result_wrapper .cur_res_div button.upload_res').addClass('uploadSelected');
		$('.contents .curriculum_result_wrapper .cur_res_div button').on('click',function() {

			$('.contents .curriculum_result_wrapper .cur_res_div button').removeClass('uploadSelected');
			var current_Class=$(this).attr('class');
			$(this).addClass('uploadSelected');

			var current_Show=$(this).attr('data-show');
			$('.contents .curriculum_result_wrapper .res_cur>div').css('display','none');
			$('.contents .curriculum_result_wrapper .res_cur div.'+current_Show).css('display','block');

		});
		//checking path selections bw admin and portal
		if (window.location.href.indexOf('admin')!=-1) {
			var portalVal='../portal/';
			var appendVal=2;
			var editResPath='teachers-edit-results?';
		}else{
			var portalVal='';
			var appendVal='';
			var editResPath='edit-results?';
		}

		//curriculum submit
		  var form = _("add_curriculum_form");
		  form.addEventListener('submit', function(e) {

		    var feed = _("curriculum_error");
		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", portalVal+"ajax/upload-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText=="ok") {
		      		curFeedBack();
		      		feed.innerHTML = "Curriculum uploaded.";
		      		$('#add_curriculum_form')[0].reset();
		      	}else{
		      		feed.innerHTML = ajax.responseText;
		      	}		        
		      } else {feed.innerHTML = "Error " + ajax.status + " occurred when trying to upload your file.<br \/>";}
		    };
		    ajax.send(new FormData(form));
		    e.preventDefault();return false;
		  },false);

		  curFeedBack();
		//curriculum feedback
		function curFeedBack() {
			var curFeed='cur'+appendVal;$.post(portalVal+'ajax/misc.php',{curFeed:curFeed},function(data) {$('#show_c_uploaded').html(data);})
		}//curriculum view
		$(document).on('click','.c_view,.c_view.st',function() {
			var curViewPath=$(this).attr('data-viewPath');
			var type=$(this).attr('data-type');
			window.location.href=portalVal+"feed_back?curViewPath="+curViewPath+"&type="+type;
		});
		$(document).on('click','.c_download,.c_download.st',function() {
			var curViewPath=$(this).attr('data-viewPath');
			var type=$(this).attr('data-type');
			window.location.href=portalVal+"feed_back?curViewPath="+curViewPath+"&type="+type;
		});
		$(document).on('click','.c_delete',function() {
			var deleteId=$(this).attr('data-deleteId');
			if (confirm("Delete Curriculum?")) {
				$.post(portalVal+'ajax/misc.php',{deleteId:deleteId},function(data) {
					if (data=='ok') {
						alert("Curriculum deleted.");
						curFeedBack();
					}
				});
			}
		});

		//subject selection
		var subject=2;
		$.post(portalVal+'ajax/misc.php',{subject:subject},function(data) {$('.subject_drop').html(data);})
		//file extension
		var input_cur=_('upload_cur_input');
		var input_result=_('upload_res_input');
		input_cur.onchange=function() {
		  	var array_check=['pdf','docx','doc'];
		  	var ext_array=input_cur.value.split('.');
		  	ext=ext_array[(ext_array.length)-1];
		  	if ((ext=="pdf")||(ext=="doc")||(ext=='docx')) {
		  		_('file_error').innerHTML="Curriculum selected.";
		  	}else{
		  		_('file_error').innerHTML="Invalid file formate. Upload pdf of docx file.";
		  	}
		  }
		  		  //Result turn
		var form_result = _("add_result_form");
		form_result.addEventListener('submit', function(e) {
			$('#add_result').html('Uploading <i class="fa fa-spinner"></i>').addClass('addBtnOpacity').attr('disabled','disabled');
		    var feed_r = _("result_error");
		    var input_subject=$('#input_subject option:selected').text().toLowerCase();
		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", portalVal+"ajax/upload-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText.indexOf('Result of')!=-1) {
		      		resFeedBack();
		      		feed_r.innerHTML = ajax.responseText;
		      		$('#add_result_form')[0].reset();
		  			_('res_file_error').innerHTML="";
		      		$('#add_result').removeAttr('disabled').removeClass('addBtnOpacity').html('<i class="fa fa-upload"></i> Upload Result');
		      	}else{
		      		feed_r.innerHTML = ajax.responseText;
		      		$('#add_result').removeAttr('disabled').removeClass('addBtnOpacity').html('<i class="fa fa-upload"></i> Upload Result');
		      	}		        
		      } else {feed_r.innerHTML = "Error " + ajax.status + " occurred when trying to upload your file.<br \/>";}
		    };
		    var data=new FormData(form_result);
		    data.append('input_subject',input_subject)
		    ajax.send(data);
		    e.preventDefault();return false;
		  },false);

		//result feedback
		resFeedBack();
		function resFeedBack() {
			var resFeed='res'+appendVal;$.post(portalVal+'ajax/misc.php',{resFeed:resFeed},function(data) {$('.show_r_uploaded').html(data);})
		}
		//result edit
		$(document).on('click','.r_edit',function() {
			var teachers_id=$(this).attr('data-teachers_id');
			var class_id=$(this).attr('data-class_id');
			var session_id=$(this).attr('data-session_id');
			var term_id=$(this).attr('data-term_id');
			var subject_id=$(this).attr('data-subject_id');
			// alert(subject_id);
			window.location.href=editResPath+"teachers_id="+teachers_id+"&class_id="+class_id
			+"&session_id="+session_id+"&term_id="+term_id+"&subject_id="+subject_id;
		});


		input_result.onchange=function() {
		  	var ext_array=input_result.value.split('.');
		  	ext=ext_array[(ext_array.length)-1];
		  	if (ext=='csv') {
		  		_('res_file_error').innerHTML="Result selected.";
		  	}else{
		  		_('res_file_error').innerHTML="Invalid file formate. Upload .csv result file.";
		  	}
		  }
		//Assignmjent starts
		  var form_assign = _("add_assignment_form");
		  form_assign.addEventListener('submit', function(e) {

		    var feed = _("assignment_error");
		    var ajax = new XMLHttpRequest();
		    ajax.open("POST", portalVal+"ajax/upload-process.php", true);
		    ajax.onload = function(event) {
		      if (ajax.status == 200 && ajax.readyState == 4) {
		      	if (ajax.responseText=="ok") {
		      		assFeedBack();
		      		feed.innerHTML = "Assignment uploaded.";
		      		$('#add_assignment_form')[0].reset();
		      	}else{
		      		feed.innerHTML = ajax.responseText;
		      	}		        
		      } else {feed.innerHTML = "Error " + ajax.status + " occurred when trying to upload your file.<br \/>";}
		    };
		    ajax.send(new FormData(form_assign));
		    e.preventDefault();return false;
		  },false);

		  assFeedBack();
		//assignment feedback
		function assFeedBack() {
			var assFeed='ass'+appendVal;$.post(portalVal+'ajax/misc.php',{assFeed:assFeed},function(data) {$('#show_ass_uploaded').html(data);})
		}//assignment view
		$(document).on('click','.ass_view',function() {
			var assViewPath=$(this).attr('data-viewPath');
			var type=$(this).attr('data-type');
			window.location.href=portalVal+"feed_back?assViewPath="+assViewPath+"&ass_type="+type;
		});
		$(document).on('click','.ass_download',function() {
			var assViewPath=$(this).attr('data-viewPath');
			var type=$(this).attr('data-type');
			window.location.href=portalVal+"feed_back?assViewPath="+assViewPath+"&ass_type="+type;
		});
		$(document).on('click','.ass_delete',function() {
			var deleteAssId=$(this).attr('data-ass_delete_id');
			if (confirm("Delete this assignment?")) {
				$.post(portalVal+'ajax/misc.php',{deleteAssId:deleteAssId},function(data) {
					if (data=='ok') {
						alert("assignment deleted.");
						assFeedBack();
					}else{
						$('#error_feed').fadeIn(100).text(data).delay(5000).fadeOut(50);
					}
				});
			}
		});//ass ends
		//assignment file selection
		var input_ass=_('upload_ass_input');
		input_ass.onchange=function() {
		  	var array_check=['pdf','docx','doc'];
		  	var ext_array=input_ass.value.split('.');
		  	ext=ext_array[(ext_array.length)-1];
		  	if ((ext=="pdf")||(ext=="doc")||(ext=='docx')) {
		  		_('ass_file_error').innerHTML="Assignment selected.";
		  	}else{
		  		_('ass_file_error').innerHTML="Invalid file formate. Upload pdf of docx file.";
		  	}
		  }

		//session selection
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