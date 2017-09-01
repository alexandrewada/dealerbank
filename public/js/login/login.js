// $(function(){


// 	$("#login").submit(function(e){
// 		$("button[type='submit']").hide("slow");
// 		e.preventDefault()
// 		$.post("login/entrar",$(this).serialize()+'&tipo=json',function(e){
// 			if(e.erro == true) {
// 				$("#erroResult").html(e.msg).hide().show("slow");
// 			} else {
// 				window.location.href = 'http://www.ingles200h.com/areadoaluno/dashboard';
// 			}
// 		});
// 		$("button[type='submit']").show("slow");
// 	});


// 	$("input[name='email']").blur(function(){
// 		var varemail = $("input[name='email']").val();

// 		if(varemail.length > 6) {
// 			$.post("login/checaremail",{email:varemail},function(e){
// 				if(e == 1) {
// 					$("input[name='email']").css('border','1px solid #59F869');
// 					$(".input-icon-right .fa-user").css('color','green');
// 				} else {
// 					$("input[name='email']").css('border','1px solid #EE5757');
// 					$(".input-icon-right .fa-user").css('color','red');
// 				}
// 			});
// 		} else {
// 			$("input[name='email']").css('border','1px solid #EE5757');
// 		}
// 	});
// });