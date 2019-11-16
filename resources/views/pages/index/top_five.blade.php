<div class="col-md-6 div-max-height" style="flex-grow:1;display:flex;flex-direction:column;">
    <div class="border p-3">
        <div class="row">
            <div class="col-10"><h5>Najboljših 5</h5></div>
            <div class="col-2 mt-n2"><a class="float-right btn btn-outline-primary btn-sm" href="/table">Več</a></div>
        </div>
        <div class="table-responsive">
            <table class="table table table-hover">
                <thead>
                    <tr>
                    <th scope="col" class="cell-align-right">#</th>
                    <th scope="col" class="pl-3">Tekmovalec</th>
                    <th scope="col" class="cell-align-right">Točke</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['topFive'] as $participant)
                        @if (auth()->user() && $participant['username'] == auth()->user()->username)
                            <tr style="background-color:#f2f2f2">
                        @else
                            <tr>       
                        @endif
                            <td class="cell-align-right">{{$participant['position']}}.</td>
                            @if (Auth::id() == $participant['id']) 
                                <td class="pl-3"><a href={{route('dashboard.index')}}>{{$participant['username']}}</a></td>
                            @else
                                <td class="pl-3"><span><a href={{route('user_profile.show', ['id' => $participant['id']])}}><img src="storage/profile_images/{{ $participant['profile_image'] }}" class="rounded-circle z-depth-0 mt-n3 mb-n3" style="height: 1.5rem; width:1.5rem"
                                    alt=""> {{$participant['username']}}</a><span></td>
                            @endif
                            <td class="cell-align-right">{{($participant['points_total']) == null ? 0 : $participant['points_total']}}</td>
                        </tr>
                    @empty
                        
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>