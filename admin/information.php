 <?php
include("inc/header.inc.php");

?>
<title>Send Information</title>
  <div class="left_divs">
    <?php include 'inc/left_menu.inc.php'; ?>
  </div><!-- 
  --><div class="contents">
	<div id="welcome" class="home_welcome">
			<h4>Notifications Center!</h4>
	</div>
    <center class="white_background">
    	<div class="button_dolder">
          <button class="btnEffects" id="addNews" onclick="window.location.href='add-info' ">
            <div class="btnIcon_info"><i class="fa fa-file-audio-o"></i></div><div class="btnDetail_info">
              <h4>Add News</h4>
              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
              <span class="progress-description">Number of uploaded E-Books</span>
            </div>
          </button>
          <button class="btnEffects" id="notify_teachers">
            <div class="btnIcon_info"><i class="fa fa-file-movie-o"></i></div><div class="btnDetail_info">
              <h4>Notify Teachers</h4>
              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
              <span class="progress-description">Number of uploaded E-Books</span>
            </div>
          </button>
          <button class="btnEffects" id="notify_students">
            <div class="btnIcon_info"><i class="fa fa-hdd-o"></i></div><div class="btnDetail_info">
              <h4>Notify Students</h4>
              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
              <span class="progress-description">Number of uploaded E-Books</span>
            </div>
          </button>
          <button class="btnEffects" id="sent_notifications">
            <div class="btnIcon_info"><i class="fa fa-folder-open"></i></div><div class="btnDetail_info">
              <h4>Sent Notifications</h4>
              <div class="progress_div"><div class="progress-bar" style="width: 70%"></div></div>
              <span class="progress-description">Number of uploaded E-Books</span>
            </div>             
          </button>
   		
    	</div>
      <div class="news_cols_wrapper">
      	

      </div>
    </center>
  </div>
  

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
  bkLib.onDomLoaded(function() {
    // nicEditors.allTextAreas();
    // new nicEditor({fullPanel : true}).panelInstance('notify_student_textarea');
    // new nicEditor({fullPanel : true}).panelInstance('notify_teachers_textarea');
  });
</script>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {

      $(document).on('click','#notify_teachers',function() {
        $('.modal_wrapper').css({'display':'block'});
        $('#notify_t_form').show(500);
      });

	  $('#notify_t_form').on('submit',function(e) {
      e.preventDefault();
	  	var notify_teachers_textarea=$('#notify_teachers_textarea').val().trim();
	  	$.post('ajax/news.php',{notify_teachers_textarea:notify_teachers_textarea},function(data) {
	  		if (data=="ok") {
          $('form textarea, form input').val('');
          alert("Teachers notification sent successfully.");
          $(".feedback").text("Teachers notification sent successfully.");
        }else{
          $(".feedback").text(data);
        }
	  	});
	  });
	  //student notifications
      $(document).on('click','#notify_students',function() {
        $('.modal_wrapper').css({'display':'block'});
        $('#notify_st_form').show(500);
      });
	  $('#notify_st_form').on('submit',function(e) {
      e.preventDefault();
	  	var notify_student_textarea=$('#notify_student_textarea').val().trim();
	  	$.post('ajax/news.php',{notify_student_textarea:notify_student_textarea},function(data) {
	  		if (data=="ok") {
          $(".feedback").text("Students notification sent successfully.");
          alert("Students notification sent successfully.");
          $('.modal_container form')[0].reset();
        }else{
          $(".feedback").text(data);
        }
	  	});
	  });
	  //add news image change
    $('.news_image').on('change',function() {
        var ext_array=$('.news_image').val().split('.');
        ext 		=ext_array[(ext_array.length)-1].toLowerCase();
        if ((ext=="png")||(ext=="jpeg")||(ext=="jpg")) {
          $(".add_news_error").text("Image added.");
        }else{
          $(".add_news_error").text("Invalid file formate. Upload jpg or png Image.");
        }
      });
    FeedAllNews();
    function FeedAllNews() {
      $.post('ajax/news.php',{feedAllNews:'feedAllNews'},function(data) {
        $('.news_cols_wrapper').html(data);
      });
    }
    //view news
    $(document).on('click','.news_cols',function() {
    	var theId=$(this).attr("data-id");
    	$.post('ajax/news.php',{theId:theId},function(data) {
        $('.modal_wrapper').css({'display':'block'});
    		$('#view_uploaded_news').show(500);
    		$('.news_info_fill').html(data);
    		$('.news_delete_button').attr('id',theId);
    	});
    });
    //delete news
    $(document).on('click','.news_delete_button',function() {
    	var news_del_id=$(this).attr("id");
    	if (confirm("Delete this news?")) {
	    	$.post('ajax/news.php',{news_del_id:news_del_id},function(data) {
	    		if (data=="ok") {
            $('.modal_wrapper').css({'display':'none'});
            $('#view_uploaded_news').hide(500);
		    		alert("News deleted");
            FeedAllNews();
	    		}else{
	    			$('#error_feed').fadeIn(100).text(data).delay(4000).fadeOut(50);
	    		}
	    	});
    	}
    });
    //view sent notifications
      $(document).on('click','#sent_notifications',function() {
      	notification();
      });
      function notification() {
      	var notify_fetch="true";
    	$.post('ajax/news.php',{notify_fetch:notify_fetch},function(data) {
        $('.modal_wrapper').css({'display':'block'});
        $('#view_notification').show(500);
    		$('.sent_n_fill').html(data);
    	});
      }
    //delete sent notifications
    $(document).on('click','.notify_del',function() {
    	var notify_del_id=$(this).attr("id");
    	if (confirm("Delete this Notification?")) {
	    	$.post('ajax/news.php',{notify_del_id:notify_del_id},function(data) {
	    		if (data=="ok") {
		    		notification();
            alert('Deleted');
	    		}else{
	    			$('#error_feed').fadeIn(100).text(data).delay(4000).fadeOut(50);
	    		}
	    	});
    	}
    });



    function _(x){
      return document.getElementById(x);
    }




    });
  })();
</script>
</body>
</html>