@extends('master')
@section('main_content')
<div class="container-fluid">
    <div class="row">
<!-- START CONTENT -->
      <div class="content  p-0 pt-2 col-lg- col-md-12">
       

        <div class="form-area">
        	<h2>Register Form</h2>
					
					<div id="info-area"></div>
        	<hr>
        	<form method="POST">

				  <div class="mb-3">
				    <label for="name" class="form-label">Name</label>
				    <input type="text" class="form-control" id="name" name="name" required>
				  </div>
				  <div class="mb-3">
				    <label for="email" class="form-label">Email address</label>
				    <input type="email" class="form-control" id="email" name="email" required>
				  </div>
				  <div class="mb-3">
				    <label for="password" class="form-label">Password</label>
				    <input type="password" class="form-control" id="password" name="password" required>
				  </div>
				  <div class="mb-3">
				    <label for="confirm_password" class="form-label">Confirm Password</label>
				    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
				  </div>
				  <div class="d-grid">
				  	<button type="submit" id="register" class="btn btn-block btn-success">Register</button>
				  </div>
				  <p>Already registered? <a href="{{ url('login')}}">Login now</a></p>
				</form>
        </div>

      </div>
    </div>
  </div>
@endsection