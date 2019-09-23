<div class="col-md-6 col-margin">
    <div class="border p-3 flex-grow-1" style="height:100%">
        <h5>Klepetalnica</h5>
        <div style="position:absolute;bottom:0">
            {{ Form::open(['route' => 'send_chatroom_message', 'method' => 'POST', 'class' => 'form-inline']) }}
            <div class="md-form">
                <fieldset>
                    {{ Form::text('message', null, ['class' => 'form-control-md', 'id' => 'msgForm']) }}
                    {{ Form::label('msgForm', 'Sporočilo') }}
                    {{ Form::submit('Pošlji', ['class' => 'btn btn-outline-primary waves-effect btn-sm']) }}
                </fieldset>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>