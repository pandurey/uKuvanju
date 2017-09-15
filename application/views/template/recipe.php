		<div class="recipe-container">
			<div class="row">
				<div class="recipe">
					<div class="title"><span><?php echo $recipe->naziv;?></span></div>
					<div class="img">
						<img src="<?php echo base_url($recipe->img);?>" class='active-animation'>
					</div>
					<div class="title"><span>Sastojci</span></div>
					<div class="ingredients">
						<?php 
							 	$sastojak = explode(',', $recipe->sastojci);
							 	$n = sizeof($sastojak);

							 	for ($i=0; $i < $n ; $i++):
							 		echo "<span>".$sastojak[$i]."</span>";
							 	endfor;
						?>
					</div>
					<div class="title"><span>Priprema</span></div>
					<div class="preparation">
						<?php 
							$p = preg_split("/\\r\\n|\\r|\\n/", $recipe->priprema);
							$n = sizeof($p);
							
							for ($i=0; $i < $n ; $i++):

								echo "<p>".$p[$i]."</p>";
								
								if($i != ($n-1)):
									//separator posle nove linije
									echo "<span></span>";
								endif;
							endfor;
						?>	
					</div>
					<div class="info">
						<div class="stats">
							<div class="recipe-stats">
								<p>Pregleda: <span><?php echo $recipe->pregledi;?></span></p>
								<p>Korisnik: <a href="<?php echo base_url('korisnik/id/'.$recipe->id_user);?>"><?php echo $recipe->username;?></a></p>
							</div>
							<div class="likes">
							<?php if($voted || !$logged): ?>
								<a href='#' class="fa fa-minus voted" id='dislikes'></a>
								<span class="result">
									<?php 
										echo $recipe->likes - $recipe->dislikes;
									?>
								</span>
								<a href='' class="fa fa-plus voted" id='likes'></a>
							<?php else: ?>
								<a href='#' class="fa fa-minus" id='dislikes'></a>
								<span class="result">
									<?php 
										echo $recipe->likes - $recipe->dislikes;
									?>
								</span>
								<a href='' class="fa fa-plus" id='likes'></a>
							<?php endif; ?>
							</div>
						</div>

						<div class="social">
							
							<?php  ?>

						</div>
					</div>
				</div>
				<div class="side-links">
					<div class="title"><span>Recepti iz kategorije</span></div>
					<div class="links similar-recipes">
					<?php if(empty($recipes_similar)):?>
						<span class="no-data">Žao nam je, za sada nema više recepata!</span>
					<?php else: 
						foreach ($recipes_similar as $recipe ):?>
						<div class="recipe-box active-animation">
							<div class="img">
								<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>">
									<img src="<?php echo base_url($recipe->img_small)?>" alt="" class='active-animation'>
								</a>
							</div>
							
							<div class="recipe-title">
								<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>">
									<?php echo $recipe->naziv;?>	
								</a>
							</div>
							<div class="username">
								<?php echo $recipe->username;?>
							</div>
							<div class="views">
								<?php echo $recipe->pregledi;?> pregleda
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
					</div>
					<div class="title"><span>Recepti korisnika</span></div>
					<div class="links user-recipes">
					<?php if(empty($recipes_user)):?>
						<span class="no-data">Žao nam je, za sada nema više recepata!</span>
					<?php else: 
						foreach ($recipes_user as $recipe ):?>

						<div class="recipe-box ">
							<div class="img">
								<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>">
									<img src="<?php echo base_url($recipe->img_small)?>" alt="" class='active-animation'>
								</a>
							</div>
							
							<div class="recipe-title">
								<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>">
									<?php echo $recipe->naziv;?>	
								</a>
							</div>
							<div class="username">
								<?php echo $recipe->username;?>
							</div>
							<div class="views">
								<?php echo $recipe->pregledi;?> pregleda
							</div>
							
						</div>
						

						<?php endforeach; ?>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>