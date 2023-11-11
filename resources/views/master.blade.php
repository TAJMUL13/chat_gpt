<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Chat GPT</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
  <style>
	*{
	  box-sizing: border-box;
	}
	body {
	  background-color: #353641;
	  margin: 0;
	  padding: 0;
	  color: white;
	}
	::-webkit-scrollbar {
	  width: 2px;
	}
	.content {
	  background-color: #353641;
	  margin: 0px;
	  box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.1);
	}
	#loding_gif{
		display: none;
	}
	.chat-content-area {
	  overflow: auto;
	  height: 490px;
	  overflow-x: hidden;
	  margin: 0 3% 3% 3%;
	}
	.chat-inputs-container {
	  background-color: #fff;
	  padding: 5px;
	  border-radius: 5px;
	  box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.1);
	}
	.chat-inputs-container textarea {
	  background-color: transparent;
	  outline: none;
	  border: 1px solid #353641;
	  resize: none;
	}
	.chat-inputs-area-inner {
	  padding-top: 30px;
	  padding-left: 150px;
	  padding-right: 150px;
	}
	.fa-paper-plane {
  	color: white;
    cursor: pointer;
    padding: 16px;
    background-color: #1BA785;
    border-radius: 7px;
	}
	.chatgpt-icon {
	  width: 40px;
	}
	.user-chat-box {
	  padding: 20px;
	  padding-left: 150px;
	  color: #ffffff;
	}
	.form-select {
	  border: 1px solid rgb(96, 95, 95);
	  height: 40px;
	  border-radius: 5px;
	}
	small {
	  font-size: 11px;
	  padding: 12px;
	  display: block;
	}
	.gpt-chat-box {
	  background-color: #404350;
	  padding: 20px;
	  padding-left: 150px;
	  color: #ffffff;
	}
	.chat-icon {
	  width: 15%;
	  margin: 0;
	  padding: 0;
	}
	.chat-txt {
	  width: 85%;
	  margin: 0;
	  padding: 0;
	}
	.chat-input-area{
		overflow: hidden!important;
    position: fixed;
    bottom: 0;
    left: 0;
    content: "";
    width: 100%;
	}
	.form-area{
		width: 40%;
		margin-left:380px;
		margin-top: 40px;
	}
  </style>
</head>
<body>

