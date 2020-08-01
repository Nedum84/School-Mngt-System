<?php 
@ob_start();
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('max_execution_time', '480');//480=8mins, 300=5mins
//  $localhost  ="localhost";
//  $user   ="wealthdo_ukwasam";
//  $password ="nedum08169981412"; 
//  $dat1   ="wealthdo_sjcorba_com_ng";
// $mysqli      = mysqli_connect($localhost, $user, $password,$dat1) or die("couldn't connect to the server");

$localhost	="localhost";
$user		="root";
$password	=""; 
$database   ="school";
 
$mysqli	= mysqli_connect($localhost, $user, $password,$database) or die("couldn't connect to the server");

    //school informations
    $schQuery=mysqli_query($mysqli,"SELECT * FROM school_info ");
    $schDetails=array();
    while ($sch_Det=mysqli_fetch_assoc($schQuery)) {
      $schDetails[$sch_Det['school_variable']]=ucfirst($sch_Det['d_values']);
    }
    function timer_converter($_time_value)
    {
        $time_value=$_time_value-time();
        if ($time_value>0) {
          $days =floor($time_value/(3600*24));
          $h1=floor($time_value/3600);
          $h1_rem=floor(($time_value%(3600*24))/3600);
          $m1= floor($time_value/60);
          $r_m1=floor(($time_value-($h1*3600))/60);
          $r_s1= floor($time_value-($m1*60));
          return $days.'days: '. $h1_rem.'hrs: '. $r_m1.'mins';
        }else{
            return '0days: 0hrs: 0mins';
        }
    }

    function timer_converter_f($time_converter)
    {      
        $date=date_create();
        date_timestamp_set($date,$time_converter);
        return date_format($date,"h:i:s A d/m/Y ");    
    }

    function timer_converter_admin($time_converter)
    {      
        $date=date_create();
        date_timestamp_set($date,$time_converter);
        return date_format($date,"d/m/Y"); 
    }

?>