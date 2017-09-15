<div class="user-wrap">
	<div class="user-info">
		<div class="user-bg">
				<?php //include("assets/img/userbg.svg"); ?>
		</div>
		<div class="user-img">
			<a href="<?php echo base_url($recipes[0]->picture_url);?>" class='magnific-Popup' data-effect="mfp-zoom-in">
				<img src="<?php echo base_url($recipes[0]->picture_url);?>" class='active-animation'>
			</a>
		</div>
		<div class="user-text">
			<h1><?php echo $recipes[0]->username;?></h1>
			
			<span class='date-joined'>Korisnik od: <?php echo  $userjoined->joined;?></span>

		</div>
		
	</div>
	<div class="title"><span>RECEPTI KORISNIKA</span> </div>
	<div class="user-recipes-wrap">
		<?php foreach($recipes as $recipe):?>
				<div class="recipe-wrap active-animation bg-filter">
					<div class="recipe-img">
						<img src="<?php echo base_url($recipe->img_small)?>"/ >
					</div>
					<div class="recipe-info">
						<div class="name">
							<a href="<?php echo base_url('recepti/id/'.$recipe->id);?>"><?php echo $recipe->naziv_recepta?></a>
						</div>
						<div class="views"><?php echo $recipe->pregledi;?> <span class='fa fa-eye'></span></div>
						
						
						<div class="category">Deserti</div>
						<div class="rating">
							<?php echo $recipe->likes;?><span class='fa fa-thumbs-up'></span><span class='fa fa-thumbs-down'></span><?php echo $recipe->dislikes;?>
						</div>
						
					</div>
				</div>
				<?php endforeach;?>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.magnific-Popup').magnificPopup({
				type:'image',
				removalDelay: 500, //delay removal by X to allow out-animation
  				callbacks: {
				    beforeOpen: function() {
				      // just a hack that adds mfp-anim class to markup 
				       this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
				       this.st.mainClass = this.st.el.attr('data-effect');
				    }
				  },
			  closeOnContentClick: true,
			  midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
			});
		})
	</script>
</div>