<?php 

include('header.php');

if(isset($_POST['btn-login']))
{
	$login = trim($_POST['login']);
	$upass = trim($_POST['upass']);
	
	if($user_login->login($login,$upass))
	{
		$user_login->redirect('user/index.php');
	}
}


?>
	
 	
	<!-- INTRO BEGIN -->
	<header id="minimal-intro" class="intro-block bg-color-main" >
		<div class="ray ray-vertical y-100 x-50 ray-rotate-135 laser-blink hidden-sm hidden-xs" ></div>
		<div class="ray ray-vertical y-100 x-50 ray-rotate135 laser-blink hidden-sm hidden-xs" ></div>
		<div class="ray ray-vertical y-0 x-25 ray-rotate45 laser-blink hidden-sm hidden-xs" ></div>
		<div class="ray ray-vertical y-0 x-75 ray-rotate-45 laser-blink hidden-sm hidden-xs" ></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<img class="logo" src="./images/logo.png" alt="WCarPs" height="400" width="460" />
					<h1 class="slogan"><b>Wrong Car Parking Solution </b><br><span class="type"></span></h1>
					<!--<h2 class="slogan"><b><i>Wrong Car Parking Solution<br>Beware We Care.....</b></i><br><span class="type"></span></h1></h2>-->
					<!-- <p> -->
						<a class="download-btn-alt ios-btn" data-toggle="modal" data-target="#modalLogin">
							<i class="icon icon-user"></i>Login to <b>WCarPs</b>
						</a>
					<br>
					<a class="download-btn-alt android-btn" href="#">
						<i class="icon soc-icon-android"></i>Download for <b>Android</b>
					<a class="download-btn-alt ios-btn"data-toggle="modal" data-target="#modalIphone">
						<i class="icon soc-icon-apple"></i>Download for <b>Apple iOS</b>
					</a>
					
				</div>
			</div>
		</div>
		<div class="block-video-bg" data-stellar-ratio="0.4"></div>
	</header>
	<!-- INTRO END --> 
	
	
	
	<!-- FEATURES BEGIN -->
	<section id="features" class="img-block-3col">
		<div class="container">
			<div class="title">
				<h2>Brilliant Features</h2>
				<p>Here are several features of WCarPs</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<ul class="item-list-right item-list-big">
						<li class="wow fadeInLeft">
							<i class="icon icon-screen-desktop"></i>
							<h3>WCarPs Design</h3>
							<p>WCarPs looks great on any device. Content can be easily read and a user understands freely.</p>
						</li>
						<li class="wow fadeInLeft">
							<i class="icon icon-drop"></i>
							<h3>Color schemes</h3>
							<p>We use best color schemes to make WCarPs App Better.</p>
						</li>
						<li class="wow fadeInLeft">
							<i class="icon icon-doc"></i>
							<h3>FAQ Is Included </h3>
							<p>FAQ Helps to solve Basic Queries of the user to Use WCarPs App.</p>
						</li>
					</ul>
				</div>
				<div class="col-sm-4 col-sm-push-4">
					<ul class="item-list-left item-list-big">
						<li class="wow fadeInRight">
							<i class="icon icon-diamond"></i>
							<h3>Pure &amp; Simple</h3>
							<p>No fluff. Nothing should lead the visitor away from the main essence of website. There must be just important information.</p>
						</li>
						<li class="wow fadeInRight">
							<i class="icon icon-layers"></i>
							<h3>Documentation</h3>
							<p>The detailed documentation will help you in adjusting the WCarPs with little effort according to your requirements.</p>
						</li>
						<li class="wow fadeInRight">
							<i class="icon icon-basket-loaded"></i>
							<h3>Multiplatform</h3>
							<p>The WCarPs is adapted to the most of the popular platform in segment.</p>
						</li>
					</ul>
				</div>
				<div class="col-sm-4 col-sm-pull-4">
					<div class="animation-box wow bounceIn">
					 	<img class="highlight-left wow" src="images/light.png" height="192" width="48" alt="" />
						<img class="highlight-right wow" src="images/light.png" height="192" width="48" alt="" />
						<img class="screen" src="images/features_screen.png" alt="" height="581" width="300" />
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- FEATURES END --> 
	
	
	
	<!-- FEATURES BEGIN -->
	<section id="innovations" class="bg-color2">
		<div class="container">
			<div class="title">
				<h2>Touch the Innovations</h2>
				<p>In our work we try to use the most modern, convenient and interesting solutions.<br>We want that the WCarPs App which you download looks unique and appealing for a long time as it is possible. </p>
			</div>
			<img class="screen wow bounceInUp" src="images/innovation_screen.png" height="387" width="800" alt="" />
		</div>
		<div id="ray1" class="ray ray-horizontal"></div>
		<div id="ray2" class="ray ray-horizontal"></div>
		<div id="ray3" class="ray ray-horizontal"></div>
		<div id="ray4" class="ray ray-horizontal"></div>
	</section>
	<!-- FEATURES END -->
	
	
	<!-- BENEFITS1 BEGIN -->
	<section id="benefits1" class="img-block-2col">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="title">
						<h2>OUR Benefits</h2>
					</div>
					
					<ul class="item-list-left">
						<li>
							<i class="icon icon-picture color"></i>
							<h4 class="color">6 Types of Intro</h4>
							<p>Today Intro is a very important element of any App. 
