<?php
include("inc/header.inc.php");
if (($status=="principal")){
  header('Location:home.php');
}else{
  $getInfo=mysqli_query($mysqli,"SELECT * FROM notice ORDER BY id DESC ");
}
?><title>Notifications!</title>
  <div class="left_divs">
    <?php include 'inc/left_menu.inc.php'; ?>
  </div><!-- 
  --><div class="contents">
	<div id="welcome" class="home_welcome">
			<h4>Notifications!</h4>
	</div>
    <center>
      <div class="news_cols_wrapper">
      	<h5>Notifications from the principal.</h5>
      	<?php 
      	while ($row=mysqli_fetch_assoc($getInfo)) {
      		if ($row['for_who']==$status) {
      			echo '<div class="news_cols" data-id="'.$row['id'].'" style="border-radius:2px;cursor: default;"><span>'.timer_converter_admin($row['date_uploaded']).'</span> : '.$row['message'].'</div>
      		';
      		}
      	}
      	 ?>
      </div>
    </center>
  </div>
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
  (function() {
    $(document).ready(function() {
      $(document).on('click','#notify_teachers',function() {
        $('#notify_teachers_modal').show(500);
      });

    function _(x){
      return document.getElementById(x);
    }

    });
  })();
</script>
<div id="error_feed"></div>
</body>
</html>