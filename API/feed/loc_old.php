<?php
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
echo '<?xml version="1.0" encoding="UTF-8"?>';


	require_once ('../mysql_connection.php');
	require_once ('../timezone.php');
	
	$query_date = "SELECT * FROM view_list_distinctusercheckins_all";
	$result_date = mysql_query($query_date) or die ("Could not execute query");
	
	$lastpost_date = '';
	$row_date = mysql_fetch_array($result_date);
	$lastpost_date = $row_date['check_in_time'];

?>
<feed
	  xmlns="http://www.w3.org/2005/Atom"
	  xmlns:thr="http://purl.org/syndication/thread/1.0"
	  xml:lang="en-US"
	  xml:base="http://theedge.checkinsystem.net/wp-atom.php">
	<title type="text">People - @The Edge</title>
	<subtitle type="text">who is here and does what?</subtitle>
	<updated>2012-11-07T12:44:32Z</updated>
	<link rel="alternate" type="text/html" href="http://theedge.checkinsystem.net" />
	<id>http://theedge.checkinsystem.net/feed/atom/</id>
	<link rel="self" type="application/atom+xml" href="http://theedge.checkinsystem.net/API/feed/loc.php" />
	<link rel="hub" href="http://pubsubhubbub.appspot.com" />
	<link rel="hub" href="http://superfeedr.com/hubbub"/>
	
<?php	

	$tmz = mysql_query ("SET time_zone = " . $timezone) or die("mysql error setting timezone: " . mysql_error());
	
	//firstname, lastname, skills, help, catagories, mainlocation, sublocation, check_in_time, months_since_checkin, days_since_checkin, hours_since_checkin, minutes_since_checkin
    $query = "SELECT * FROM view_list_distinctusercheckins_all";
    $result = mysql_query($query) or die ("Could not execute query");
 	
    while($row = mysql_fetch_array($result)) {
        extract($row);
         
//         $user_id = $obj['user_id'];
        $avatarurl = "";
        $userstatus = "";
        $email = "";
        $twitter = "";
        $goodreadsurl = "";
        $blog = "";
        
        //get email
        $email_query = "SELECT email FROM user_email WHERE user_id = " . $user_id;
        $rs_email = mysql_query ($email_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_email)){
        	$email = $get_field['email'];
        }
        //get twitter
        $twitter_query = "SELECT twitter FROM user_twitter WHERE user_id = " . $user_id;
        $rs_twitter = mysql_query ($twitter_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_twitter)){
        	$twitter = $get_field['twitter'];
        }
        //get blog
        $blog_query = "SELECT blog FROM user_blog WHERE user_id = " . $user_id;
        $rs_blog = mysql_query ($blog_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_blog)){
        	$blog = $get_field['blog'];
        }
        //get avatarurl
        $avatarurl_query = "SELECT avatarurl FROM user_avatarurl WHERE user_id = " . $user_id;
        $rs_avatarurl = mysql_query ($avatarurl_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_avatarurl)){
        	$avatarurl = $get_field['avatarurl'];
        }
        //get status
        $status_query = "SELECT status FROM user_status WHERE user_id = " . $user_id;
        $rs_status = mysql_query ($status_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_status)){
        	$status = $get_field['status'];
        }
        //get goodreadsurl
        $goodreadsurl_query = "SELECT goodreadsurl FROM user_goodreadsurl WHERE user_id = " . $user_id;
        $rs_goodreadsurl = mysql_query ($goodreadsurl_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_goodreadsurl)){
        	$goodreadsurl = $get_field['goodreadsurl'];
        }
        	
        //get aboutme
        $aboutme_query = "SELECT aboutme FROM user_aboutme WHERE user_id = " . $user_id;
        $rs_aboutme = mysql_query ($aboutme_query) or die("mysql error: " . mysql_error());
        while ($get_field = mysql_fetch_assoc($rs_aboutme)){
        	$aboutme = $get_field['aboutme'];
        }
        
        $timepassed = "";
        if($months_since_checkin > 0) $timepassed = $months_since_checkin . " months";
        else if($days_since_checkin > 0) $timepassed = $days_since_checkin . " days";
        else if($hours_since_checkin > 0) $timepassed = $hours_since_checkin . " hours";
        else if($minutes_since_checkin >= 0) $timepassed = $minutes_since_checkin . " minutes";
   
        
        $rssfeed .= '<entry>';
        $rssfeed .= '<author>';
        $rssfeed .= '<name>';
	    $rssfeed .= 'Gelatine - @The Edge';
        $rssfeed .= '</name>';
        $rssfeed .= '</author>';
        
        	$rssfeed .= '<title type="html"><![CDATA[' . $firstname . ' '  . $lastname . ']]></title>';
        $rssfeed .= '<link rel="alternate" type="text/html" href="http://theedge.checkinsystem.net/user-community/" />';
    		$rssfeed .= '<id>' . $firstname . ' '  . $lastname . ' at: ' . $check_in_time . '</id>';
        $rssfeed .= '<updated>2012-11-07T12:44:32Z</updated>';
        $rssfeed .= '<published>2012-11-07T12:44:32Z</published>';
        $rssfeed .= '<category scheme="http://theedge.checkinsystem.net" term="Future Project Ideas" />';
        $rssfeed .= '<summary type="html"><![CDATA[SUMMARY....]]></summary>';
        $rssfeed .= '<content type="html" xml:base="http://theedge.checkinsystem.net/blabla">';
        $rssfeed .= '<![CDATA[';
        $rssfeed .= '' . $timepassed . ' ago in '  . $sublocation . ' at ' . $mainlocation;
