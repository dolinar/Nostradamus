<div class="col-md-6 col-margin" style="flex-grow:1;display:flex;flex-direction:column">
    <div class="border p-3" style="height:100%;">
        <h5>Klepetalnica</h5>
        <div id="chatbox">
            
        </div>
        <div style="position:absolute;bottom:0">
            {{ Form::open(['route' => 'send_chatroom_message', 'method' => 'POST', 'class' => 'form-inline']) }}
            <div class="md-form">
                <fieldset>
                    {{ Form::text('message', null, ['class' => 'form-control-md', 'id' => 'msgField']) }}
                    {{ Form::label('msgField', 'Sporočilo') }}
                    {{ Form::submit('Pošlji', ['class' => 'btn btn-outline-primary waves-effect btn-sm']) }}
                </fieldset>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>