@if ($data['invitations'])
<div class="table-responsive" style="border-radius:5px">
    <table class="table table-sm table-hover">
        <thead class="table-active">
            <tr>
            <th scope="col" class="cell-align-right">#</th>
            <th scope="col" class="pl-3">Tekmovalec</th>
            <th scope="col" class="cell-align-right">Skupaj točk</th>
            <th scope="col" class="cell-align-right">Zadnji tekmovalni dan</th>
            @if ($data['isAdmin'] == 1)
                <th scope="col" class="text-center">Odstrani up.</th>
            @else
                <th></th>
            @endif
            </tr>
        </thead>
        <tbody id="tbody-participants">
            @php $i=1; @endphp
            @foreach ($data['participants'] as $key => $participant)
                @if (auth()->user() && $participant['username'] === auth()->user()->username)
                    <tr style="background-color:#f2f2f2">
                @else
                    <tr>
                @endif
                        <td class="cell-align-right">{{$data['participants']->firstItem() + $key}}.</td>  
                        @if (Auth::id() == $participant['id']) 
                            <td class="pl-3"><a href={{route('dashboard')}}>{{$participant['username']}}</a></td>
                        @else
                            <td class="pl-3"><a href={{route('user_profile.show', ['id' => $participant['id']])}}>{{$participant['username']}}</a></td>
                        @endif
                        <td class="cell-align-right">{{($participant['points_total']) == null ? 0 : ($participant['points_total'])}}</td>
                        <td class="cell-align-right">{{$participant['points_matchday']}}</td>
                        @if (auth()->user() && $participant['username'] != auth()->user()->username && $data['isAdmin'] == 1 && $data['group']['owner'] != $participant['id'])    
                        <td class="text-center" style="color:red;">
                            <i id={{$participant['id']}} value={{$data['group']['id']}} class="fas fa-minus group-delete-fa"></i>
                        </td>
                        @else
                            <td></td>   
                        @endif
                        
                    </tr>   
            @endforeach

            @if (auth()->user() && ($data['user']['position'] < $data['participants']->firstItem() || $data['user']['position'] >= $data['participants']->firstItem() + 10))
                <tr style="background-color:#f2f2f2">
                    <td class="cell-align-right">{{$data['user']['position']}}.</td>
                    <td class="pl-3"><a href={{route('dashboard')}}>{{$data['user'][0]['username']}}</a></td>
                    <td class="cell-align-right">{{($data['user'][0]['points_total']) == null ? 0 : $data['user'][0]['points_total']}}</td>
                    <td class="cell-align-right">{{$data['user'][0]['points_matchday']}}</td>
                </tr>
            @endif


        </tbody>
    </table>
</div>
<div id="pagination">
    {{ $data['participants']->links() }}
</div>
@endif
        