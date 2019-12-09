<div class="col-md-6 col-margin" id="chatroom-div">
    <div class="border p-3" style="height:100%;">
        <h5>Klepetalnica</h5>
        <div id="chatbox" class="pre-scrollable mt-3">
			@if (count($data['chatroomMessages']) > 0)
				<table class="table table-sm max-height mb-0" id="chatroom-table">
					<tbody id="chatroom-tbody">
					@foreach($data['chatroomMessages']->reverse() as $message)
						<tr>
							<td class="small text-muted" style="width:10%">{{date('H:i', strtotime(date($message->created_at)))}}</td>
							<td style="width:20%"><span><a href={{route('user_profile.show', ['id' => $message->id_user])}} class="small text-muted"><img src="storage/profile_images/{{ $message->user->profile_image }}" class="rounded-circle z-depth-0 mt-n3 mb-n3" style="height: 1.5rem; width:1.5rem"
								alt=""> {{$message->user->username}}</a></span></td>
							<td style="width:100px;word-break: break-all;">{{$message->message}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
            @endif
		</div>
		@if (Auth::check())
			<div class="input-group align-bottom">
		@else
			<div class="input-group align-bottom" data-toggle="tooltip" title="Za klepet objava obvezna!">
		@endif
			@if (Auth::check())
				<input type="hidden" value="{{Auth::user()->id}}" id="chatroom-hidden-input">
			@endif
            <input data-emojiable="true" id="chatroom-text-field" type="text" class="form-control" placeholder="Sporočilo" aria-label="Sporočilo"
              aria-describedby="button-addon">
            <div class="input-group-append">
              <button class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect chatroom-button" type="button" id="btn-chatroom-add">+</button>
            </div>
          </div>
    </div>
</div>
<script>    
$('#chatbox').on('scroll', function(){
	console.log($('#chatbox').scrollTop());
	if ($('#chatbox').scrollTop() == 0) {   
		var count = parseInt($('#chatroom-table tr').length) + 10;
		$.get('get_chatroom_messages/' + count, function(responseData) {
			$('#chatroom-div').replaceWith(responseData); 
			$('#chatbox').scrollTop($('#chatroom-table tr').eq(0).height() * 10); 
			console.log($('tr').eq(0).height() * count);
		});
	}
});</script>