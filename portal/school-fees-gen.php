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
		<div class="check_result_wrapper">
			<div class="check_result">
				<div class="check_r_header">
					<h3>Generate School Fees</h3>
					<h4>Carefully Fill the form below to generate your school Payment Invoice</h4>
				</div>
				<div class="check_r_body">
					<form method="post" id="school_fees_gen">
						<input type="text" id="st_class" placeholder="Class" name="sch_fees_gen_class" value="<?php if (isset($class)){echo $class;}?>">
						<select id="st_session" name="sch_fees_gen_session" class="">
							<?php sessionSelect(); ?>
						</select>
						<select id="st_term" name="sch_fees_gen_term">
							<?php termSelect(); ?>
						</select>
						<input type="hidden" id="st_class" name="sch_fees_gen_st_id" value="<?php if (isset($id)){echo $id;}?>">
						<span>Make sure you pay to the bank using the RRR generated from this website.</span>
						<div class="enter_btn">
							<button id="sch_fees_gen_submit" type="submit" name="sch_fees_gen_submit"> <i class="fa fa-refresh fa-spin"></i> Generate Invoice</button>
						</div>
					</form>
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