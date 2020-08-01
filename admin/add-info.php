 <?php
include("inc/header.inc.php");
$getInfo=mysqli_query($mysqli,"SELECT * FROM news ORDER BY id DESC LIMIT 30");

?>
<title>Add News</title>
  <div class="left_divs">
    <?php include 'inc/left_menu.inc.php'; ?>
  </div><!-- 
  --><div class="contents">
	<div id="welcome" class="home_welcome">
			<h4>News that will show in the home/Landing page.</h4>
	</div>
    <center>
    <div class="news_panel_wrapper white_background">
      <form enctype="multipart/form-data" method="post" id="add_news_panel_form">
        <div class="news_panel_each">
            <label for="news_panel_subject">News Subject/Heading</label>
            <input type="text" id="news_panel_subject" name="news_panel_subject" placeholder="Enter news subject">        
        </div>
        <div class="news_panel_each">
            <label for="class">Write the news</label>
            <div class="text_editor">
              <textarea id="news_panel_body" name="news_panel_body"></textarea>
              <div class="end_text_editor"><span class="add_news_error text-danger"></span>
                <hr>
                <button type="submit" name="audio_submit" class="addBtnEffects"><span>Add News</span> <i class="fa fa-share"></i></button>
              </div>
            </div>     
        </div>
      </form>
    </div>
    </center>
  </div>
  

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
  bkLib.onDomLoaded(function() {
    // nicEditors.allTextAreas();
    new nicEditor({fullPanel : true}).panelInstance('news_panel_body');
  });
</script>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {

    var news_panel_form = _("add_news_panel_form");
    news_panel_form.addEventListener('submit', function(e) {
      var ajax = new XMLHttpRequest();
      ajax.open("POST", "ajax/news.php", true);
      ajax.onload = function(event) {
        if (ajax.status == 200 && ajax.readyState == 4) {
          if (ajax.responseText=="ok") {
            $('#add_news_panel_form')[0].reset();
            alert('News added succesfully.');
            window.location.href="information";
          }else{
            $(".add_news_error").html(ajax.responseText);
          }           
        } else {$(".add_news_error").text("Error "+ajax.status+" occurred when trying to upload your news.");}
      };
      ajax.send(new FormData(news_panel_form));
      e.preventDefault();return false;
    },false);



    function _(x){
      return document.getElementById(x);
    }


    });
  })();
</script>
</body>
</html>