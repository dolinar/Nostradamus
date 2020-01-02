<div class="modal fade" id="{{$fixture['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form-{{$fixture['id']}}" class="quick-prediction-form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Napoved tekme</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <img style="height:2em" src="{{$fixture['team_home']['logo_url']}}"> {{$fixture['team_home']['name']}}
                    </div>
                    <div class="col-sm-4 text-center my-2">
                        {{Form::number('prediction[' . $fixture['id'] . '][home]', null, array('class' => 'input-score', 'autocomplete' => 'off', 'min' => 0, 'max' => 100))}} 
                            : 
                        {{Form::number('prediction[' . $fixture['id'] . '][away]', null, array('class' => 'input-score', 'autocomplete' => 'off', 'min' => 0, 'max' => 100))}}</span>
                    </div>
                    <div class="col-sm-4 text-center">
                        <img style="height:2em" src="{{$fixture['team_away']['logo_url']}}"> {{$fixture['team_away']['name']}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Shrani</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zapri</button>
            </div>
        </div>
        </form>
    </div>
</div>