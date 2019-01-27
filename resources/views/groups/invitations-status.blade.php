@if ($data['participants'])
    <div id="group-inv-status-table" class="table-wrapper-scroll-y col-lg-4 col-md-6 mt-3" style="display:none;">
        <div class="table-responsive" style="border-radius:5px;">
            <table class="table table-sm table-hover">
                <thead class="table-active">
                    <tr>
                        <th scope="col">Povabljeni up.</th>
                        <th scope="col" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['invitations'] as $invitation)
                        <tr>
                            <td>{{$invitation->username}}</td>  
                            <td class="text-center">
                            @if($invitation->status == 0) 
                                <i class="fas fa-minus"></i>
                            @elseif ($invitation->status == 1)
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endif