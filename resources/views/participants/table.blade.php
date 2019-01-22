<div class="table-responsive" style="border-radius:5px">
    <table class="table table-sm table-hover">
        <thead class="table-active">
            <tr>
            <th>#</th>
            <th scope="col">Tekmovalec</th>
            <th scope="col">Točke skupaj</th>
            <th scope="col">Točke zadnji tekmovalni dan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['participants'] as $key => $participant)
                @if (auth()->user() && $participant['username'] === auth()->user()->username)
                    <tr style="background-color:#b7d3ff">
                @else
                    <tr>
                @endif
                        <td>{{$data['participants']->firstItem() + $key}}</td>  
                        <td>{{$participant['username']}}</td>
                        @if ($participant['total_points'] != null)
                            <td>{{$participant['total_points']}}</td>
                        @else
                            <td>0</td>
                        @endif 
                        <td>1</td>
                    </tr>
            @endforeach
            @if (auth()->user() && ($data['user']['position'] < $data['participants']->firstItem() || $data['user']['position'] >= $data['participants']->firstItem() + 10))
                <tr style="background-color:#b7d3ff">
                    <td >{{$data['user']['position']}}.</td>
                    <td>{{$data['user'][0]['username']}}</td>
                    @if ($data['user'][0]['total_points'] != null)
                        <td>{{$data['user'][0]['total_points']}}</td>
                    @else
                        <td>0</td>
                    @endif
                    <td>1</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
{{ $data['participants']->links() }}