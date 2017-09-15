	<div class="footer">
		<div class="row">

			<div class="logo">
				<div class="row">
					<div class="logo-img">
						<img src="<?php echo base_url('assets/img/logo-m.png')?>" alt='uKuvanju logo' title="uKuvanju.com">
					</div>
				</div>
			</div>
			<div class="links-wrap">
				<div class="links" id='main-links'>
					<ul>
						<li><a href="<?php echo base_url();?>">Početna</a></li>
						<li><a href="<?php echo base_url('recepti/');?>">Recepti</a></li>
						<li><a href="">O autoru</a></li>
					</ul>
				</div>
				<div class="links" id='category-links'>
					<ul>
					<?php //foreach ($categories as $category):?>
						<li><a href="<?php //echo base_url('recepti/'); ?>"><?php //echo $category->naziv; ?></a></li>
					<?php //endforeach;?>
					</ul>
				</div>
			</div>
			<div class="designed">Designed by Marko Bogdanović &copy 2017</div>
		</div>
	</div>
	
	<div class="questionnaire">

		<div class="wrap">
			<div class="close-questionnaire" title='Zatvori anketu'>
				<a href="" class='fui-cross close-sidebar-l'></a>
			</div>
			
			<input type="hidden" name="id_question" value='<?php echo $question->id_anketa;?>'>
			<p>Odvojite trenutak za anketu:</p>
			<span class='question'><?php echo $question->pitanje;?></span>
			<div class="questions">
				<?php if(!$voted):?>
					<?php $i = 0;?>
					<?php foreach($options as $i => $option): ?>

						<span>
							<input type="radio" name="rbQuestionnaire" class='rb' id='rb-<?php echo $i+1;?>' value='<?php echo $option->id_opcija;?>'>
							<label for='rb-<?php echo $i+1;?>'> <?php echo $option->opcija;?></label>
						</span>
					<?php endforeach;?>
					
					<?php if($logged):?>
						<button class='btn' id='quest-btn'>Glasaj</button>
					<?php else: ?>
						<p>Morate biti ulogovani da biste glasali</p>
					<?php endif; ?>
				<?php else: ?>
					<p>Rezultati:</p>
					<?php for($i=0; $i < (count($quest_results)-1); $i++):?>
						<?php $votes = $quest_results[$i]['votes'] /  $quest_results['total'] * 100; ?>
					<div class="results">
						<div class="result-percent">
							<div class="percent-width" style='width: <?php echo $votes?>%'></div>
							<span><?php print $quest_results[$i]['option'];?></span>
						</div>
					</div>
					<?php endfor;?>
					
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
	<!-- Slick.js  -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/slick.js')?>"></script>
	
	<!-- Magnific pop-up-->
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/magnific_popup/jquery.magnific-popup.min.js')?>"></script>
	
	<!-- Javacript -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/ajax.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/javascript.js');?>"></script>
	
</body>
</html>