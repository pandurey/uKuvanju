<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin panel | uKuvanju.com</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>">

	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</head>
<body>
	<div class="admin-wrap">
		<?php if(isset($this->session->alert) && $this->session->alert != ""): ?>
		<div class="message-alert"><?php echo $this->session->alert;?></div>
		<?php endif;?>
		<div class="admin-menu">
			<img src="<?php echo base_url('assets/img/logo-s.png');?>">
			<ul>
				<li><a href="<?php echo base_url();?>"><i class='fa fa-home'></i> uKuvanju.com</a></li>
				<li><a href='<?php echo base_url("admin-panel/korisnici");?>'><i class='fa fa-users'></i> Korisnici</a></li>
				<li><a href="<?php echo base_url("admin-panel/navigacija");?>"><i class='fa fa-th-list'></i> Navigacija</a></li>
				<li><a href="<?php echo base_url("admin-panel/ankete");?>"><i class='fa fa-pie-chart'></i> Ankete</a></li>
				<li><a href="<?php echo base_url("admin-panel/recepti");?>"><i class='fa fa-cutlery'></i> Recepti</a></li>
				<li><a href="<?php echo base_url("admin-panel/kategorije");?>"><i class='fa fa-list-alt'></i> Kategorije</a></li>
			</ul>
		</div>
		<div class="admin-content">
	