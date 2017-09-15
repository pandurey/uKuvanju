		<div class="header active-animation">
			<div class="row">
				<div class="slider">
					<div class="row">
						<div class="slider-container">
							<div>
								<img src="<?php echo base_url('assets/img/slider-1.jpg');?>" alt="">
							</div>
							<div>
								<img src="<?php echo base_url('assets/img/slider-2.jpg');?>" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="recipes">
			<div class="row">
				<div class="title"><span>NAJPOPULARNIJI RECEPTI</span></div>
				<div class="popular container">
					
				<?php foreach ($recipes_popular as $recipe):?>
					<div class="food-item-box-l active">
						<div class="food-text-block">
							<div class="category"><?php echo strtolower($recipe->naziv_kategorije);?></div>
							<div class="title">
								<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>"><?php echo $recipe->naziv_recepta;?></a>
							</div>
							<div class="uploader"><a href="<?php echo base_url('korisnik/id/'.$recipe->id_user);?>"><?php echo $recipe->username;?></a></div>
							
						</div>
						<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>">
							<div class="food-img bg-filter" style='background-image: url("<?php echo base_url().$recipe->img_small;?>")'>
								<span class='views'><span class='fa fa-eye'></span><?php echo $recipe->pregledi;?></span>
								<span class='likes'><?php echo $recipe->likes;?><span class='fa fa-thumbs-up'></span><span class='fa fa-thumbs-down'></span><?php echo $recipe->dislikes;?></span>
							</div>
						</a>
					</div>
				<?php endforeach;?>
				</div>
				<div class="title"><span>NAJNOVIJI RECEPTI</span></div>
				<div class="latest container">
					
				<?php if(!is_array($recipes_latest) || empty($recipes_latest)):?>
						
						<div class="no-data">
							<?php echo "Žao nam je, recepti trenutno nisu dostupni!"; ?>
						</div>
				<?php else:
					foreach ($recipes_latest as $recipe ):?>
					<?php //print_r($recipes_latest);?>

					<div class="food-item-box-s active">
						
						<div class="food-text-block">
							<div class="title">
								<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>"><?php echo $recipe->naziv;?></a>
							</div>
							<div class="details">
								<div class="views"><span class='fa fa-eye'></span><?php echo $recipe->pregledi;?></div>
								<div class="uploader"><a href='<?php echo base_url('korisnik/id/'.$recipe->id_user);?>'><?php echo $recipe->username;?></a></div>
							</div>
						</div>
						<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>">
							<div class="food-img bg-filter" style='background-image: url("<?php echo base_url($recipe->img_small);?>")'></div>
						</a>
					</div>
					<?php endforeach;?>
				<?php endif;?>
				</div>
			</div>
		</div>