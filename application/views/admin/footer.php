	</div> <!-- admin-content -->
</div> <!-- admin-wrap -->
<script type="text/javascript">
		$(function(){
			

			//promena boje inputa
			$('.tb').on('blur', function(){
				changeBorderColor(this);
			});

			
			//checkbox check/uncheck
			$('.checkbox label').on('click', function(e){
				if($(this).hasClass('check')){$(this).removeClass('check');}
				else{ $(this).addClass('check');}
			});
			//close add div
			$('.btn-close').click(function(e){
				e.preventDefault();
				
				$('.add').removeClass('active');
			})
			//alert
			setTimeout(function(){
				$('.message-alert').fadeOut(500);
			}, 500)
			//brisanje
			$('.del').click(function(e){
				e.preventDefault();

				var id = $(this).closest('tr').find('td').find('input')[0].value;
				var tabela = $('.title h4').text();
				console.log(tabela);
				brisi(tabela.toLowerCase(), id);
			});
			//izmena
			$('.edit').click(function(e){
				e.preventDefault();

				//var id = $(this).closest('tr').find('td').find('input')[0].value;
				var niz = new Array();
				var td = $(this).closest('tr').find('td').each(function(i, v){
					console.log( i + ": " + $(this).text() );
					niz[i] = i
				});
				
				
			});
			//dodavanje
			$('.btn-add').click(function(e){
				e.preventDefault();

				var id = $(this).closest('.title').find('h4').text();

				$('#'+ id.toLowerCase()).addClass('active');

			});

			$('#add-user').click(function(e){
				e.preventDefault();

				var username = $('#username').val();
				var email = $('#email').val();
				var pass = $('#password').val();
				var active_status = $('#cb-is-active').is(':checked') ? 1 : 0;
				var is_admin = $('#cb-is-admin').is(':checked') ? 1 : 0;

				dodaj_korisnika(username, pass, email, active_status, is_admin);
			});

			$('#add-nav').click(function(e){
				e.preventDefault();

				var naziv = $('#naziv').val();
				var link = $('#link').val();
				var id_parent = $('#id_parent').find(":selected").val();
				var has_submenu = $('#cb-has-submenu').is(':checked') ? 1 : 0;
				
				dodaj_nav(naziv, link, id_parent, has_submenu);
			});
		});

		

		//brisanje preko ajaxa
		function brisi(tabela, id){
			var url = window.location;
			var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];

			$.ajax({
				url: base_url + "/admin-panel/obrisi/",
				method: "POST",
				data: {id: id, tip: tabela}
			})

			.done(function(e){

				location.reload();
			})

			.fail(function(e){
				console.log(e);
			});

			//dodavanje preko ajaxa
		}
		//dodvanje korisnika
		function dodaj_korisnika(username, pass, email, active_status, is_admin){
			var url = window.location;
			var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];


			$.ajax({
				url: base_url + "/admin-panel/dodaj/",
				method: "POST",
				data: {tip: 'korisnici', pass: pass, username: username, email: email, active_status: active_status, is_admin: is_admin }
			})

			.done(function(e){
				console.log(e);
				if(e == "OK"){
					//$('.add').removeClass('active');
					location.reload(true);
				}else{
					$('.message').html(e);
				}
				
				
			})

			.fail(function(e){
				console.log(e.responseText);
			});
		}
		//dodvanje korisnika
		function dodaj_nav(naziv, link, id_parent, has_submenu){
			var url = window.location;
			var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];


			$.ajax({
				url: base_url + "/admin-panel/dodaj/",
				method: "POST",
				data: {tip: 'navigacija',naziv: naziv, link: link, id_parent: id_parent, has_submenu: has_submenu }
			})

			.done(function(e){
				//console.log(e);
				if(e == "OK"){
					//$('.add').removeClass('active');
					location.reload(true);
				}else{
					$('.message').html(e);
				}
				
				
			})

			.fail(function(e){
				console.log(e.responseText);
			});
		}
		//menjanje boje ako ima text
		function changeBorderColor(e){
			
			var v = $('#'+e.id).val();
			if(v != ""){
				$('#'+e.id).addClass('active');
			}else{
				$('#'+e.id).removeClass('active');
			}
		}
		
	</script>
</body>