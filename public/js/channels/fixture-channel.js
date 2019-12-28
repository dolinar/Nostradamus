
    var fixtureChannel =`fixture.${$('#fixture_id').text()}`;
    //var fixtureChannel = 'fixture-channel';
    var channel = Echo.join(fixtureChannel);
    var numberOfUsers;
    var usersInChannel;
    channel
        .here((users) => {
            usersInChannel = users;
            numberOfUsers = usersInChannel.length;
            $('#chatroom-badge').text(numberOfUsers);
        })
        .joining((user) => {
            usersInChannel.push(user);
            numberOfUsers++;
            $('#chatroom-badge').text(numberOfUsers);
        })
        .leaving((user) => {
            usersInChannel = usersInChannel.filter(u => u != user);
            numberOfUsers--;
            $('#chatroom-badge').text(numberOfUsers);
        })        
        .listen('FixtureChatroomEvent', (e) => {
            console.log(e);
            var tbody = document.getElementById('chatroom-tbody');

    
            var tbodyModified = tbody.innerHTML + 
            '<tr>' +
                '<td class="small text-muted" style="width:10%">' + (new Date()).toTimeString().substr(0,5) + '</td>' +
                '<td style="width:20%"><span><a href="/user_profile/' + e.user.id + '" class="small text-muted"><img src="/storage/profile_images/' + e.user.profile_image + '" class="rounded-circle z-depth-0 mt-n3 mb-n3" style="height: 1.5rem; width:1.5rem"> ' + e.user.username + '</a></span></td>' +
                '<td style="width:100px;word-break: break-all;">' + e.message + '</td>' +
            '</tr>'
            
            tbody.innerHTML = tbodyModified;
    
            var element = document.getElementById('chatbox');
            element.scrollTop = element.scrollHeight;
        });