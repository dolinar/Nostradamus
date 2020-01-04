<div class="form-group">
    <ul class="list-group">
        @foreach ($data['teams'] as $team)
            <li class="list-group-item pl-4">
                {{Form::checkbox($team->id, $team->id, false, ['class' => 'form-check-overall-prediction', 'disabled' => 'disabled'])}}
                    <span class="text-secondary"><img class="ml-2 team-image" src="{{$team->logo_url}}"> {{$team->name}}<span></li>
        @endforeach
    </ul>
</div>