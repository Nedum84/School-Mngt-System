<?php
include("inc/header.inc.php");

$get_class=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM teachers WHERE teachers_id='$id'"));
if (empty($f_class)) {
	header('Location:home');
}
?>	<title>Manage Your Class</title>
	<div class="left_divs">
		<?php include 'inc/left_menu.inc.php'; ?>
	</div><!-- 
	--><div class="contents">
		<center>
			<div class="curriculum_result_view">
				<h4>Manage your class (<?php echo strtoupper($class); ?>)</h4>
				<div class="cur_res_btn">
					<button class="view_cur">View Curriculum</button>
					<button class="view_res">View/Approve Result</button>
				</div>
				<div class="res_cur_view">
					<!-- curriculum -->
					<div class="curriculum">
						<div class="uploaded_files">
							<h5>Uploaded Curriculum</h5>
							<div class="show_c_uploaded form_teachers" id="show_c_uploaded">
<!-- 								<div class="c_cols _cols">
									<h4>Curriculum JSS1</h4>
									<p><span>Subject: </span> English</p>
									<p><span>Term: </span> First Term</p>
									<p><span>Session: </span> 2016/2017</p>
									<p>
										<button class="c_view"> <i class="fa fa-eye"></i> View</button>
										<button class="c_download"> <i class="fa fa-download"></i> Download</button>
									</p>
								</div>
								<div class="c_cols _cols">
									<h4>Curriculum JSS1</h4>
									<p><span>Term: </span> First Term</p>
									<p><span>Session: </span> 2016/2017</p>
									<p>
										<button class="c_view"> <i class="fa fa-eye"></i> View</button>
										<button class="c_download"> <i class="fa fa-download"></i> Download</button>
									</p>
								</div> -->
							</div>
						</div>
					</div>
					<!-- curriculum -->
					<div class="result">
						<div class="uploaded_files">
							<h5>Uploaded Results</h5>
							<div class="show_r_uploaded form_teachers">
<!-- 								<div class="r_cols _cols">
									<h4>Mathematics Result JSS1B</h4>
									<p><span>Date: </span> 12/23/2017</p>
									<p><span>Term: </span> Second</p>
									<p><span>Teacher: </span> Mr Chris Okwume</p>
									<p>
										<button class="r_view"> <i class="fa fa-eye"></i> View</button>
									</p>
								</div>
								<div class="r_cols _cols">
									<h4>Mathematics Result JSS3E</h4>
									<p><span>Date: </span> 12/23/2017</p>
									<p><span>Term: </span> Second</p>
									<p><span>Teacher: </span> Mr Chris Okwume</p>
									<p>
										<button class="r_view"> <i class="fa fa-eye"></i> View</button>
									</p>
								</div> -->
							</div>
						</div>
						<div class="approve_res">
							<h4>Before approving result, make sure that all the subject has been uploaded.</h4>
							<button class="approveBtn" data-term_type='termly'>
								<i class="fa fa-check"></i> Approve Result
							</button>
							<button class="assignBtn" data-term_type='termly'>
								<i class="fa fa-check"></i> Assign Position
							</button>
							<button class="addBtn" data-term_type='termly'>
								<i class="fa fa-check"></i> Add Comment
							</button>
							<hr>
							<?php if ($term=='third') {?>
							<h3>FOR ANNUAL RESULT COMPUTAION ONLY</h3>
							<button class="approveBtn" data-term_type='annual'>
								<i class="fa fa-check"></i> Approve Result ANNUAL
							</button>
							<button class="assignBtn" data-term_type='annual'>
								<i class="fa fa-check"></i> Assign Position ANNUAL
							</button>
							<button class="addBtn" data-term_type='annual'>
								<i class="fa fa-check"></i> Add comment ANNUAL
							</button>
							<?php } ?>

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
<script type="text/javascript" src="js/teacher-management.js"></script>
<div id="error_feed"></div>
</body>
</html>