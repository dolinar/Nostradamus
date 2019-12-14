// chatroom - this one is called from chatroom view (!)

// scroll to bottom - ONLY WHEN THE PAGE IS LOADED.
var element = document.getElementById('chatbox');
if (element) {
    element.scrollTop = element.scrollHeight;    
}
$(document).ready(function() {

    // load new messages when scrolling to top.
	$('#chatbox').on('scroll', function(){
		if ($('#chatbox').scrollTop() == 0) {   // on top
			var count = parseInt($('#chatroom-table tr').length) + 10; // get current number of messages + 10
			$.get('get_chatroom_messages/' + count, function(responseData) {
				$('#chatroom-div').replaceWith(responseData); 
				$('#chatbox').scrollTop($('#chatroom-table tr').eq(0).height() * 10); // scroll so user sees no difference
			});
		}
	});

    // tooltip init (not logged in)
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // disable if not logged in
    if ($('#chatroom-hidden-input').val() == null || $('#chatroom-hidden-input').val().length === 0) {
        $('#chatroom-text-field').toggleClass('disabled');
    }


    // on enter press
    var input = document.getElementById('chatroom-text-field');

    if (input){
        // Execute a function when the user releases a key on the keyboard
        input.addEventListener('keyup', function(event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                document.getElementById('btn-chatroom-add').click();
            }
        });
    }

    // fire event on + button click
    $('#btn-chatroom-add').click(function(){
        // do nothing if no message
        var messageVal = $('#chatroom-text-field').val();
        if (messageVal == null || messageVal.length === 0) {
            return;
        }
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: 'send_chatroom_message',
            type: 'POST',    
            dataType: 'json',
            data: { message: messageVal },
            success: function (response) {
                var textField = document.getElementById('chatroom-text-field');
                textField.value = '';
                textField.focus();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
            }
        });
    });
});