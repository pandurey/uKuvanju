<div class="recipe-browse">
	<div class="recipe-container">
		<div class="recipe-menu">
			<div class="recipe-search">
				<input type="text" class="tb" id='tb-recipe-search' placeholder='Pronađi recept' >
				

			</div>
			<div class="title">Recepti iz kategorije:</div>
			<div class="category menu-section">
				
				<!--span><input type="checkbox" name="recepti" id="cb1"><label for='cb1'>Ribe i morski plodovi</label></span-->
				<?php foreach($categories as $k):?>
					<span>
						<input type="radio" name="category" class='category' id="cb-<?php echo $k->id_kategorije;?>" value="<?php echo $k->naziv;?>" onChange="recipes_call(this);"><label for='cb-<?php echo $k->id_kategorije;?>'><?php echo $k->naziv;?></label>
					</span>
				<?php endforeach;?>
			</div>
			<div class="title">Sortiraj recepte po:</div>
			<div class="sort menu-section">		
				<span>
					<input type="radio" class='rb rbSort' name="sort" value="naziv" id="cbPoNazivu" onChange="recipes_call(this);" checked>
					<label for='cbPoNazivu' class='check'>Nazivu</label>
				</span>
				<span>
					<input type="radio" class='rb rbSort' name="sort" value="pregledi" id="cbPoPregledima" onChange="recipes_call(this);">
					<label for='cbPoPregledima'>Pregledima</label>
				</span>
				<span>
					<input type="radio" class='rb rbSort' name="sort" value="rating" id="cbPoOcenama" onChange="recipes_call(this);">
					<label for='cbPoOcenama'>Ocenama</label>
				</span>
				<span>
					<input type="radio" class='rb rbSort' name="sort" value="recepti_created" id="cbPoDatumu" onChange="recipes_call(this);">
					<label for='cbPoDatumu'>Datumu</label>
				</span>
			</div>
			<div class="title">Redosled prikaza:</div>
			<div class="order menu-section">
				<span><input type="radio" name="order" id="cbAsc"  value="ASC" onChange="recipes_call(this);" checked>
				<label for='cbAsc' class='check'>Rastući</label></span>
				<span><input type="radio" name="order" id="cbDesc" value="DESC" onChange="recipes_call(this);">
				<label for='cbDesc'>Opadajući</label></span>
			</div>
		</div>
		<div class="recipes-list">
			<div class="pagination"></div>
			<div class="recipes-result" id='recipes-result'>
				
			</div>
			
		</div>
	</div>
	<!-- jPages -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/jPages.js')?>"></script>
	<script type="text/javascript">
		

		$(function(){
			recipes_call();

			
		});

		


	</script>
</div>