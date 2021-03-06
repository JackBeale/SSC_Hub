<!DOCTYPE html>

<?php
session_start();


$dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "dbTest";
 
 
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

$email = "john@example.com";
$event_id = 2;
$_SESSION['email'] = $email;
$_SESSION['event_id'] =  $event_id;

$email = mysqli_real_escape_string($conn, $email);
$event_id = intval($event_id);

$query = "select * from event_rating where event_id = $event_id";
$result = $conn->query($query);
$row = mysqli_num_rows($result);
 
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-config" content="none"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SSC Hub</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap-combobox.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
</head>
<body>
<style>
body {
    padding-top: 50px;
}

#RatingContainer {
	background-color: #f1f1f1;
	border-radius: 25px;
	padding: 0px 3px 6px 20px;
}

.event-status-summary{
    margin: 6px 0 0 0;
    border-bottom: 1px solid #dcdcdc;
    padding: 0 0 6px 0;
}

.event-status-summary .label{
    font-size: 90%;
}

.table-nonfluid {
    width: auto !important;
}

.panel-attending{
    margin-top: 20px;
}

.list-group-item.attending-member{
    padding: 4px 10px !important;
}

.list-group.list-attendees, .list-group.list-event-log{
    overflow-y: auto;
    max-height: 233px;
}

.list-group.list-event-log{
  margin-bottom: 0px;
}

.list-group.list-event-log p{
  display: inline;
}

.event-not-published{
    background: repeating-linear-gradient(
      15deg,
      #ECECEC,
      #ECECEC 10px,
      transparent 10px,
      transparent 20px
    );
}

.event-not-published .glyphicon-eye-close{
  color: #337AB7;
  font-size: 40px;
  margin-left: 10px;
}

.event-passed-deadline .glyphicon-time{
  color: #fbb106;
  font-size: 18px;
  margin-right: 5px;
}

.my-events-list li .label{
  font-size: 24px;
}

.option-label{
  width: 100px;
}

.hover-member-picture{
  position: absolute;
  z-index: 1;
  padding: 10px;
  display: inline-block;
  background: white;
  border: 1px solid black;
}

.footer{
    font-size: 75%;
    margin: 25px 0 0 0;
    padding: 5px;
    text-align: right;
    border-top: 1px solid #dcdcdc
}

.img-margin-right{
  margin-right: 10px;
}

.secure-warning{
  background-color: #ffee95;
  border-bottom: 1px solid #dcc131;
  padding: 5px 0;
  margin-bottom: 10px;
}


.diff td{
  padding:0 0.667em;
  vertical-align:top;
  white-space:pre;
  white-space:pre-wrap;
  font-family:Consolas,'Courier New',Courier,monospace;
  font-size:0.75em;
  line-height:1.333;
}

.diff span{
  display:block;
  min-height:1.333em;
  margin-top:-1px;
  padding:0 3px;
}

* html .diff span{
  height:1.333em;
}

.diff span:first-child{
  margin-top:0;
}

.diffDeleted span{
  border:1px solid rgb(255,192,192);
  background:rgb(255,224,224);
}

.diffInserted span{
  border:1px solid rgb(192,255,192);
  background:rgb(224,255,224);
}

.featured-event-body{
  height: 150px;
  background: #cacaca;
  background-position: top center;
  background-size: cover;
  border-radius: 5px;
  margin-top: 10px;
  display: block;
}

.featured-event .label{
  position: absolute;
  top: 13px;
  left: 18px;
  border: 1px solid white;
}

.featured-event-text{
  position: absolute;
  bottom: 0;
  left: 15px;
  padding: 0 5px;
  border-radius: 5px;
  margin-right: 15px;
  color: white;
  background-color: rgba(0,0,0,.65);
}

.featured-event-club{
  position: absolute;
  top: 10px;
  right: 0;
  padding: 0 5px;
  border-radius: 5px;
  margin-right: 15px;
  color: white;
  background-color: rgba(0,0,0,.65);
}