@yield('main_content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
function logout(){
	var user_confirmation =  confirm('Are you sure?');
	if(user_confirmation==true){
	 	$.ajax({
      url: 'http://127.0.0.1:8000/api/logout',
      type: 'DELETE', 
      headers: {
          'Authorization': 'Bearer '+localStorage.getItem('token'),
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
          alert('Logout successfull');
					localStorage.clear();

					 var cookies = document.cookie.split("; ");

			    for (var i = 0; i < cookies.length; i++) {
			        var cookie = cookies[i];
			        var eqPos = cookie.indexOf("=");
			        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
			        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
			    }
          window.location.href = 'login';
      },
      error: function(xhr, status, error) {
          console.error(xhr.responseText);
      }
  });
	 }else{
	 	return false;
	 }

}
$(document).ready(function() {

// if no token redirect to login
	// if (window.location.href.indexOf('/chat') > -1 && localStorage.getItem('token')==null) {
  //   window.location.href = '/login';
	// }

	var container = document.getElementById('chat-area');
    // click event for operation
  $("#ajaxButton").click(function(event) {
  	  event.preventDefault()

  	var msg 		= $('#user_input').val();
  	var container = document.getElementById('chat-area');
  	$('#loding_gif').show();
  	$('#ajaxButton').hide();
    
		$('#user_input').val('');
		$('#chat-area').append('<div class="row user-chat-box"><div class="chat-icon"><img class="chatgpt-icon" src="img/user-icon.png" /></div><div class="chat-txt">'+msg+'</div></div>');
	// scroll to appended content
    container.scrollTop = container.scrollHeight;

	// check blank value
	if (msg.trim()) {
	 $.ajax({
	      'url': 'http://127.0.0.1:8000/api/send',
	      'type': 'POST',
	      'data': {
	      	'msg': msg
	      }, 
	      headers: {
        'Authorization': 'Bearer '+localStorage.getItem('token'),
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
	      'success': function(data,jqXHR) {
		      	if(jqXHR.status==401){
			      	$('#info-area').append(' <div class="alert alert-danger  fade show" role="alert" id="success-alert"><strong>Error!</strong> something went wrong!.</div>');
			      	$('#loding_gif').hide();
			      	$('#ajaxButton').show();
		      	}
		        console.log(data);
		      	if(data.trim()){
			        $('#chat-area').append('<div class="row gpt-chat-box"><div class="chat-icon"><img class="chatgpt-icon" src="img/chatgpt-icon.png" /></div><div class="chat-txt">'+data+'</div></div>');
							container.scrollTop = container.scrollHeight;
					 		$('#loding_gif').hide();
					 		$('#ajaxButton').show();
		      	}
	      },
	      'error': function(xhr, status, error) {
	      	$('#info-area').append(' <div class="alert alert-danger  fade show" role="alert" id="success-alert"><strong>Error!</strong> something went wrong!.</div>');
	      	 $('#loding_gif').hide();
	      	 $('#ajaxButton').show();
	          // alert(xhr.responseText);
	      }
	  });

			} else {
			    alert('Please fill in all fields');
			    $('#loding_gif').hide();
			      	$('#ajaxButton').show();
			}       
  });


    // click event for operation
    $("#register").click(function(event) {
    	  event.preventDefault()
    	var name 							= $('#name').val();
    	var email 						= $('#email').val();
    	var password 					= $('#password').val();
    	var confirm_password 	= $('#confirm_password').val();

// check blank value
	if (name.trim() && email.trim() && password.trim() && confirm_password.trim()) {
	 $.ajax({
	      'url': 'http://127.0.0.1:8000/api/register',
	      'type': 'POST',
	      'data': {
	      	'name': name,
	      	'email': email,
	      	'password': password,
	      	'confirm_password': confirm_password
	      }, 
	      'headers': {
	      	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      },
	      'success': function(data) {
	          console.log(data.status);
	          if(data.status==true){
	          	
	          	localStorage.setItem('token',data.token);
	          	$('#info-area').append('<div class="alert alert-success  fade show" role="alert" id="success-alert"><strong>Congratulations!</strong> Your account successfully created!<br><a href="{{url('chat')}}">Start Chat</a></div>');
	          }else{
							
	          }
	      },
	      'error': function(xhr, status, error) {
	      	$('#info-area').append(' <div class="alert alert-danger  fade show" role="alert" id="success-alert"><strong>Validation Error!</strong> Check your input!.</div>');
	      }
	  });

	} else {
	    alert('Please fill in all fields');
	}       
    });

    // click event for operation
    $("#login").click(function(event) {
    	event.preventDefault()


    	var email 						= $('#email').val();
    	var password 							= $('#password').val();

// check blank value
	if ( email.trim() && password.trim()) {
	 $.ajax({
	      'url': 'http://127.0.0.1:8000/api/login',
	      'type': 'POST',
	      'data': {
	      	'email': email,
	      	'password': password
	      }, 
	      'headers': {
	      	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      },
	      'success': function(data) {
	          console.log(data.status);
	          if(data.status==true){
	          	localStorage.setItem('token',data.token);
	          	$('#info-area').append('<div class="alert alert-success  fade show" role="alert" id="success-alert"><strong>Success!<br></strong> Login Successfull!  <a href="{{url('chat')}}">Start Chat</a></div>');
	          }
	      },
	      'error': function(xhr, status, error) {
	      	$('#info-area').append(' <div class="alert alert-danger  fade show" role="alert" id="success-alert"><strong>Authorization Error!</strong> Check your input!.</div>');
	      }
	  });

	} else {
	    alert('Please fill in all fields');
	}       
    });


    // click event for operation
    $("#show-old").click(function(event) {
    	  event.preventDefault()

    	$('#loding_gif').show();
    	$('#ajaxButton').hide();
    
    // container.scrollTop = container.scrollHeight;
// check blank value
	
	 $.ajax({
	      'url': 'http://127.0.0.1:8000/api/old-msg',
	      'type': 'GET', 
	      headers: {
        	'Authorization': 'Bearer '+localStorage.getItem('token'),
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
	      'success': function(data) {
	          console.log(data);
	          if(data.length>0){
	          for (var i = 0; i < data.length; i++) {
				    var item = data[i];
				    
				    if(item.is_gpt_msg==1){
				    	$('#chat-area').append('<div class="row gpt-chat-box"><div class="chat-icon"><img class="chatgpt-icon" src="img/chatgpt-icon.png" /></div><div class="chat-txt">'+item.msg+'</div></div>');
				    }else{
						$('#chat-area').append('<div class="row user-chat-box"><div class="chat-icon"><img class="chatgpt-icon" src="img/user-icon.png" /></div><div class="chat-txt">'+item.msg+'</div></div>');
				    }				    
				}
	          
				container.scrollTop = container.scrollHeight;
				 $('#loding_gif').hide();
				 $('#show-old').hide();
				 $('#ajaxButton').show();
	          }else{
							$('#chat-area').append('<div class="row user-chat-box text-warning"><div class="chat-icon"></div><div class="chat-txt">No old messages!</div></div>');
	          	$('#loding_gif').hide();
							$('#show-old').hide();
							$('#ajaxButton').show();
	          }
	      },
	      'error': function(xhr, status, error) {

	      	$('#info-area').append(' <div class="alert alert-danger  fade show" role="alert" id="success-alert"><strong>Error!</strong> something went wrong!.</div>');
	      	 $('#loding_gif').hide();
	      	 $('#ajaxButton').show();
	      }
	  });

	       
    });

	$("#show-token").click(function(event) {
		event.preventDefault()
		alert(localStorage.getItem('token'));
	});
});
</script>

</body>

</html>
