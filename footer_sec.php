<!-- FOOTER BEGIN -->
	<footer id="footer">
		<div class="container"> 
			<a href="index.html#wrap" class="logo goto"> <img src="./images/logo_small.png" alt="WCarPs" height="200" width="220"/> </a>
			<p class="copyright">&copy; 2016 WCarPs <br>
			Designed by <a href="http://mcssan.WCarPs.com/" target="_blank">MCSSAN</a></p>
		</div>
	</footer>
	<!-- FOOTER END --> 
	
</div>


<!-- MODALS BEGIN--> 

<!-- subscribe modal-->
<div class="modal fade" id="modalMessage" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title"></h3>
		</div>
	</div>
</div>

<!-- contact modal-->
<div class="modal fade" id="modalContact" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title">Contact</h3>
			<form action="scripts/contact.php" role="form"  id="contact_form">
						<div class="form-group">
							<input type="text" class="form-control" id="contact_name" placeholder="Full name" name="name">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" id="contact_email" placeholder="Email Address" name="email">
						</div>
						<div class="form-group">
							<textarea class="form-control" rows="3" placeholder="Your message or question" id="contact_message" name="message"></textarea>
						</div>
						<button type="submit" id="contact_submit" name="contact_btn" data-loading-text="&bull;&bull;&bull;"> <i class="icon icon-paper-plane"></i></button>
					</form>
		</div>
	</div>
</div>

<!-- MODALS END-->

<!-- SignIN Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<h3 class="white">Sign In</h3>
				<hr>
				<form action="" class="popup-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="form-group">
					<input type="text" class="form-control form-white" name="login" placeholder="Email Or Phone">
					</div>
					<hr>
					<div class="form-group">
					<input type="password" class="form-control form-white" name="upass" placeholder="Password">
					</div>
					<hr>
					<button type="submit" id="contact_submit" class="btn btn-submit" name="btn-login"><i class="icon icon-paper-plane"></i></button>
				</form>
			</div>
		</div>
	</div>
	<!-- Signin MODALS END-->


	<!-- Soon Modal -->
<div class="modal fade" id="modalIphone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<h3 class="white"><b>WCarPs Apple iOS</b> </h3>
				<br>
				<h4><b>Coming Soon....</b></h4>
				<br>
				<h4><b>Thanks</b></h4>
			</div>
		</div>
	</div>
	<!-- MODALS END-->


<!-- JavaScript --> 
<script src="scripts/jquery-1.8.2.min.js"></script> 
<script src="scripts/bootstrap.min.js"></script> 
<script src="scripts/owl.carousel.min.js"></script> 
<script src="scripts/jquery.validate.min.js"></script> 
<script src="scripts/wow.min.js"></script> 
<script src="scripts/smoothscroll.js"></script> 
<script src="scripts/jquery.smooth-scroll.min.js"></script> 
<script src="scripts/jquery.superslides.min.js"></script>
<script src="scripts/placeholders.jquery.min.js"></script>
<script src="scripts/jquery.magnific-popup.min.js"></script>
<script src="scripts/jquery.stellar.min.js"></script>
<script src="scripts/retina.min.js"></script>
<script src="scripts/video.js"></script>
<script src="scripts/typed.js"></script> 
<script src="scripts/bigvideo.js"></script>
<script src="scripts/custom.js"></script> 

<!--[if lte IE 9]>
	<script src="scripts/respond.min.js"></script>
<![endif]-->
</body>
</html>
