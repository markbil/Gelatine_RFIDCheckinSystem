<?php

header("Content-Type: application/rss+xml; charset=ISO-8859-1");
echo '<?xml version="1.0" encoding="UTF-8"?>';


	require_once ('../mysql_connection.php');
	
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
	<title type="text">Gelatine @The Edge</title>
	<subtitle type="text">who is here and does what?</subtitle>
	<updated>2012-11-07T12:44:32Z</updated>
	<link rel="alternate" type="text/html" href="http://theedge.checkinsystem.net" />
	<id>http://theedge.checkinsystem.net/feed/atom/</id>
	<link rel="self" type="application/atom+xml" href="http://theedge.checkinsystem.net/API/feed/checkins.php" />
	<link rel="hub" href="http://pubsubhubbub.appspot.com" />
	
<?php	
	//firstname, lastname, skills, help, catagories, mainlocation, sublocation, check_in_time, months_since_checkin, days_since_checkin, hours_since_checkin, minutes_since_checkin
    $query = "SELECT * FROM view_list_distinctusercheckins_all";
    $result = mysql_query($query) or die ("Could not execute query");
 	
    while($row = mysql_fetch_array($result)) {
        extract($row);
 
        $rssfeed .= '<entry>';
        $rssfeed .= '<author>';
        $rssfeed .= '<name>';
	        $rssfeed .= 'Author:' . $firstname . ' '  . $lastname;
        $rssfeed .= '</name>';
        $rssfeed .= '</author>';
        
        	$rssfeed .= '<title type="html"><![CDATA[' . $firstname . ' '  . $lastname . ']]></title>';
        $rssfeed .= '<link rel="alternate" type="text/html" href="http://theedge.checkinsystem.net/project-13/" />';
    		$rssfeed .= '<id>checked in at: ' . $check_in_time . '</id>';
        $rssfeed .= '<updated>2012-11-07T12:44:32Z</updated>';
        $rssfeed .= '<published>2012-11-07T12:44:32Z</published>';
        $rssfeed .= '<category scheme="http://theedge.checkinsystem.net" term="Future Project Ideas" />		<summary type="html"><![CDATA[asfd asdf asdf adfs asdf Project Collaborators : asdf]]></summary>';
        $rssfeed .= '<content type="html" xml:base="http://theedge.checkinsystem.net/project-13/"><![CDATA[<p>' . $sublocation . '</p>';
        $rssfeed .= '<ul class="wpuf_customs"><li><label>Project Collaborators</label> : asdf</li><ul>]]></content>';
        $rssfeed .= '<link rel="replies" type="text/html" href="http://theedge.checkinsystem.net/project-13/#comments" thr:count="0"/>';
        $rssfeed .= '<link rel="replies" type="application/atom+xml" href="http://theedge.checkinsystem.net/project-13/feed/atom/" thr:count="0"/>';
        $rssfeed .= '<thr:total>0</thr:total>';
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
	<entry>
		<author>
		<name>Example Author</name>
		</author>
		<title type="html"><![CDATA[Project 1]]></title>
		<link rel="alternate" type="text/html" href="http://theedge.checkinsystem.net/project-13/" />
		<id>http://theedge.checkinsystem.net/project-1/</id>
		<updated>2012-11-07T12:44:32Z</updated>
		<published>2012-11-07T12:44:32Z</published>
		<category scheme="http://theedge.checkinsystem.net" term="Future Project Ideas" />		<summary type="html"><![CDATA[asfd asdf asdf adfs asdf Project Collaborators : asdf]]></summary>
		<content type="html" xml:base="http://theedge.checkinsystem.net/project-13/"><![CDATA[<p>asfd asdf asdf adfs asdf</p>
<ul class="wpuf_customs"><li><label>Project Collaborators</label> : example</li><ul>]]></content>
		<link rel="replies" type="text/html" href="http://theedge.checkinsystem.net/project-13/#comments" thr:count="0"/>
		<link rel="replies" type="application/atom+xml" href="http://theedge.checkinsystem.net/project-13/feed/atom/" thr:count="0"/>
		<thr:total>0</thr:total>
	</entry>
</feed>
