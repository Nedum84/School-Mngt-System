
  </div><!-- theiaStickySidebar -->
</div><!-- right -->
</div><!-- wrapper -->

  <div class="footer">
    <p>
      <?php echo ucfirst($schDetails['school_name']); ?>. &copy; <?php echo date('Y'); ?> All right Reserved
    </p>
  </div>
</div>


<script type="text/javascript" src="js/sweetalert.js"></script> 
<script src="js/sweetalert.min.js"></script>
<!-- <script type="text/javascript" src="../portal/js/upload.js"></script> -->
<script type="text/javascript" src="js/result-upload.js"></script>
<script type="text/javascript" src="js/dashboard.js"></script>

<!-- sticky side bars -->
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="js/dist/ResizeSensor.min.js"></script>
	<script type="text/javascript" src="js/dist/theia-sticky-sidebar.min.js"></script>


<!-- vendors -->
	<!-- jQuery -->
	<!-- <script src="../js/vendors/jquery/dist/jquery.min.js"></script> -->
	<!-- Bootstrap -->
	<script src="../js/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="../js/vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="../js/vendors/nprogress/nprogress.js"></script>
	<!-- Datatables -->
	<script src="../js/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../js/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../js/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../js/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	<script src="../js/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script src="../js/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../js/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script src="../js/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
	<script src="../js/vendors/jszip/dist/jszip.min.js"></script>
	<script src="../js/vendors/pdfmake/build/pdfmake.min.js"></script>
	<script src="../js/vendors/pdfmake/build/vfs_fonts.js"></script>
	<!-- Custom Theme Scripts -->
	<!-- <script src="../js/vendors/build/js/custom.min.js"></script>    -->

<script type="text/javascript">
  jQuery(document).ready(function() {
    var windWidth = $(window).width();
    if (windWidth >= 800) {
      jQuery('.nav_div, .right').theiaStickySidebar({
        // Settings
        // additionalMarginTop: 30
      });      
    };
  });
</script>

<script type="text/javascript" src="nicEditor/nicEdit.js"></script>
<!-- <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> -->
<div id="error_feed"></div>
<?php include_once 'inc/modals.inc.php'; ?>
</body>
</html>