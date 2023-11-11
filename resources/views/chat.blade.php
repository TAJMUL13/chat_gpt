@extends('master')
@section('main_content')
<!-- START CONTENT -->
<div class="container-fluid">
    <div class="row">
      <div class="content  p-0 pt-2 col-lg- col-md-12">
      	<p class="text-end me-5"><a href="#" onclick="logout()"> Logout</a> </p>
        <div class="chat-content-area" id="chat-area">

          <h3 class="text-center">Welcome to Chat-GPT 3.5</h3>
          <a href="#" id="show-old" class="btn btn-warning"> Old Message</a>
        </div>

        <!-- START CHAT INPUTS -->
        <div class="chat-input-area overflow-hidden">
          <div class="row">
            <div class="col-12 chat-inputs-area-inner">
              <div class="row chat-inputs-container d-flex align-items-center">
                <textarea name="" id="user_input" class="col-11" placeholder="Send a message"></textarea>
                <span class="col-1">
                	<img style="height:20px;margin-left: 12px;margin-bottom: 8px;" id="loding_gif" src="img/loading.gif">
                	<i class="fa fa-paper-plane" id="ajaxButton" aria-hidden="true"></i>
                </span>
                
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection