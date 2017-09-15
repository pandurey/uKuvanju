<div class="title">
	<h4>Navigacija</h4>
	<a href="" class='btn btn-add'>Dodaj link <i class='fa fa-link'></i></a>
</div>

<div class="pagination"><?php echo $this->pagination->create_links();?></div>
<div class="table">
	<?php 

		$this->table->set_heading( 'ID','Naziv', 'Link','Smešten ispod', 'Opcije');
		
		foreach ($nav as $i => $item):
			$data = array(
				'type' => 'hidden',
				'name' => 'hidden-'.$item->id_nav,
				'value'=> $item->id_nav
			);

			
			$this->table->add_roW(
				$item->id_nav." ". form_input($data),
				$item->naziv,
				$item->link,
				$item->id_parent,
				anchor('#', ' ', array('title' => 'Izmeni', 'class' => 'fa fa-pencil edit')).
				anchor('', ' ', array('title' => 'Obriši', 'class' => 'fa fa-eraser del'))
			);
		endforeach;

		echo $this->table->generate();
	?>

	
</div>

<div class="add" id='navigacija'>
	<div class="close"><a href="" class="btn-close fa fa-close"></a></div>
	<div class="form-wrap">
		<fieldset>
			<legend>Dodaj link</legend>
			
			<input type="text" class="tb" name="naziv" id="naziv" value="" placeholder="Ime za prikaz">
			<input type="text" class="tb" name="link" id="link" value="" placeholder="Link">
			<select id='id_parent'>
				<option value='0'>Smesti pod:</option>
				<?php foreach($nav_items as $item): ?>
				<option value='<?php echo $item->id_nav;?>'><?php echo $item->naziv;?></option>
				<?php endforeach;?>
			</select>
			<span class='checkbox'>
				<input type="checkbox" class='rb active' name="has-submenu" value="1" id="cb-has-submenu">
				<label for='cb-is-active' class=''>Ima podmeni</label>
			</span>
		</fieldset>
		<a href="" class='btn' id='add-nav'>Dodaj <i class='fa fa-plus'></i></a>
		<div class="message"></div>
	</div>
</div>