.request-place-deadline-passed {
  color: #fb0606;
  width: 375px;
  display: inline-block;
  padding-top: 3px;
  margin-left: 5px;
}


.request-place-deadline-passed .glyphicon-time {
 
  font-size: 42px;
  margin-right: 5px;
  color: #fbb106;
}


.heading {
    font-size: 25px;
    margin-right: 25px;
}

.fa {
    font-size: 25px;
}

.checked {
    color: orange;
}

/* Three column layout */
.side {
    float: left;
    width: 15%;
    margin-top:10px;
}

.middle {
    margin-top:10px;
    float: left;
    width: 70%;
}

textarea {
resize: none;
}

/* Place text to the right */
.right {
    text-align: right;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* The bar container */
.bar-container {
    width: 100%;
    background-color: #f1f1f1;
    text-align: center;
    color: white;
}

/* Individual bars */
.bar-5 {width: 60%; height: 18px; background-color: #4CAF50;}
.bar-4 {width: 30%; height: 18px; background-color: #2196F3;}
.bar-3 {width: 10%; height: 18px; background-color: #00bcd4;}
.bar-2 {width: 4%; height: 18px; background-color: #ff9800;}
.bar-1 {width: 15%; height: 18px; background-color: #f44336;}

/* Responsive layout - make the columns stack on top of each other instead of next to each other */
@media (max-width: 400px) {
    .side, .middle {
        width: 100%;
    }
    .right {
        display: none;
    }
}


</style>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-78016541-1', 'auto');
ga('send', 'pageview');

</script>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" title="Click here to direct you to SSC Hub site" href="/"> SSC Hub</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="/">Home</a></li>-->

                <li><a title="Click here to organise a new club event" href="/event/create">Organise an Event</a></li>
                <li><a title="Click here to view the current active club events" href="/event">Events</a></li>
                <li><a title="Click here to view the regular club events" href="/regular">Regular Events</a></li>
                <li><a title="Click here to view all the club organisers" href="/organisers">Organisers</a></li>

                
                <li><a title="Click here to view the site Frequently Asked Questions (FAQ)" href="/faq">FAQ</a></li>
                <li><a title="Click here to send an email to the SSC Hub members" href="mailto:sschub@.com">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li><a title="Click here to view your SSC Hub member home page" href="/me">Hi, Lesroy</a></li>
                <li><a title="Click here to logout the SSC Hub member site" href="/logout">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="row">
    <div class="col-md-8">
  
<div id = "Container">
<div id = "RatingContainer">
<?php

if($row == 1){
	
	while($row=mysqli_fetch_assoc($result))
	{
?>
	<h3> You have already rated this event. The details of your review are as follows: </h3>
	<h4> Rating score: </h4>
   <p>  <?php echo $row['rating'];?>/5 <p>
   <h4> The feedback you provided on this event was: </h4>
   <p> <?php echo $row['user_feedback'];?> </p>
	<?php } ?>
<?php
} else {
?>

 <p> <?php echo $row;?> </p>




      <h1>Event Review Page</h1>
        <h3>Please enter any feedback from the Christams Lunch event</h3>
<form method="post" action="connectionToDB.php">
       <div id ="CommentSection" >
       <textarea name="comments" input type ="text" rows="20" cols="70" required></textarea>
		</div>
				 
<div id = "UserRatingSystem">
<span class="heading">User Rating</span>
<select name="rating" size="5" required>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
<div id = "SubmitButton">
		 <input type="submit" value="Submit">
		 <?php
		 "include/redirect.php";
		 ?>
		 </div>
        </div>
		</form>
<?php } ?>
</div>
        <ul>
            <li><a href="http://Home">Home</a></li>
            <li><a href="http://About">About</a></li>
        </ul>
		
	   </div>
         </div>  
		 
    <div class="col-md-4">
        <h2>Next Events <small style="font-size:40%">(<a title="Click to view your subscription profile" href="/me" data-toggle="tooltip" data-placement="top" title="" data-original-title="Clubs shown: ABD, BHM, BRS, EDI, ESX, GLA, GLO, LHD, LON, MAN, MK, NAT, RDG, WAL">Showing from 14 clubs</a>)</small></h2><ul class="list-group"><li class="list-group-item clearfix event-passed-deadline "><i class="glyphicon glyphicon-time pull-left" data-toggle="tooltip" data-placement="top" title="The deadline for this event has now passed. Applying for a place will put you on the Waiting List."></i><span class="label label-primary pull-right"><i class="glyphicon glyphicon-record"></i> Requested a place</span>
        <span class="text-muted small">Sat 19th Jan 2019</span>
        <span class="text-muted small" data-toggle="tooltip" data-placement="top" title="Leatherhead">[LHD] </span>
        <br /><strong><a title="Click to view this event" href="/event/bottomless-brunch-124"> Bottomless Brunch</a></strong>
        </li><li class="list-group-item clearfix ">
        <span class="text-muted small">Fri 25th Jan 2019</span>
        <span class="text-muted small" data-toggle="tooltip" data-placement="top" title="Leatherhead">[LHD] </span>
        <br /><strong><a title="Click to view this event" href="/event/burns-night-129"> Burns Night</a></strong>
        </li><li class="list-group-item clearfix event-passed-deadline "><i class="glyphicon glyphicon-time pull-left" data-toggle="tooltip" data-placement="top" title="The deadline for this event has now passed. Applying for a place will put you on the Waiting List."></i>
        <span class="text-muted small">Fri 1st Feb 2019</span>
        <span class="text-muted small" data-toggle="tooltip" data-placement="top" title="Leatherhead">[LHD] </span>
        <br /><strong><a title="Click to view this event" href="/event/bad-movie-night-live-128"> Bad Movie Night Live: The Room + Q&A at Prince Charles Cinema</a></strong>
        </li><li class="list-group-item clearfix event-passed-deadline "><i class="glyphicon glyphicon-time pull-left" data-toggle="tooltip" data-placement="top" title="The deadline for this event has now passed. Applying for a place will put you on the Waiting List."></i>
        <span class="text-muted small">Fri 1st Mar 2019</span>
        <span class="text-muted small" data-toggle="tooltip" data-placement="top" title="Leatherhead">[LHD] </span>
        <br /><strong><a title="Click to view this event" href="/event/10cc-122"> 10cc</a></strong>
        </li><li class="list-group-item clearfix event-passed-deadline "><i class="glyphicon glyphicon-time pull-left" data-toggle="tooltip" data-placement="top" title="The deadline for this event has now passed. Applying for a place will put you on the Waiting List."></i>
        <span class="text-muted small">Sun 3rd Mar 2019</span>
        <span class="text-muted small" data-toggle="tooltip" data-placement="top" title="Leatherhead">[LHD] </span>
        <br /><strong><a title="Click to view this event" href="/event/henning-wehn---get-o-106"> Henning Wehn - Get On With It</a></strong>
        </li><li class="list-group-item clearfix event-passed-deadline "><i class="glyphicon glyphicon-time pull-left" data-toggle="tooltip" data-placement="top" title="The deadline for this event has now passed. Applying for a place will put you on the Waiting List."></i>
        <span class="text-muted small">Tue 14th May 2019</span>
        <span class="text-muted small" data-toggle="tooltip" data-placement="top" title="Leatherhead">[LHD] </span>
        <br /><strong><a title="Click to view this event" href="/event/paul-mertons-impro-c-113"> Paul Merton’s Impro Chums</a></strong>
        </li></ul><a title="Click to view the current SSC club events" href="/event" class="pull-right" style="margin-top: -18px;">Want to see all events?</a>    </div>


    <div class="row">
        <div class="col-md-12 footer">
            Page generated in 0.0558 seconds, using 6 queries. | SSC Hub - <a href="mailto:sschub@.com">Contact</a>
        </div>
    </div>
</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
 <script src="/assets/js/bootstrap-combobox.js"></script>
 <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 <script src="/assets/js/handlebars-v4.0.5.js"></script>
 <script src="/assets/js/ssc.js"></script>
</body>
</html>
