<html lang="en"><head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta charset="utf-8">
		<title>Dealer Factoring</title>

		<meta name="description" content="User login page">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">


		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?=base_url('public/css/login/bootstrap.css');?>">
		<link rel="stylesheet" href="<?=base_url('public/css/login/font-awesome.css');?>">

		<!-- text fonts -->
		<link rel="stylesheet" href="<?=base_url('public/css/login/ace-fonts.css');?>">

		<!-- ace styles -->
		<link rel="stylesheet" href="<?=base_url('public/css/login/ace.css');?>">

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?=base_url();?>assets/css/ace-part2.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?=base_url('public/css/login/ace-rtl.css');?>">
				<link rel="stylesheet" href="<?=base_url('public/css/login/animate.css');?>">
		<script src='<?=base_url("public/js/login/jquery.js");?>'></script>
		<!-- <!-- <script src='<?=base_url("public/js/login/login.js");?>'></script> -->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?=base_url();?>assets/css/ace-ie.css" />
		<![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?=base_url();?>assets/js/html5shiv.js"></script>
		<script src="<?=base_url();?>assets/js/respond.js"></script>
		<![endif]-->


		<script type="text/javascript">
			$(function(){
				$("#logo_login").addClass('animated pulse infinite');
			});
		</script>


	</head>


	<body class="login-layout light-login" style="background-color: rgba(255, 255, 255, 0) !important;">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">

							<div class="space-6"></div>

							<div class="space-6"></div>
							<div class="space-6"></div>
												<div class="space-6"></div>
							<div class="space-6"></div>					<div class="space-6"></div>
							<div class="space-6"></div>
							<div class="space-6"></div>
							<div class="center">
								<img class='img-responsive center-block' id='logo_login' src="<?=base_url('public/images/dealer.png');?>">
							</div>

							<div class="space-6"></div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header gray lighter bigger center">
												Sistema Factoring</h4>

											<div class="space-6"></div>

											<form id="login" action="<?=base_url('login');?>" method='POST'>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name='email' class="form-control" placeholder="Email">
															<!-- <i class="ace-icon fa fa-user"></i> -->
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name='senha' class="form-control" placeholder="Senha">
															<!-- <i class="ace-icon fa fa-lock"></i> -->
														</span>
													</label>

													<div class='center'><?if(!empty($erro)){echo $erro;};?></div>

													<div class="space"></div>

													<div class="clearfix">
														
														<!-- <label class="inline">
															<a href='http://www.ingles200h.com/esqueci-a-senha/'>Esqueceu sua senha?</a>
														</label>
 -->
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary" style='background-color: #1A1A1A !important; border: 0px;'>
															<span class="bigger-110">Entrar</span>
														</button>
													</div>

													<div class="space-4">
														
													</div>
													<div id="erroResult" hidden class='alert alert-danger'>
														
													</div>
												</fieldset>
											</form>

											

											<div class="space-6"></div>

											
										</div><!-- /.widget-main -->

										
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email">
												
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>
													
													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New User Registration
											</h4>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email">
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username">
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password">
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Repeat password">
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<label class="block">
														<input type="checkbox" class="ace">
														<span class="lbl">
															I accept the
															<a href="#">User Agreement</a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>

														<button type="button" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Register</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Back to login
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->

							
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?=base_url();?>assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->

	

</body></html>