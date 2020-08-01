		<ul id="left_side_div">
		    <li id="faculty"><a href="home"><i class="fa fa-home"></i> Home <i class="fa fa-angle-right"></i></a></li>
		    <li><a href="profile"><i class="fa fa-edit"></i> Edit profile <i class="fa fa-angle-right"></i></a></li>
		    <?php 
		    if ($status!="teachers") {
          echo '<li><a href="view-curriculum"><i class="fa fa-book"></i> View curriculum <i class="fa fa-angle-right"></i></a></li><li><a href="view-assignment"><i class="fa fa-eye"></i> View Assignment <i class="fa fa-angle-right"></i></a></li>';
		    }if ($status=="students") {
          		echo '<li id="student"><a href="check-result"><i class="fa fa-certificate"></i> Check result <i class="fa fa-angle-right"></i></a></li>
          			<li id="student"><a href="school-fees"><i class="fa fa-briefcase"></i> School Fees <i class="fa fa-angle-right"></i></a></li>
          			<li id="student"><a href="info-view"><i class="fa fa-info"></i> Notifications<i class="fa fa-angle-right"></i><span>'.countInfo().'</span></a></li>';
		    }if ($status=="teachers") {
		    	echo '<li id="faculty"><a href="uploads"><i class="fa fa-upload"></i> Upload <i class="fa fa-angle-right"></i></a></li>
		    		<li id="faculty"><a href="result-sheet"><i class="fa fa-print"></i> Exam Sheet <i class="fa fa-angle-right"></i></a></li>
          			<li id="student"><a href="info-view"><i class="fa fa-info"></i> Notifications<i class="fa fa-angle-right"></i><span>'.countInfo().'</span></a></li>';
		    }
		    if (!empty($f_class)) {
		    	echo '<li id="student"><a href="teacher-management"><i class="fa fa-users"></i> Your Class <i class="fa fa-angle-right"></i></a></li>';
		    }
		     ?>		    
		    <li><a href="process/logout"><i class="fa fa-power-off"></i> Logout <i class="fa fa-angle-right"></i></a></li>
	    </ul>