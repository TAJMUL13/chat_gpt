@extends('master')
@section('main_content')
<div class="container-fluid">
    <div class="row">
 <!-- START CONTENT -->
      <div class="content  p-0 pt-2 col-lg- col-md-12">
       
        <div class="form-area">
        	<h2>Login Form</h2>
					<div id="info-area"></div>
        	<hr>
        	<form method="POST">
					  <div class="mb-3">
					    <label for="email" class="form-label">Email address</label>
					    <input type="email" class="form-control" id="email" name="email" required >
					  </div>
					  <div class="mb-3">
					    <label for="password" class="form-label">Password</label>
					    <input type="password" class="form-control" id="password" name="password" required >
					  </div>
					  <div class="d-grid">
					  	<button type="submit" id="login" class="btn btn-block btn-success">Login</button>
					  </div>
					  <p>Don't have account? <a href="{{ url('register')}}">Register now</a></p>
				</form>
        </div>

      </div>
    </div>
  </div>
@endsection