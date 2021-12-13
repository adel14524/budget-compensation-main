<?php
require_once 'core/init.php';
include 'includes/header.php';
?>

<body>
	<nav class="navbar navbar-light bg-light navbar-expand-md py-md-2">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">Doer</a>
		    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		        <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="navbar-collapse collapse" id="navbarNav">
		        <ul class="navbar-nav ml-auto">
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">OKR</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">Coaching</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">KPI</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">360 Feedback</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">Pricing</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">Resources</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="#" class="nav-link">About</a></li>
		            <li class="nav-item py-md-2 mr-3"><a href="login.php" class="btn btn-outline-primary btn-block" role="button"><strong>Sign In</strong></a></li>
		        </ul>
		    </div>
		</div>
	</nav>

	<section class="d-none d-sm-block page-section bg-primary" style="padding-top: 80px; padding-bottom: 80px;">
	  <div class="container text-center">  
	    <h3 class="mb-4 text-white">Start using DoerHRM today</h3>
	    <div class="row justify-content-center">
	      <div class="col-7">
	        <h6 class="text-white mb-5">Improve the way your company sets goals and plans activities</h6>
	        <a class="btn btn-lg btn-block btn-light mb-4" href="craftgoalrename/freeregister.php" style="border-radius: 50px;">Get Started</a>
	        <p class="text-white"><small>Free for 5 users for 14 days. No credit card required.</small></p>
	      </div>
	    </div>
	  </div>
	</section>

<script type="text/javascript">
	$(document).ready(function(){
		//setTimeout(function(){$("#myModal").modal()}, 2000);
	  
	});
</script>
<div class="modal" id="myModal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="row">
		  		<div class="col" style="background: linear-gradient(rgba(255, 255, 255, 1), rgba(0, 0, 0, 0.45)),url(img/subscribe_banner.jpeg); background-repeat: no-repeat; ">
		  			<h5 class="text-white mt-5 p-5">Subscribe to receive a free eBook <b>One Strategy One Tool for 10X Growth</b> that contains 56 High Performance Strategies Execution with OKR that you can implement immediately. And, get 3 strategies weekly on how to be more productive, confident and happy.</h5>
		  		</div>
		  		<div class="col">
		  			<!-- Begin Mailchimp Signup Form -->
					<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
					<style type="text/css">
						#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
					</style>
					<div id="mc_embed_signup">
						<form action="https://hotmail.us19.list-manage.com/subscribe/post?u=f54691bfa6049c8d4d260e2b9&amp;id=e215fea4a9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						    <div id="mc_embed_signup_scroll">
								<div class="mc-field-group">
									<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
									<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
								</div>
								<div class="mc-field-group">
									<label for="mce-FNAME">First Name </label>
									<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
								</div>
								<div class="mc-field-group">
									<label for="mce-LNAME">Last Name </label>
									<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
								</div>
								<div class="mc-field-group size1of2">
									<label for="mce-BIRTHDAY-month">Birthday </label>
									<div class="datefield">
										<span class="subfield dayfield"><input class="birthday " type="text" pattern="[0-9]*" value="" placeholder="DD" size="2" maxlength="2" name="BIRTHDAY[day]" id="mce-BIRTHDAY-day"></span> / 
								        <span class="subfield monthfield"><input class="birthday " type="text" pattern="[0-9]*" value="" placeholder="MM" size="2" maxlength="2" name="BIRTHDAY[month]" id="mce-BIRTHDAY-month"></span> 
										<span class="small-meta nowrap">( dd / mm )</span>
									</div>
								</div>	
								<div id="mce-responses" class="clear">
									<div class="response" id="mce-error-response" style="display:none"></div>
									<div class="response" id="mce-success-response" style="display:none"></div>
								</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						    	<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_f54691bfa6049c8d4d260e2b9_e215fea4a9" tabindex="-1" value=""></div>
						    	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
						    </div>
						</form>
					</div>
					<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
					<script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[5]='BIRTHDAY';ftypes[5]='birthday';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
					<!--End mc_embed_signup-->
		  		</div>
		  	</div>
      </div>
    </div>
  </div>
</div>



<?php include '100okrlist.php';?>

<div class="container my-5">
	<div class="row">
		<div class="col-12 text-center border p-2 text-white" style="background-color: #6495ED;"><h4 class="m-2 font-weight-normal">FEATURES</h4></div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white"  style="background-color: #6495ED;">
			<h5>100+ OKR Samples</h5>
			Refer to other successful companies OKR to have ideas in implementing yours.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #00BFFF;">
			<h5>1-on-1 Coaching</h5>
			User & Coaches will have coaching sessions to help implement OKR in your company.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #6495ED;">
			<h5>Step-by-Step Video Guide</h5>
			DoerHRM provides you expert step video guide to help you starting in!
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #6495ED;">
			<h5>Performance Dashboard</h5>
			Visual progression to track your company’s goals.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #6495ED;">
			<h5>Result Tracker</h5>
			Boost performance with work transparency and encourages engagement.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #6495ED;">
			<h5>Align & Track</h5>
			Help your team to align everyone to remain on track with the company’s target.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #6495ED;">
			<h5>Team Calendar</h5>
			Keeps everyone productive by making plans and shares the progress.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #00BFFF;">
			<h5>Team Feedback</h5>
			Regular update feedbacks that craves for improvement on performance and empowerment.
		</div>
		<div class="col-12 col-lg-4 text-center border p-5 text-white" style="background-color: #6495ED;">
			<h5>Quick Customer Service</h5>
			You can contact our customer service if you’re feeling slow and confused.
		</div>
	</div>
</div>


