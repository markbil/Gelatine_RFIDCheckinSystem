<?php


require_once ('mysql_connection.php');
require_once ('timezone.php');
 
$arr = array();
//VIEW: "view_list_distinctusercheckins_all" =   all check-ins and user details, but only the most recent checkin per edge_user is returned
SELECT user_id, rfid, firstname, lastname, skills, help, categories, mainlocation, sublocation, MAX(check_in_time) as check_in_time, months_since_checkin, days_since_checkin, hours_since_checkin, minutes_since_checkin FROM `view_checkins` GROUP BY user_id ORDER BY check_in_time DESC

//SELECT * FROM `view_list_distinctusercheckins_all` WHERE days_since_checkin < 1 GROUP BY user_id ORDER BY check_in_time DESC

	//OTHER POSSIBLE VARIABLES
	//months_since_checkin < 7	//checkins in the last 6 months
	//days_since_checkin < 1		//only today's checkins
	//hours_since_checkin < 3		//checkins in the last 2 hours
	//minutes_since_checkin < 11	//checkins in the last 10 minutes

$tmz = mysql_query ("SET time_zone = " . $timezone) or die("mysql error: " . mysql_error());
$rs = mysql_query ($query) or die("mysql error: " . mysql_error()); 


while($obj = mysql_fetch_assoc($rs)) {
		
	$user_id = $obj['user_id'];

	//get expertise list for each user
	$expertise_user_checkedin = "SELECT expertise FROM expertise_table et, edge_users_expertises eue WHERE eue.expertise_id = et.id AND eue.edge_users_id = " . $user_id;
	$arr_expertise = array();
	$rs_expertise = mysql_query ($expertise_user_checkedin) or die("mysql error: " . mysql_error());
	while ($get_field = mysql_fetch_row($rs_expertise)){
		foreach ($get_field as $exp){
			$arr_expertise[] = $exp;
		}	
	}

	//get interest list for each user
	$interests_user_checkedin = "SELECT interest FROM interest_table it, edge_users_interests eui WHERE it.id = eui.interest_id AND eui.edge_users_id = " . $user_id;
	$arr_interest = array();
	$rs_interest = mysql_query ($interests_user_checkedin) or die("mysql error: " . mysql_error());
	while ($get_field = mysql_fetch_row($rs_interest)){
		foreach ($get_field as $int){
			$arr_interest[] = $int;
		}
	}
	
	
	$obj['expertise'] = $arr_expertise;
	$obj['interests'] = $arr_interest;
	$arr[] = $obj;

}
 

echo json_encode($arr);

?>