//require('./bootstrap');

Echo.channel('chatroom-channel')
    .listen('ChatroomEvent', (e) => {
        
        console.log(e);
        var tbody = document.getElementById('chatroom-tbody');

        //							<td style="width:20%"><span><a href={{route('user_profile.show', ['id' => $message->id_user])}} class="small text-muted"><img src="storage/profile_images/{{ $message->user->profile_image }}" class="rounded-circle z-depth-0 mt-n3 mb-n3" style="height: 1.5rem; width:1.5rem"
		//						alt=""> {{$message->user->username}}</a></span></td>

        var tbodyModified = tbody.innerHTML + 
        // '<span class="badge">' + usersInChannel + '</span>'
        '<tr>' +
            '<td class="small text-muted" style="width:10%">' + (new Date()).toTimeString().substr(0,5) + '</td>' +
            '<td style="width:20%"><span><a href="/user_profile/' + e.userId + '" class="small text-muted"><img src="storage/profile_images/' + e.profileImg + '" class="rounded-circle z-depth-0 mt-n3 mb-n3" style="height: 1.5rem; width:1.5rem"> ' + e.username + '</a></span></td>' +
            '<td style="width:100px;word-break: break-all;">' + e.message + '</td>' +
        '</tr>'
        
        tbody.innerHTML = tbodyModified;

        var element = document.getElementById('chatbox');
        element.scrollTop = element.scrollHeight;
    });

