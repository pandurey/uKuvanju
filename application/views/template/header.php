<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title;?></title>

	<!-- Slick slider -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/animate.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>">

	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

	<!-- jPages -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/jPages.js')?>"></script>
	
	
</head>
<body>
	<div class="preloader">
		<div class="preloader-img">
			<?php include("assets/img/logouk.svg"); ?>
		</div>
	</div>
	<div class="site-container">
		<div class="sidebar-wrap">	
			<div class="side-bar-l">
				<div class="title">MENI</div>
				<div class="close" title='Zatvori meni'>
					<a href="" class='fui-cross close-sidebar-l'></a>
				</div>
				<div class="nav">
					<nav>
						<ul>
					<?php foreach($parents as $p):?>
					<?php if($p->id_parent == 0):?>
						<li><a href="<?php echo base_url($p->link);?>"><?php echo $p->naziv;?></a>
						<?php if($p->has_submenu):?>
							<ul>
							<?php foreach($children as $c):?>
								<?php if($p->id_nav == $c->id_parent):?>
								<li><a href="<?php echo base_url($c->link);?>"><?php echo $c->naziv;?></a></li>
								<?php endif;?>
							<?php endforeach;?>
							</ul></li>
						<?php else:?>
						</li>
						<?php endif;?>
								
					<?php endif;?>
					<?php endforeach;?>
						</ul>
					</nav>
				</div>
				<div class="social-box">
					<a href="" class='fui-facebook'></a>
					<a href="" class='fui-twitter'></a>
					<a href="" class='fui-pinterest'></a>
					<a href="" class='fui-instagram'></a>
				</div>
				
			</div>
		</div>
		<div class="sidebar-wrap">	
			<?php if(isset($userMenu) && $userMenu): ?>
			<div class="side-bar-r active">
			<?php else:?>
			<div class="side-bar-r">
			<?php endif;?>	
				<div class="close" title='Zatvori meni'>
					<a href="" class='fui-cross close-sidebar-r'></a>
				</div>
				
				<div class="user-container">
					<?php if(!$logged):?>
					<div class="user-login user-tabs">
						<div class="tabs">
							<button class='btn tabs-names active' id='tab-sign-in' onclick='openTab("sign-in", "tab-sign-in")' title='Logovanje'><span class='fa fa-sign-in fa-lg'></span></button>
							<button class='btn tabs-names' id='tab-register' onclick='openTab("register", "tab-register")' title='Registracija'><span class='fa fa-plug fa-lg'></span></button>
						</div>
						<div class="logo">
							<img src="<?php echo base_url('assets/img/logo-s.png');?>" alt='uKuvanju logo' title="uKuvanju.com">
						</div>
					<?php if($regMsg != "" ):?>
						<div id="sign-in" class='tab'>
					<?php else: ?>
						<div id="sign-in" class='tab active'>
					<?php endif;?>
						<?php if($loginMsg != ""):?>
							<fieldset>
								<legend>Poruka:</legend>
								<div class="errors">
									<h5></h5>
									<?php if(isset($loginMsg['validation_err']) && $loginMsg['validation_err'] != ""){echo $loginMsg['validation_err'];}?>
									<?php if(isset($loginMsg['message']) && $loginMsg['message'] != ""){echo $loginMsg['message'];}?>		
								</div>
							</fieldset>
						<?php endif; ?>
						<?php echo form_open('auth/login');?>
							<fieldset>
								<legend>Prijava korisnika</legend>
								
								<input type="text" class="tb" name="tbEmail" id="tbEmail" value="<?php if(isset($loginMsg['email']))echo $loginMsg['email'];?>" placeholder="Email">
								<input type="password" class="tb" name="tbPassword" id="tbPassword" value="" placeholder="Lozinka">
								<button type='submit' class='btn' name='btnSubmit' id='btnSign'>Uloguj se</button>
								<?php echo form_close(); ?>
							</fieldset>
							
						</div>
					<?php if($regMsg != ""):?>
						<div id="register" class='tab active'>
						
					<?php else: ?>
						<div id="register" class='tab'>
					<?php endif;?>
						<?php if($regMsg  != ""):?>
							<fieldset>
								<legend>Poruka:</legend>
								<div class="errors">
									<h5></h5>
									<?php if(isset($regMsg['validation_err']) && $regMsg['validation_err'] != ""){echo $regMsg['validation_err'];}?>		
								</div>
							</fieldset>
						<?php endif; ?>
						<?php echo form_open('auth/register');?>
						<fieldset>
							<legend>Registracija korisnika</legend>
							<input type="text" class="tb <?php if(isset($regMsg['emailErr']) && $regMsg['emailErr'] != "") {echo 'err';} ?>" name="tbEmails" id="tbEmail" value="<?php if($regMsg != "")echo $regMsg['email'];?>"   placeholder="Email" style=''>
							<input type="text" class="tb <?php if(isset($regMsg['userErr']) && $regMsg['userErr'] != "") {echo 'err';} ?>" name="tbUsernames" id="tbUsername" value="<?php if($regMsg != "")echo $regMsg['username'];?>" placeholder="Korisničko ime">
							<input type="password" class="tb <?php if(isset($regMsg['passErr']) && $regMsg['passErr'] != "") {echo 'err';} ?>" name="tbPassword" id="tbPassword" value="" placeholder="Lozinka">
							<input type="password" class="tb <?php if(isset($regMsg['passConErr']) && $regMsg['passConErr'] != "") {echo 'err';} ?>" name="tbPasswordConfirm" id="tbPasswordConfirm" value="" placeholder="Potvrdi lozinku" >
							<button type='submit' class='btn' name='btnRegister' id='btnSign'>Registruj se</button>
						</fieldset>	
						<?php echo form_close(); ?>
						
						</div>
							
					</div>
					<?php else: ?>
					<div class="user-tabs user-box" id='user-box'>
						<div class="tabs">
							<button class='btn tabs-names active' id='btn-user-info' onclick='openTab("user-info", "btn-user-info")' title='Profil' >
								<span class='fa fa-user'></span>
							</button>
							<button class='btn tabs-names' id='btn-user-edit' onclick='openTab("user-edit", "btn-user-edit")' title='Korisnička podešavanja'>
								<span class='fa fa-cog'></span>
							</button>
							<a href='<?php echo base_url("auth/logout");?>' class='btn tabs-names' id='' title='Izloguj se'>
								<span class='fa fa-power-off'></span>
							</a>
						</div>
					<?php if($editMsg != "" ):?>
						<div class="tab" id="user-info">
					<?php else: ?>
						<div class="tab active" id="user-info">
					<?php endif;?>
							<div class="user-picture-box">
								<div class="user-img">
									<img src="<?php echo base_url().$userdata['img'];?>">
								</div>
							</div>
							<div class="username-box">
								<span><?php echo $userdata['username'];?></span>
							</div>
							<div class="search-box">
								<?php //echo form_open('recepti/pretraga');?>
								<span class="fa fa-search"></span>
								<input type="text" class="tb fa" name="tbSearch" id="user-search-tb" value="" placeholder="Pronađi recept...">
								<?php //echo form_close(); ?>
							</div>
							<div class="search-pagination"></div>
							<div class="search-result" id='search-result'>
								
							</div>
						</div>
					<?php if($editMsg != ""):?>
						<div class="tab active" id="user-edit">
						
					<?php else: ?>
						<div class="tab" id="user-edit">
					<?php endif;?>
						<?php ?>
						<?php if($editMsg != ""):?>
							<fieldset>
								<legend>Poruka:</legend>
								<div class="errors">
									<h5></h5>
									<?php if(isset($editMsg['validation_err']) && $editMsg['validation_err'] != ""){echo $editMsg['validation_err'];}?>
									<?php if(isset($editMsg['message']) && $editMsg['message'] != ""){echo $editMsg['message'];}?>

										
								</div>
								</fieldset>
						<?php endif; ?>
							<?php echo form_open_multipart('korisnik/edit');?>
							<fieldset>
								<legend>Izmeni profil</legend>
								<span>Email</span>
								<input type="text" class="tb" name="cngEmail" id="tbEmail" value="<?php echo $userdata['email'];?>" placeholder="<?php echo $userdata['email'];?>">
								<span>Ime za prikaz</span>
								<input type="text" class="tb" name="cngUsername" id="tbUsername" value="<?php echo $userdata['username'];?>"  placeholder="<?php echo $userdata['username'];?>">
								<span>Promeni lozinku</span>
								<input type="password" class="tb" name="cngPassword" id="cngPassword" placeholder="**********">
								<div class="passCon">
									<span>Potvrdi lozinku</span>
									<input type="password" class="tb" name="cngPasswordCon" id="tbPasswordCon" placeholder="**********">
								</div>
					
								<div class="user-picture-box">
									<div class="img-icon" style="background-image: url(<?php echo base_url().$userdata['img'];?>)">
										
									</div>
									<div class="fileUpload">
										<span>Promeni sliku</span>
	    								<input type="file" class="upload"  name='cngImg' onChange='selectUserImg(this);'/>
									</div>
								</div>
								<button type='submit' class='btn' name='btnChange' id='btnChange' title='Pronađi recept'>Izmeni profil</button>
							</fieldset>
							<?php echo form_close(); ?>
							
						</div>
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="top-bar">
			<div class="row">
				<div class="hamburger-menu top-icon">
					<a href="" class='open-sidebar-l' title="Otvori meni">
						<span class="fa fa-bars"></span>
					</a>
				</div>
				<div class="adminpanel top-icon" title='Admin'>
				<?php if($this->session->role == 'admin'): ?>
					<a href="<?php echo base_url('admin-panel/')?>" class=''>
						<span class='fa fa-lock'></span>
					</a>
				<?php endif;?>
				</div>
			
				<div class="logo">
					<a href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/img/logo-s.png');?>" alt='uKuvanju logo' title="uKuvanju.com"></a>
				</div>
				<div class="questionnaire-link top-icon" title='Anketa'>
					<a href="" class='open-questionnaire'>
						<span class='fa fa-pie-chart'></span>
					</a>
				
				</div>
				<div class="user-menu top-icon" title="Korisnički panel">
					<a href="" class='open-sidebar-r'>
					<?php if($logged):?>
						<span class="fa fa-cogs"></span>
					<?php else:?>
						<span class="fa fa-sign-in"></span>
					<?php endif;?>
					</a>
				</div>
			</div>
		</div>


		