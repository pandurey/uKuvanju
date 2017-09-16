<?php if(isset($users)):?>
	<div class="title">
		<h4>Korisnici</h4>
		<a href="" class='btn btn-add' title='Dodaj korisnika'>Dodaj korisnika <i class='fa fa-user-plus'></i></a>
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
					anchor(base_url('admin-panel/korisnici/edit/'.$user->id), ' ', array('title' => 'Izmeni', 'class' => 'fa fa-pencil edit')).
					anchor('', ' ', array('title' => 'Obriši', 'class' => 'fa fa-eraser del'))
				);
			endforeach;

			echo $this->table->generate();
		?>
<?php else: ?>
	<div class="title">
		<h4>Korisnici</h4>
		<a href="" class='btn btn-add' title='Dodaj korisnika'><i class='fa fa-user-plus'></i></a>
	</div>
	<div class="edit-item">
		<fieldset>
			<?php echo form_open_multipart('admin-panel/korisnici/korisnik');?>
			<legend>Izmeni korisnika</legend>
			<?php
				$data = array(
					'type' => 'hidden',
					'name' => 'user_id',
					'value'=> $user->id
				);
				echo form_input($data);
			?>

			<input type="text" class="tb" name="editusername" id="editUsername" value="<?php echo $user->username;?>"  placeholder="Korisničko ime" style=''>
			<input type="text" class="tb" name="editemail" id="editEmail" value="<?php echo $user->email;?>"  placeholder="Email" style=''>
			<input type="text" class="tb" name="editpassword" id="editPassword" value=""  placeholder="Lozinka" style=''>
			<div class="user-picture-box">
				<div class="img-icon" style="background-image: url(<?php echo base_url().$user->picture_url;?>)">
					
				</div>
				<div class="fileUpload">
					<span>Promeni sliku</span>
					<input type="file" class="upload"  name='editImg' onChange='selectUserImg(this);'/>
				</div>
			</div>
			<span class='checkbox' id='edit-cb-active'>
				<input type="checkbox" class='rb active' name="editactive" value="1" id="cbactive">
				<label for='cbactive' class='<?php if($user->active_status == 1 ) echo 'check';?>' id='lbCheck-active'>Aktivan</label>
			</span>
			<span class='checkbox' id='edit-cb-admin'>
				<input type="checkbox" class='rb' name="editadmin" value="1" id="cbadmin">
				<label for='cbadmin' class='<?php if($user->id_uloge == 1 ) echo 'check';?>' id='lbCheck-admin'>Admin</label>
			</span>
			<button class='btn' type='submit' name='potvrdiIzmene' id='potvrdiIzmene'>Potvrdi izmene</button>
			<?php echo form_close(); ?>
		</fieldset>

		<?php
			if(isset($error)){
				print_r( $error);
			}
		?>
	</div>
<?php endif; ?>	
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