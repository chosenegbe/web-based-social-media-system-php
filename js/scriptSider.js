// JavaScript Document

$(document).ready(function(){
	$(".msg_head").click(function(){
		$('.msg_wrap').slideToggle('slow');
		});
	$('.msg_head').click(function(){
			
			$('.msg_footer').show();
			
			$('#affi').show();
			
		});	
		
	$('.user').click(function(){
		 $('.msg_box').show();
		 $('.msg_wrap').show();
		});
	 $('textarea').keypress(
	 	function(e){
			if(e.keyCode==13){
				var msg = $(this).val();
				$(this).val("");
				$('<div class="msg_b">'+msg+'</div>').insertBefore('.msg_insert');
				$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
				}
			}
	 
	 );
	
	
	
	});