It can be named even a face of the App.</p>
						</li>
						<li>
							<i class="icon icon-equalizer color"></i>
							<h4 class="color">Stunning flexibility</h4>
							<p>The given WCarPs App is armed with the number of settings, 
so you can easily adapt it according to you requirements.</p>
						</li>
						<li>
							<i class="icon icon-bar-chart color"></i>
							<h4 class="color">Step on the New Level</h4>
							<p>Innovative solutions and simple mathematically calculated 
design make it actual for a long time.</p>
						</li>
					</ul>
				</div>
				<div class="col-md-5 col-md-offset-1 col-sm-6">
					<div class="screen-couple-right wow fadeInRightBig">
						<div class="flare">
							<img class="base wow" src="images/flare_base.png" alt="" />
							<img class="shapes wow" src="images/flare_shapes.png" alt="" />
						</div>
						<img class="screen above" src="images/screen_couple_above.png" alt="" height="484" width="250" />
						<img class="screen beyond wow fadeInRight" data-wow-delay="0.5s" src="images/screen_couple_beyond.png" alt="" height="407" width="210" />
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- BENEFITS1 END -->
	
	
	
	
	<!-- BENEFITS2 BEGIN -->
	<section id="benefits2" class="img-block-2col bg-color2">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-push-6">
					<div class="title">
						<h2>The Heart</h2>
					</div>
					<p>So, what is the secret of successful Android App? First of all, it is its friendliness – both for the owner and for his or her future targeted audience. It is very important for us that the user could understand correctly the message  WCarPs trying to say to him or her. But, correct giving of the information is just a half of success.</p>
					<p>Emotions from WCarPs App in visitor are no less important ticket to success. Modern solutions, interesting elements, unique approach to details make WCarPs App recognizable and interesting. </p> 
				    <p>The Real Heart Of WCarPs App Is The Live Tracking Feature Of Your Vehicle, which Will Provide All The information Of Your Vehicle Route You Travelled.</p>
				</div>
				<div class="col-sm-6 col-sm-pull-6">
					<div class="screen-couple-left wow fadeInLeftBig">
						<div class="fog fog-top wow"></div>
						<div class="fog fog-bottom wow"></div>
						<img class="screen above" src="images/screen_couple_above_v2.png" alt="" height="484" width="250"/>
						<img class="screen beyond wow fadeInLeft" data-wow-delay="0.5s" src="images/screen_couple_beyond_v2.png" alt="" height="407" width="210" />
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- BENEFITS2 END --> 
	
	 <!-- VIDEO BEGIN -->
	<!--<section id="video">
		<div class="container">
			<div class="title">
				<h2>Iframe Video</h2>
				<p>In our work we try to use only the most modern, convenient and interesting solutions.</p>
			</div>
			<div class="video-container"> 
				<!-- Video iframe code here -->
			</div>
		</div>
	</section> 
	<!-- VIDEO END -->
	
	<!-- SCREENSHOTS BEGIN -->
	<section id="screenshots" class="bg-color2">
		<div class="container-fluid wow fadeIn">
			<h2>Screenshots</h2>
			<div id="screenshots-slider" class="owl-carousel">
				<a class="item" href="images/pics/01.png" title="WCarPs App Screen 1"><img src="images/pics/01.png" alt="screen1" width="250" height="480" /></a>
				<a class="item" href="images/pics/02.png" title="WCarPs App Screen 2"><img src="images/pics/02.png" alt="screen1" width="250" height="480"/></a>
				<a class="item" href="images/pics/03.png" title="WCarPs App Screen 3"><img src="images/pics/03.png" alt="screen1" width="250" height="480"/></a>
				<a class="item" href="images/pics/04.png" title="WCarPs App Screen 4"><img src="images/pics/04.png" alt="screen1" width="250" height="480"/></a>
				<a class="item" href="images/pics/05.png" title="WCarPs App Screen 5"><img src="images/pics/05.png" alt="screen1" width="250" height="480"/></a>
				<a class="item" href="images/pics/06.png" title="WCarPs App Screen 6"><img src="images/pics/06.png" alt="screen1" width="250" height="480"/></a>
				<a class="item" href="images/pics/07.png" title="WCarPs App Screen 7"><img src="images/pics/07.png" alt="screen1" width="250" height="480"/></a>
				<a class="item" href="images/pics/08.png" title="WCarPs App Screen 8"><img src="images/pics/08.png" alt="screen1" width="250" height="480"/></a>
			</div>
		</div>
	</section>
	<!-- SCREENSHOTS END -->
	
	
	
	<!-- FACTS BEGIN -->
	<section id="facts">
		<div class="container">
			<ul class="facts-list">
				<li class="wow bounceIn">
					<i class="icon icon-cloud-download"></i>
					<h3 class="wow">284</h3>
					<h4>Downloads</h4>
				</li>
				<li class="wow bounceIn" data-wow-delay="0.4s">
					<i class="icon icon-star"></i>
					<h3 class="wow">135</h3>
					<h4>Top Rates</h4>
				</li>
				<li class="wow bounceIn" data-wow-delay="0.8s">
					<i class="icon icon-like"></i>
					<h3 class="wow">77</h3>
					<h4>Likes</h4>
				</li>
				<li class="wow bounceIn" data-wow-delay="1.2s">
					<i class="icon icon-clock"></i>
					<h3 class="wow">741</h3>
					<h4>Hours Safe</h4>
				</li>
			</ul>
		</div>
	</section>
	<!-- FACTS END --> 
	
	<!-- PRICING TABLE BEGIN -->
	<section id="pricing-table" class="bg-color-grad">
		<div class="container">
			<div class="title">
				<h2>Price</h2>
				<p>We want the WCarPs App you download look unique and new for such a long time as it is possible. </p>
				<ul class="pricing-table">
					<li class="wow flipInY">
						<h3>Standard</h3>
						<span> Rs.10/- <small> Downloading</small> </span>
						<ul class="benefits-list">
						     <li>WCarPs App</li>
							 <li>WCarPs Website Login</li>
							<li>Vehicle Searching</li>
							<li>Theft Alert</li>
							<li class="not">Live Tracking (GPS Device)</li>
							
						</ul>
						<a href="#" class="buy"> <i class="icon icon-basket" ></i></a>
					</li> 
					<!--<li class="silver wow flipInY" data-wow-delay="0.2s">
						<h3>Sliver</h3>
						<span> $3.99 <small>per month</small> </span>
						<ul class="benefits-list">
							<li>Responsive</li>
							<li>Documentation</li>
							<li>Multiplatform</li>
							<li class="not">Video background</li>
							<li class="not">Support</li>
						</ul> 
						<a href="#" class="buy"> <i class="icon icon-basket" ></i></a>
					</li> -->
					<li class="gold wow flipInY" data-wow-delay="0.4s">
						<div class="stamp"><i class="icon icon-trophy"></i>Best choice</div>
						<h3>Gold</h3>
						<span> Coming Soon <small>Downloading</small> </span>
						<ul class="benefits-list">
							 <li>WCarPs App</li>
							 <li>WCarPs Website Login</li>
							<li>Vehicle Searching</li>
							<li>Theft Alert</li>
							<li>Live Tracking (GPS Device)</li>
						</ul>
						<a href="#" class="buy"> <i class="icon icon-basket" ></i></a>
					</li>
					<!--<li class="platinum wow flipInY" data-wow-delay="0.6s">
						<h3>Platinum</h3>
						<span> $12.99 <small>per month</small> </span>
						<ul class="benefits-list">
							<li>Responsive</li>
							<li>Documentation</li>
							<li>Multiplatform</li>
							<li>Video background</li>
							<li>Support</li>
						</ul> 
						<a href="#" class="buy"> <i class="icon icon-basket" ></i></a>-->
					</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- PRICING TABLE END --> 
	
	 <!-- TESTIMONIALS BEGIN -->
	<!-- <section id="testimonials" class="bg-color3">
		<div class="container-fluid">
			<h2>Why Do People Love Us</h2>
			<div id="testimonials-slider" class="owl-carousel">
				<div class="item container">
					<div class="talk">This is a great product. It reveals an individual approach to each customer. I liked the level of the provided service.</div>
					<img class="photo" src="images/customer_photo.jpg" alt="customer" />
					<div class="name">John Doe</div>
					<div class="ocupation">First customer</div>
				</div>	
				<div class="item container">
					<div class="talk">I always thought that people used to pay much for quality. But these guys changed my opinion. The quality exceeds the price many times. I recommend it to everybody.</div>
					<img class="photo" src="images/customer_photo.jpg" alt="customer" />
					<div class="name">John Doe</div>
					<div class="ocupation">First customer</div>
				</div>
				<div class="item container">
					<div class="talk">My colleague recommended them to me. I hesitated for a long time, but than I tried and understood what I had paid off for.</div>
					<img class="photo" src="images/customer_photo.jpg" alt="customer" />
					<div class="name">John Doe</div>
					<div class="ocupation">First customer</div>
				</div>
				<div class="item container">
					<div class="talk">It’s just five stars. I will certainly come back and bring my friends with me.</div>
					<img class="photo" src="images/customer_photo.jpg" alt="customer" />
					<div class="name">John Doe</div>
					<div class="ocupation">First customer</div>
				</div>
			</div>
		</div> -->
		<div class="block-bg"></div>
	</section>
	<!-- TESTIMONIALS END --> 
	
	
	<!-- NEWS BEGIN -->
	<!-- <section id="news">
		<div class="container-fluid">
			<div class="title">
				<h2>App's News</h2>
				<p>Here you can find all interesting facts about this app:<br>the last updates, sales, latest things and the developers’ stories.</p>
			</div>
			<ul class="news-list">
				<li class="wow fadeInUp">
					<h3><a href="single.html">Look for the latest update in coming days.</a></h3>
					<div class="news-info">
						<div class="author"><i class="icon icon-user"></i>John Doe</div>
						<div class="date"><i class="icon icon-clock"></i>16.07.2014</div>
						<div class="comments"><i class="icon icon-bubble"></i>7 Comments</div>
					</div>
				</li>
				<li class="wow fadeInUp">
					<h3><a href="single-no-sidebar.html">The meeting of developers of cross-platform apps.</a></h3>
					<div class="news-info">
						<div class="author"><i class="icon icon-user"></i>John Doe</div>
						<div class="date"><i class="icon icon-clock"></i>16.07.2014</div>
						<div class="comments"><i class="icon icon-bubble"></i>7 Comments</div>
					</div>
				</li>
				<li class="wow fadeInUp">
					<h3><a href="single.html">The new functional sketches.</a></h3>
					<div class="news-info">
						<div class="author"><i class="icon icon-user"></i>John Doe</div>
						<div class="date"><i class="icon icon-clock"></i>16.07.2014</div>
						<div class="comments"><i class="icon icon-bubble"></i>7 Comments</div>
					</div>
				</li>
				<li class="wow fadeInUp">
					<h3><a href="single-no-sidebar.html">Resolving the issue with synchronization in old version.</a></h3>
					<div class="news-info">
						<div class="author"><i class="icon icon-user"></i>John Doe</div>
						<div class="date"><i class="icon icon-clock"></i>16.07.2014</div>
						<div class="comments"><i class="icon icon-bubble"></i>7 Comments</div>
					</div>
				</li>
			</ul>
			<a href="blog.html" class="round-btn wow fadeInUp">Older news</a>
		</div>
	</section> -->
	<!-- NEWS END -->
	
	
	<!-- SOCIAL BEGIN -->
	<section id="social" class="bg-color2">
		<div class="container-fluid">
			<div class="title">
				<h2>Stay tuned</h2>
				<p>Follow us in social networks. You can also subscribe for our news. <br>We are going to provide you with actual and important for you information without spam or fluff.</p>
			</div>
			
			<ul class="soc-list wow flipInX">
				<li><a href="https://twitter.com/WCarPs1" target="_blank"><i class="icon soc-icon-twitter"></i></a></li>
				<li><a href="https://www.facebook.com/WCarPs" target="_blank"><i class="icon soc-icon-facebook"></i></a></li>
				<li><a href="https://plus.google.com/116739372649153844041/posts?gmbpt=true&hl=en" target="_blank"><i class="icon soc-icon-googleplus"></i></a></li>
				<li><a href="https://www.linkedin.com/in/wrong-car-parking-solution-4bb44a11b?trk=" target="_blank"><i class="icon soc-icon-linkedin"></i></a></li>
				<li><a href="https://www.instagram.com/wrongcarparkingsolution/" target="_blank"><i class="icon soc-icon-instagram"></i></a></li>
			</ul>
			
			
			<form action="scripts/subscribe.php" method="post" id="subscribe_form">
            	<div class="input-group">
                	<input class="form-control" type="email" name="email" id="subscribe_email" placeholder="Subscribe">
                    <div class="input-group-btn">
                    	<button type="submit" id="subscribe_submit" data-loading-text="&bull;&bull;&bull;"><i class="icon icon-paper-plane"></i></button>
                    </div>
                </div>
            </form>
			
		</div>
	</section>
	<!-- SOCIAL END -->
	
	
	<!-- DOWNLOAD BEGIN -->
	<section id="download" class="bg-color-main">
		<div class="container-fluid wow fadeInDown">
			<a href="#wrap" class="goto">
				<h2><i class="icon soc-icon-apple"></i><i class="icon soc-icon-android"></i>Download App</h2>
			</a>
		</div>
		<div class="block-bg" data-stellar-ratio="0.5"></div>
	</section>
	<!-- DOWNLOAD END -->
	
	
	





	
<?php include('footer.php') ?>