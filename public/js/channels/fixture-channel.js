
    var fixtureChannel =`fixture.${$('#fixture_id').text()}`;
    //var fixtureChannel = 'fixture-channel';
    var channel = Echo.join(fixtureChannel);
    channel
        .here((users) => {
            console.log('123');
        })
        .joining((user) => {
            console.log('joining');
        })
        .leaving((user) => {
            console.log('leaving');
        })        
        .listen('FixtureChatroomEvent', (e) => {
            console.log('ok');
            console.log(e.user.id);
        });

$(document).ready(function(){
    $('#temp_button').click(function(){
        var fixtureIdVal = $('#fixture_id').text();
        var messageVal = '123';
        if (messageVal == null || messageVal.length === 0) {
            return;
        }
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: 'send_fixture_chatroom_message',
            type: 'POST',    
            dataType: 'json',
            data: { message: messageVal, fixtureId: fixtureIdVal},
            success: function (response) {
               console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
            }
        });
    });
});