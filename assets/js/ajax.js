

$(function(){

	/*
		vote likes/dislikes
	*/
	$('.likes a').on('click', function(e){
		e.preventDefault();
		if(!$(this).hasClass('voted')){

			$('.likes a').addClass('voted');
			
			var url = window.location;
			var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];
			var vote = e.target.id;
			var id_recipe = url.pathname.split('/')[4];
			
			$.ajax({
				url: base_url + "/recepti/glasaj",
				method: "POST",
				dataType: 'JSON',
				data: {id_recipe: id_recipe, vote: vote}
			})

			.done(function(e){
				//console.log(e);
				$('.result').text(e.result);
			})
			.fail(function(e){
				console.log(e.responseText);
			});
		}

	});

	/*
		vote questionnaire
	*/

	$('#quest-btn').click(function(e){
		
		var id_opt 		= $('input[name="rbQuestionnaire"]:checked').val();
		var id_quest 	= $('#id_question').val();
		//console.log(id_quest);

		if(id_opt != undefined){
			
			var url = window.location;
			var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];
			
			$.ajax({
				url: base_url + '/anketa',
				method: 'POST',
				dataType: 'JSON',
				data: {id_quest: id_quest, id_opt: id_opt}

			})

			.done(function(e){
				
				var total = e.result.total;	
				var data  = e.result.data;
				var div   = "<p>Rezultati:</p>";

				console.log(e.result.data[1].votes / total * 100);

				$.each(data, function(i, v){
					div += '<div class="results">' +
								'<div class="result-percent">' +
									'<div class="percent-width" style="width: ' + data[i].votes / total * 100  + '%;"></div>' +
									'<span>'+ data[i].option +'</span>' +
								'</div>' + 
							'</div>';
				});

				$('.questions').html(div);

				$(function(){
					$('.questions .results').each(function(i){
						setTimeout(function(){
							$('.results').addClass('active');
						}, 300);
						setTimeout(function(){
							$('.results .percent-width').addClass('active');
						}, 200 * (i+ 3));

					})
				});

			})
			.fail(function(e){
				console.log(e.responseText);
			});
		}
		
	});

	

	/*
		Search brise kategorije
		
	*/

	$('#user-search-tb').on('input', function(){
		search_call();
	});

	$('#tb-recipe-search').on('input', function(){
		$('.category').prop('checked', false);
		$('.category label').removeClass('check');
		recipes_call();
	});

	/*
		label check
	*/
	$('.category label').on('click', function(){
		
		$('.category label').removeClass('check');
		$(this).addClass('check');
	});

	$('.sort label').on('click', function(){
		
		$('.sort label').removeClass('check');
		$(this).addClass('check');
	});
	$('.order label').on('click', function(){
		
		$('.order label').removeClass('check');
		$(this).addClass('check');
	});

	//put recipe-box opacity to 9 on rb click

	$('.recipe-menu .rb').on('click', function(){
		//$('#recipes-result .recipe-box').css('transform', 'scale(0.5,0.5)');
	});
});

function recipes_call(){
	$('#recipes-result').css('opacity', '0');

	var url = window.location;
	var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];
	console.log(base_url);
	var type;
	var order;
	var sort;
	var term;

	if($('.category').is(":checked"))
	{
		
		type 	= "category";
		term 	= $('input[name=category]:checked').val()
		sort 	= $('input[name=sort]:checked').val()
		order 	= $('input[name=order]:checked').val()
	}else{
		type 	= "title";
		term 	= $('#tb-recipe-search').val()
		sort 	= $('input[name=sort]:checked').val()
		order 	= $('input[name=order]:checked').val()
	}
	$.ajax({
		 url: base_url + "/recepti/recepti",
		 method: "POST",
		 dataType: "JSON",
		 data: {type: type, order: order, sort: sort, term: term}	  
	})

	.done(function(e){
		var resultData = "";
		var data = e.result.recipe;
		
		if(e.result != 'null'){
			$.each(data, function(i, value) {
				resultData += '<div class="recipe-box">';
					resultData += '<div class="recipe-img">';
						resultData += '<img src="'+ base_url +"/"+ value.img_small + '"/>';
					resultData += '</div>'; //recipe img
					resultData += '<div class="recipe-info">';
						resultData += '<div class="name">';
							resultData += '<a href="'+ base_url +"/recepti/id/"+value.id+'">'+ value.naziv_recepta +'</a>';
						resultData += '</div>'; //end name

						resultData += '<div class="rating">';
							resultData += value.likes + "<span class='fa fa-thumbs-up'></span><span class='fa fa-thumbs-down'></span>" + value.dislikes;
						resultData += '</div>'; // end rating

						resultData += '<div class="user">';
							resultData += '<a href="'+ base_url + '/korisnik/id/'+ value.id_user +'">'+ value.username +'</a>';
						resultData += '</div>'; // end user

						resultData += '<div class="date">';
							resultData += calc_date(value.recepti_created);
						resultData += '</div>'; // end date
						resultData += '<div class="category">';
							resultData += value.naziv_kategorije;
						resultData += '</div>'; // end category
						resultData += '<div class="views">';
							resultData += value.pregledi + "<span class='fa fa-eye'></span>";
						resultData += '</div>'; // end views
					resultData += '</div>'; //end recipe info
					
				resultData += '</div>'; //end recipe box	
			});
			
			/* pagination */
			$(function(){
				$(".pagination").jPages({
				  	containerID : "recipes-result",
	  				perPage: 6,
	  				previous: false,
	  				next: false,
	  				
	  				animation: false
				});
			});
			
		}else{
			resultData += "<div class='recipe-error'>Žao nam je, nema recepata...</div>";
		}
		$('.recipes-result').html(resultData);
		$('#recipes-result').animate({
			opacity: 1
		}, 300);
	})
	.fail(function(e){
		$('.recipes-result').text(e.responseText);
	});
}


function search_call(){
	var url = window.location;
	var base_url = url.protocol + "//" + url.host + "/" + url.pathname.split('/')[1];
	
	var type 	= "title";
	var term 	= $('#user-search-tb').val();
	var sort 	= "naziv";
	var order 	= "DESC";
	$.ajax({
		 url: base_url + "/recepti/recepti",
		 method: "POST",
		 dataType: "JSON",
		 data: {type: type, order: order, sort: sort, term: term}
		  
	})
	.done(function(e){
		var resultData = "";
		var data = e.result.recipe;
		if(e.result != 'null'){
			$.each(data, function(i, value) {
				resultData += '<div class="recipe-box">';
					resultData += '<div class="recipe-img">';
						resultData += '<img src="'+ base_url +"/"+ value.img + '"/>';
						resultData += '<div class="link">';
							resultData += '<a href="'+ base_url +"/recepti/id/"+value.id+'">'+ value.naziv_recepta +'</a>';
						resultData += '</div>';
					resultData += '</div>';
					
				resultData += '</div>';
			});
			$(function(){
				$(".search-pagination").jPages({
				  	containerID : "search-result",
	  				perPage: 4,
	  				previous: false,
	  				next: false,
	  				midrange: 5
				});
			});
		}
		else{
			resultData += "Zao nam je, nema recepata...";
		}
		$('.search-result').html(resultData);
		
	})

	.fail(function(e){
		$('.search-result').text(e.responseText);
	});
}
