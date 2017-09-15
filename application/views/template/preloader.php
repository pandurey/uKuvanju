<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>uKuvanju.com <?php echo " | ".$title;?></title>

	<!-- Slick slider -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>">

	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	
	
</head>
<body>
	<div class="preloader">
		<div class="preloader-img">
			<?php include("assets/img/logouk.svg"); ?>
		</div>
	</div>
	<div class="site-container">

		<div class="side-bar-l">
			<div class="title">MENI</div>
			<div class="close" title='Zatvori meni'>
				<a href="" class='fui-cross close-sidebar-l'></a>
			</div>
			
			<div class="nav">
				<nav>
					<ul>
						<li><a href="<?php echo base_url();?>">POČETNA</a></li>
						<li><a href="<?php echo base_url('recepti/');?>">RECEPTI</a>
							<ul>
							<?php foreach ($categories as $category):?>
								<li><a href="<?php echo base_url('recepti/kategorije/'.$category->id_kategorije); ?>"><?php echo strtolower($category->naziv); ?></a></li>
							<?php endforeach;?>
							</ul>
						</li>
						<li><a href="">O AUTORU</a></li>
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
					<div id="sign-in" class='tab'>
					<?php echo form_open('auth/login');?>
					<fieldset>
						<legend>Prijava korisnika</legend>
						<input type="text" class="tb" name="tbEmail" id="tbEmail" value="" placeholder="Email">
						<input type="password" class="tb" name="tbPassword" id="tbPassword" value="" placeholder="Lozinka">
						<button type='submit' class='btn' name='btnSubmit' id='btnSign'>Uloguj se</button>
						<?php echo form_close(); ?>
					</fieldset>
						<div class="errors">
							<?php if(isset($error)){echo $error;}?>		
						</div>
					</div>
					<div id="register" class='tab'>
					<?php echo form_open('auth/register');?>
					<fieldset>
						<legend>Registracija korisnika</legend>
						<input type="text" class="tb" name="tbEmails" id="tbEmail" value="" placeholder="Email">
						<input type="text" class="tb" name="tbUsername" id="tbUsername" value="" placeholder="Korisničko ime">
						<input type="password" class="tb" name="tbPassword" id="tbPassword" value="" placeholder="Lozinka">
						<input type="password" class="tb" name="tbPasswordConfirm" id="tbPasswordConfirm" value="" placeholder="Potvrdi lozinku">
						<button type='submit' class='btn' name='btnRegister' id='btnSign'>Registruj se</button>
					</fieldset>	
					<?php echo form_close(); ?>
					<div class="errors">
						<?php if(isset($error)){echo $error;}?>		
					</div>
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
					<div class="tab" id="user-info">
						<div class="user-picture-box">
							<div class="user-img">
								<img src="<?php echo base_url().$userdata['img'];?>">
							</div>
						</div>
						<div class="username-box">
							<span><?php echo $userdata['username'];?></span>
						</div>
						<div class="search-box">
							<?php echo form_open('recepti/pretraga');?>
							<input type="text" class="tb" name="tbSearch" id="tbSearch" value="" placeholder="Pronađi recept..." >
							<button type='submit' class='btn' name='btnSearch' id='btnSearch' title='Pronađi recept'>
								<span class="fa fa-search"></span>
							</button>
							<?php echo form_close(); ?>
						</div>
					</div>
					<div class="tab" id="user-edit">
						
						<?php echo form_open('korisnik/edit');?>
						<fieldset>
							<legend>Izmeni profil</legend>
							<input type="text" class="tb" name="tbEmail" id="tbEmail" value="<?php echo $userdata['email'];?>" placeholder="Email">
							<input type="text" class="tb" name="tbUsername" id="tbUsername" value="<?php echo $userdata['username'];?>" placeholder="Korisničko ime">
							<input type="password" class="tb" name="tbPassword" id="tbPassword" value="" placeholder="Lozinka">
							<div class="user-picture-box">
								<div class="img-icon">
									<span class='fa fa-picture-o'></span>
								</div>
								<div class="fileUpload">
									<span>Promeni sliku</span>
    								<input type="file" class="upload" />
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
		<div class="top-bar">
			<div class="row">
				<div class="hamburger-menu top-icon">
					<a href="" class='open-sidebar-l' title="Otvori meni">
						<span class="fa fa-bars"></span>
					</a>
				</div>
				<div class="logo">
					<a href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/img/logo-s.png');?>" alt='uKuvanju logo' title="uKuvanju.com"></a>
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


		