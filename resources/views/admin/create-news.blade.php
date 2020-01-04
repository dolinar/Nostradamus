<div class="card my-3 mt3 p-3" id="add-member-form">
    {{ Form::open(['action' => 'AdminController@createNews', 'method' => 'POST' ,'enctype' => 'multipart/form-data']) }}
    <fieldset>
        <h5>Nova novica</h5>
        <div class="form-group">
            Naslov: {{ Form::text('title', '', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            Povzetek: {{ Form::text('summary', '', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            Vrsta novice: 
            {{ Form::select('news_type_select', $data['type'], 0, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            Jedro: {{Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Sporočilo', 'id' => 'article-ckeditor'])}}
        </div>

        <div class="form-group">
            Glavna slika novice: {{ Form::file('news_image') }}
        </div>

        <div class="form-group">
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit('Shrani', ['class' => 'btn btn-primary btn-sm']) }}
        </div>
    </fieldset>
    {{ Form::close() }}
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
</div>    
    