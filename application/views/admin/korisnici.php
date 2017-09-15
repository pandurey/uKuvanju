<div class="title">
	<h4>Korisnici</h4>
	<a href="" class='btn btn-add'>Dodaj korisnika <i class='fa fa-user-plus'></i></a>
</div>

<div class="pagination"><?php echo $this->pagination->create_links();?></div>
<div class="table">
	<?php 

		$this->table->set_heading('ID','Korisničko ime', 'Email', 'Registrovan', 'Poslednja izmena', 'Aktivan', 'Opcije');
		
		foreach ($users as $i => $user):
			$data = array(
				'type' => 'hidden',
				'name' => 'hidden-'.$user->id,
				'value'=> $user->id
			);
			$this->table->add_roW(
				$user->id." ". form_input($data),
				$user->username, 
				$user->email, 
				date_format( date_create($user->created), 'd.m.Y h:m:s'), 
				$user->modified, 
				$this->admin->write_active_status($user->active_status), 
				anchor('', ' ', array('title' => 'Izmeni', 'class' => 'fa fa-pencil edit')).
				anchor('', ' ', array('title' => 'Obriši', 'class' => 'fa fa-eraser del'))
			);
		endforeach;

		echo $this->table->generate();
	?>

	
</div>

<div class="add" id='korisnici'>
	<div class="close"><a href="" class="btn-close fa fa-close"></a></div>
	<div class="form-wrap">
		<fieldset>
			<legend>Dodaj korisnika</legend>
			
			<input type="text" class="tb" name="email" id="email" value="" placeholder="Email">
			<input type="text" class="tb" name="username" id="username" value="" placeholder="Korisničko ime">
			<input type="password" class="tb" name="password" id="password" value="" placeholder="Lozinka">
			<span class='checkbox'>
				<input type="checkbox" class='rb active' name="is-active" value="1" id="cb-is-active">
				<label for='cb-is-active' class=''>Aktivan</label>
			</span>
			<span class='checkbox'>
				<input type="checkbox" class='rb admin' name="is-admin" value="1" id="cb-is-admin">
				<label for='cb-is-admin' class=''>Admin</label>
			</span>
		</fieldset>
		<a href="" class='btn' id='add-user'>Dodaj <i class='fa fa-user-plus'></i></a>
		<div class="message"></div>
	</div>
</div>