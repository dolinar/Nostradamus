<div class="col-md-6 col-margin div-max-height">
    <div class="border p-3" style="height:100%;">
        <h5>Klepetalnica</h5>
        <div id="chatbox" class="pre-scrollable">
			@if (count($data['chatroomMessages']) > 0)
				<table class="table table-sm max-height mb-0">
					<tbody id="chatroom-tbody">
					@foreach($data['chatroomMessages']->reverse() as $message)
						<tr>
							<td class="small text-muted">{{date('H:i', strtotime(date($message->created_at)))}}</td>
							<td>{{$message->user->username}}</td>
							<td>{{$message->message}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
            @endif
        </div>
        <div class="input-group align-bottom">
			@if (Auth::check())
				<input type="hidden" value="{{Auth::user()->id}}" id="chatroom-hidden-input">
			@endif
            <input id="chatroom-text-field" type="text" class="form-control" placeholder="Sporočilo" aria-label="Sporočilo"
              aria-describedby="button-addon">
            <div class="input-group-append">
              <button class="btn btn-md btn-outline-default m-0 px-3 py-2 z-depth-0 waves-effect" type="button" id="btn-chatroom-add">+</button>
            </div>
          </div>
    </div>
</div>