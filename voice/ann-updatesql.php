<?php

include("/var/www/nycga.net/web/wp-config.php");
//include("/var/www/nycga.net/web/wp-includes/post.php");


  $currentseq = @$_GET['currentseq'] ;
  $datetime = @$_GET['datetime'] ;
  $currentvm = @$_GET['currentvm'] ;
  $callername = @$_GET['callername'] ;
  $userid1 = @$_GET['userid'] ;
  $callerid = @$_GET['callerid'] ;
  
date_default_timezone_set('EST');
$timenow = date("l M jS  h:i A");

$mp3base = "http://voicetest.occupy.net/voice/voicefiles";
$wavurl = $currentvm ;
$wavurl1 = strrchr($wavurl, "/");
$wavurl2 = substr( $wavurl1, 1 );
$wavurl3 = substr($wavurl2, 0, -4); 
$mp3url = "$mp3base/$wavurl3.mp3";
  
  if ($userid1 == "") {
  $userid1 = "7136";
  }

  if ($callername == "") {
  $callername = "Anonymous";
  }
  
  $titlepost = "Voice Announcement from $callername at $timenow";
  $wavlink = "[audio $mp3url|bg=0x0000ff|righticon=0xff0000]";
  $contentpost = "$wavlink <br><a href= $mp3url target='_blank'>Download Voice File</a><br><br><i>This post was generated by NYCGA Voice Services at 1-855-203-7763.  Add your mobile phone number to your account profile and call in for personalized services.</i>";
  
  switch_to_blog(5);
  
// Create post object in wordpress
  $my_post = array(
     'post_title' => $titlepost,
     'post_content' => $contentpost,
     'post_status' => 'publish',
     'post_author' => $userid1,
     'post_category' => array(1049),
	 'tags_input' => 'voice'
  );

// Insert the post into the database
  wp_insert_post( $my_post );
  
  
//connect to your database ** EDIT REQUIRED HERE **
mysql_connect(constant("DB_HOST"),constant("DB_USER"),constant("DB_PASSWORD")); //(host, username, password)

//specify database ** EDIT REQUIRED HERE **
mysql_select_db(constant("DB_NAME")) or die("Unable to select database"); //select which database we're using

// Build SQL Query  
mysql_query("INSERT INTO voice_log (currentseq, datetime, currentvm, callername, userid, callerid)
VALUES ('$currentseq', '$datetime', '$currentvm', '$callername', '$userid1', '$callerid')");


?>