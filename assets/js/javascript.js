$(function(){


	/*
		close/open sidebar with links
	*/
	$('.open-sidebar-l').click(function(e){
		e.preventDefault();
		$('.side-bar-l').addClass('active');
		$('.nav li').each(function(i){
			setTimeout(function(){
				$('.nav li').addClass('active');
			}, 100 * i);
		})
		setTimeout(function(){
			$('.social-box a').addClass('active')
		},500);
	});

	$('.close-sidebar-l').click(function(e){
		e.preventDefault();
		$('.side-bar-l').removeClass('active');
		$('.nav li').removeClass('active');
		$('.social-box a').removeClass('active')
	})

	/*
		close/open sidebar with questionnaire
	*/
	$('.open-questionnaire').click(function(e){
		e.preventDefault();
		$('.questionnaire').addClass('active');
	});

	$('.close-questionnaire').click(function(e){
		e.preventDefault();
		$('.questionnaire').removeClass('active');
	})

	/*
		close/open sidebar with user setings/logins
	*/
	$('.open-sidebar-r').click(function(e){
		e.preventDefault();
		$('.side-bar-r').addClass('active');
		setTimeout(function(){
			$('.user-box').addClass('active');
		}, 300);
	});

	$('.close-sidebar-r').click(function(e){
		e.preventDefault();
		$('.side-bar-r').removeClass('active');
		$('.user-box').removeClass('active');
	})
	/*
		radiobuttons question

	*/
	$('.questions label').on('click', function(){
		
		$('.questions label').removeClass('check');
		$(this).addClass('check');

	});
	/*
		question animation
	*/

	$('.open-questionnaire').click(function(){
		$('.questions .results').each(function(i){
			setTimeout(function(){
				$('.results').addClass('active');
			}, 300);

			setTimeout(function(){
				$('.percent-width').addClass('active');
			}, 100 * (i+ 4));

		});
	});
	$('.close-questionnaire').click(function(){

		$('.results').removeClass('active');
		$('.percent-width').removeClass('active');
	});

	
	/*
		fileupload hover
	*/
	$('.fileUpload input.upload').hover(function(){
		$('.fileUpload span').addClass('active');
	}, function(){
		$('.fileUpload span').removeClass('active');
	})

	/*
		useredit input - value
	*/
	$('.user-edit').hover(function(){
		var el = $('.user-edit input');
		checkValue(el);
	}, function(){
		
	})

	/*
		passconfirmation visisble
	*/
	//$('.passCon').css('display', 'none');
	$('#cngPassword').on('input', function(){
		if(!$('#cngPassword').val()){
			$('.passCon').fadeOut();
			console.log("promena none");
		}else{
			//$('.passCon').css('display', 'block');
			$('.passCon').fadeIn();
		}
		//$('.passCon').css('display', 'none');
	})

	
	
})

/* 
	preloader animations and options
*/
$(window).on('load', function() { // makes sure the whole site is loaded 
     
     setTimeout(function(){
     	$('.preloader').fadeOut();
     	landingAnimations();
     });

    /*
	food containers animations on load
	*/

	$('.food-item-box-l').each(function(i){
        setTimeout(function(){
           	$('.food-item-box-l').eq(i).removeClass('active');
        }, 200 * (i+1));
    });
})

/*
	user-edit check if input has !value
*/

function checkValue(e){
	console.log(e);
}

function openTab(tabName,idBtn) {
    var i;
    var j;
    var y = document.getElementsByClassName('tabs-names')
    var x = document.getElementsByClassName("tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
        x
    }
    /* on/off tabs active*/
    $('.tabs-names').removeClass('active');
    $('#'+idBtn).addClass('active');
    document.getElementById(tabName).style.display = "block"; 


}

function selectUserImg(input) {
	
	
    if (input.files && input.files[0]) {
        
        var reader = new FileReader();
            
        reader.onload = function (e) {
            $(".img-icon").css('background', 'url('+e.target.result+')');
            $(".img-icon").css('background-size', 'cover');
        }
          
        reader.readAsDataURL(input.files[0]);
    }
}

function landingAnimations(){
	$('.food-item-box-l').each(function(i){
    	setTimeout(function(){
       		$('.food-item-box-l').eq(i).removeClass('active');
    	}, 20 * (i+1));
	});

	$('.food-item-box-s').each(function(i){
    	setTimeout(function(){
       		$('.food-item-box-s').eq(i).removeClass('active');
    	}, 30 * (i+1));
    });

    $('.recipe-container img').each(function(i){
    	setTimeout(function(){
       		$('.recipe-container img').eq(i).removeClass('active-animation');
    	}, 50 * (i+1));
    });
    $('.user-wrap .recipe-wrap').each(function(i){
    	setTimeout(function(){
       		$('.user-wrap .recipe-wrap').eq(i).removeClass('active-animation');
    	}, 50 * (i+1));
    });

    //menu

    //slider
    setTimeout(function(){
    	$('.header').removeClass('active-animation');
    });
}

function calc_date(date){
			var dbTime 		= new Date(date);
			var dbYear		= dbTime.getFullYear();
			var dbMonth 	= dbTime.getMonth();
			var dbDay		= dbTime.getDate();
			
			var now			= new Date();
			var nowYear		= now.getFullYear();
			var nowMonth 	= now.getMonth();
			var nowDay		= now.getDate();
			


			if(dbYear == nowYear && dbMonth == nowMonth && dbDay == nowDay){
				return "danas" ;
			}else{
				if(dbYear == nowYear && dbMonth != nowMonth && (nowMonth - dbMonth) == 1){
					//console.log(nowDay + 30);
					return "pre " + ((nowDay + 30) - dbDay) + " dana";
				}else{
					
						if(dbYear == nowYear){
							return "pre više od mesec dana";
						}else{
							return 'pre više od godinu dana';
						}
				}
			}
		}