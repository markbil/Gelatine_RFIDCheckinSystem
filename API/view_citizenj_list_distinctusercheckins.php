<?php


require_once ('mysql_connection.php');
require_once ('timezone.php');

$result_limit=null;
$search_location_id=null;
if (isset($_GET['limit'])) {
	$result_limit=$_GET['limit'];
}
if (isset($_GET['location'])) {
	$search_location_id=$_GET['location'];
}
$arr = array();


$query = "SELECT * FROM `view_list_distinctusercheckins_all` ";
if(!empty($search_location_id)) {
	$query .= "WHERE sl_id = '" . $search_location_id . "' ";
}
$query .= "GROUP BY user_id ORDER BY check_in_time DESC";

if(!empty($result_limit)) {
	$query .= "LIMIT 0," . $result_limit;
}

$tmz = mysql_query ("SET time_zone = " . $timezone) or die("mysql error setting timezone: " . mysql_error());
$rs = mysql_query ($query) or die("mysql error running query: " . mysql_error()); 


while($obj = mysql_fetch_assoc($rs)) {
		
	$user_id = $obj['user_id'];
	$obj['fullname']=$obj['firstname'] . ' '.$obj['lastname'] ; 

	//get skills list for each user
	$skills_user_checkedin = "SELECT skills FROM view_list_distinctusercheckins_all WHERE user_id = " . $user_id;
	$arr_skills = array();
	$rs_skills = mysql_query ($skills_user_checkedin) or die("mysql error: " . mysql_error());
	while ($get_field = mysql_fetch_object($rs_skills)){
		
			$arr_skills[] = ($get_field);
		
	}

	//get interest list for each user
	$interests_user_checkedin = "SELECT categories FROM view_list_distinctusercheckins_all WHERE user_id = " . $user_id;
	$arr_interest = array();
	$rs_interest = mysql_query ($interests_user_checkedin) or die("mysql error: " . mysql_error());
	while ($get_field = mysql_fetch_row($rs_interest)){
		foreach ($get_field as $int){
			$arr_interest[] = $int;
		}
	}
	
	//get needs list for each user
	$needs_user_checkedin = "SELECT help FROM view_list_distinctusercheckins_all WHERE user_id = " . $user_id;
	$arr_needs = array();
	$rs_needs = mysql_query ($needs_user_checkedin) or die("mysql error: " . mysql_error());
	while ($get_field = mysql_fetch_object($rs_needs)){
	
		$arr_needs[] = ($get_field);
	
	}
	
	
	
	$obj['skills'] = $arr_skills;
	$obj['interests'] = $arr_interest;
	$obj['needs'] = $arr_needs;
	$arr[] = $obj;

}
 
//echo 'QUERY[' . var_export($query,true) . ']<br>';
//echo 'GET[' . var_export($_GET,true) . ']<br>';
echo json_encode($arr);

?>