//         $rssfeed .= '<p>' . $sublocation . '</p>';
//         $rssfeed .= '<p>' . $timepassed . '</p>';
		
        $rssfeed .= '<div> ' . $aboutme . '</div>';
        $rssfeed .= '<div>Status: ' . $status . '</div>';

        $rssfeed .= '<div>Skills: ' . $skills . '</div>';
        $rssfeed .= '<div>Needs help with: ' . $help . '</div>';
        $rssfeed .= '<div>Interests: ' . $categories . '</div>';
        
        
        $rssfeed .= '<div>Contact:</div>';
        $rssfeed .= '<div>' . $blog . '</div>';
        $rssfeed .= '<div>' . $twitter . '</div>';
        $rssfeed .= '<div>' . $goodreadsurl . '</div>';
//        $rssfeed .= '<div>' . $avatarurl . '</div>';
        
        $rssfeed .= '<div><a style="float: left; padding-top: 10px; padding-right: 20px;">
        <img alt="" src="' . $avatarurl . '" height="100" width="100"/></a></div>';

        $rssfeed .= ']]></content>';
//         $rssfeed .= '<link rel="replies" type="text/html" href="http://theedge.checkinsystem.net/project-13/#comments" thr:count="0"/>';
//         $rssfeed .= '<link rel="replies" type="application/atom+xml" href="http://theedge.checkinsystem.net/project-13/feed/atom/" thr:count="0"/>';
//         $rssfeed .= '<thr:total>0</thr:total>';
        $rssfeed .= '</entry>';
        
        echo $rssfeed;
    }
	
?>	

	<entry>
		<author>
		<name>Example Author</name>
		</author>
		<title type="html"><![CDATA[project 2]]></title>
		<link rel="alternate" type="text/html" href="http://theedge.checkinsystem.net/project-13/" />
		<id>http://theedge.checkinsystem.net/project-2/</id>
		<updated>2012-11-07T12:44:32Z</updated>
		<published>2012-11-07T12:44:32Z</published>
		<category scheme="http://theedge.checkinsystem.net" term="Future Project Ideas" />		<summary type="html"><![CDATA[asfd asdf asdf adfs asdf Project Collaborators : asdf]]></summary>
		<content type="html" xml:base="http://theedge.checkinsystem.net/project-13/"><![CDATA[<p>asfd asdf asdf adfs asdf</p>
<ul class="wpuf_customs"><li><label>Project Collaborators</label> : asdf</li><ul>]]></content>
		<link rel="replies" type="text/html" href="http://theedge.checkinsystem.net/project-13/#comments" thr:count="0"/>
		<link rel="replies" type="application/atom+xml" href="http://theedge.checkinsystem.net/project-13/feed/atom/" thr:count="0"/>
		<thr:total>0</thr:total>
	</entry>
</feed>