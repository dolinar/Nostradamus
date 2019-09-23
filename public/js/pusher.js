// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('ecae058ee0f9a383a5d8', {
  cluster: 'eu',
  forceTLS: true
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
  alert(JSON.stringify(data));
});