<div class="container">
	<h3 class="text-center font-weight-normal my-5">What makes us different?</h3>

	<div class="row my-5">
		<div class="col-12 col-lg-6">
			<h5>High Performance OKR Working Framework</h5>
			<p>DoerHRM is a tool that allows you to scale and operationalize the OKR framework and it is really important because the <b>amount of effort and time saved driving result accountability</b> will be massive. Here’s a guarantee, it will <b>raise your organizations energy, urgency, learning and accountability</b>. It automatically allows leaders to lead from the front, to set clear directions and mobilize the organizations in a very fast way.</p>
		</div>
		<div class="col-12 col-lg-6">
			<img src="img/high-performance-okr-working-framework.png" width="100%">
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12 col-lg-6">
			<img src="img/modern-interacting.png" width="100%">
		</div>
		<div class="col-12 col-lg-6">
			<h5>Modern Interacting</h5>
			<p>Over the years, things has become more advanced and modernized. It had also changed the way we do our business. With DoerHRM, we are allowing you to let your business flow smoothly and continuously. With our OKR and modern interacting, it will be easier for you to make sure your business heighten.</p>
			<p>DoerHRM provides to you <b>Team Feedback that is very easy to provide comments and shows work transparency that could make the engagement with your colleagues faster</b>. Starting the weekly staff meetings by using the dashboard would keep your organization to keep focusing on what they are seeking out to be. Practicing OKR can help putting your business in a straight line.</p>
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12 col-lg-6">
			<h5>Day-to-Day Tracking</h5>
			<p>Doerhrm’s dashboard provides you the fulfilling informant of your business’s state whether it is healthy and thriving or not. It <b>highlights all the important information that you need to know to track where your company is at</b>. By the progress summaries and level reports, you are able to see your organizations progresses. This is said that OKR dashboard’s is a great design to track any progress performance from any departments. It comes along with excellent features to improve employees engagement and environment improvement.</p>
		</div>
		<div class="col-6 col-lg-3">
			<img src="img/day-to-day-tracking-1.png" width="100%">
		</div>
		<div class="col-6 col-lg-3">
			<img src="img/day-to-day-tracking-2.png" width="100%">
		</div>
	</div>

	<div class="row my-5">
		<div class="col-6 col-lg-3">
			<img src="img/daily-check-in-weekly-1-on-1-1.png" width="100%">
		</div>
		<div class="col-6 col-lg-3">
			<img src="img/daily-check-in-weekly-1-on-1-2.png" width="100%">
		</div>
		<div class="col-12 col-lg-6">
			<h5>Daily Check-in & Weekly 1-on-1</h5>
			<p>You can improve the employee performance by having meetings between employees and their managers so they could talk about their progress or plans for the day/week. <b>Managers would get a sense of where his team is heading and their progression, there he could realign his team to keep on track.</b></p>
			<p>1-on-1 meetings will be on a more effective side between the employees with their managers. By this method, managers could focus on their individual feedback’s and turn into solutions and actions. This is proven that by acknowledging everybody’s priorities it is able to have the transparency. There won’t be relying on meetings more but than having understandings by 1-on-1 conversations.</p>
		</div>
	</div>

	<div class="row my-5">
		<div class="col-12 col-lg-6">
			<h5>Alignment</h5>
			<p><b>It helps leaders to change his workplace to align everyone to remain on-track and in-sync with the company’s targets.</b> Alignments can help slower teams to catch up with their data by the rates provided by us to acknowledge where are they positioned. Here’s a guarantee that you would be able to see the acceleration of growth when you implemented OKR in your organization. The alignment and tracking will help you motivate the team to improve more.</p>
		</div>
		<div class="col-12 col-lg-6">
			<img src="img/alignment.png" width="100%">
		</div>
	</div>

</div>

<div class="container">
	<h3 class="text-center font-weight-normal my-5">Some of our fans</h3>
	<div class="row">
		<div class="col-12 col-lg-4 text-center">
			<p>I have been using DoerHRM for almost 6 months as my key performance monitoring and management tool. I set annual goals and also with monthly OKR, and <b>what I can see in myself is lots of rapid  improvement in my performance, particularly on skillsets, motivation as well as results. So, a big thank you to DoerHRM for helping me to help myself,</b> and with that I have got my confirmation of appointment by exceeding the quota.</p>

			<img src="img/ariff.jpg" width="100" height="100">
			<h5 class="font-weight-normal">Ariff</h5>
			Calibration Strategist of Obsnap Calibration
		</div>
		<div class="col-12 col-lg-4 text-center">
			<p>" <b>DoerHRM’s OKR has helped me to be able to track progress easily and learn what I’m good at and what I need to improve</b>. The function of “Doer Action” provides me the needed focus on what’s matter most to achieve my goals.</p>

			<img src="img/syafiq.jpg" width="100" height="100">
			<h5 class="font-weight-normal">Syafiq</h5>
			International Product Specialist of Victor Manufacturing
		</div>
		<div class="col-12 col-lg-4 text-center">
			<p>It is always a good idea for everyone to set annual goals, however, the challenge is how to ensure the performance of targeted key results and action plans are on track?</p>
			<p>Recently, <b>I started to implement OKR system from DoerHRM, and it has helped my sales team to be able to track the progress easily and tell whether are we on track precisely with percentage of completion ( % ).</b></p>
			<p>And I wish to mention two features that I like, it is the use of <b>Emoji 🙂 and traffic colour code to help make tracking messages more intuitive, personal and with emotion.</b> For example, A smiley and Green colour tell us that we’re on track.</p>

			<img src="img/joe.jpg" width="100" height="100"><br>
			<h5 class="font-weight-normal">Joe Yen</h5>
			Sales Director and Co-founder of JS Analytical
		</div>
	</div>
</div>

<?php include 'includes/footer.php';?>
