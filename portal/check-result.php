<?php
include("inc/header.inc.php");
if ($status!="students") {
    header("Location:home");
}
?>	<title>Check your result</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
            <div id="welcome" class="home_welcome">
                <h4>
                    Result checking
                </h4>
            </div>
			<div class="check_result_wrapper">
				<div class="check_result">
					<div class="check_r_header">
						<h3>Check your Result</h3>
						<h4>Carefully Fill the form below to check your result</h4>
					</div>
					<div class="check_r_body">
						<input type="text" id="st_class" placeholder="Class" name="r_class" value="<?php if (isset($class)){echo $class;}?>" >
						<select id="st_session" name="st_session" class="session_drop_wait">
							<?php sessionSelect(); ?>
						</select>
						<select id="st_term" name="st_term">
							<?php termSelect(); ?>
							<option value="annual">Annual</option>
						</select>
						<input type="text" id="st_pin" placeholder="Scratch card pin" name="r_class">
						<span>If you have printed your result for the first time, you can skip putting your scratch card pin.</span>
						<div class="enter_btn">
							<button id="check_result" type="submit" name="add_result"> <i class="fa fa-check"></i> Check Result</button>
						</div>
					</div>
				</div>
			</div>
		</center>
	</div>
</div>

<?php
include("inc/footer.inc.php");
?>
<script type="text/javascript">
	$(document).ready(function() {

	});
</script>
<div id="error_feed"></div>
</body>
</html>