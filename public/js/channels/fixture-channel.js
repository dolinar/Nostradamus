
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
            console.log(e.message);
        });