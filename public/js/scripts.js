$(document).ready(function() {
    $('.navbar .dropdown').hover(function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
      }, function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
      });



    $('.form-check-overall-prediction').click(function() {
      $('.form-check-overall-prediction').not(this).prop('checked', false);
    });

    //TODO!!!! only for overallprediction checkbox family.
    $('input[type="checkbox"]').change(function () {
        if ($(this).is(':checked')) {
            $('#team-id').val($(this).attr('name'));
        } 
    });
});

$(document).ready(function() {
    $('.btn-click').click(function() {
        var id = this.id;
        $('#div-' + id).toggle(500);
        $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
});

$(document).ready(function() {
    $('#show-group-form').click(function() {     
        $('#group-store').toggle(500);
    }); 

    $('#group-add-member').click(function() {
        $('#group-inv-status-table').hide(500);
        $('#add-member-form').toggle(500);
    }); 

    $('#group-show-inv-status').click(function() {
        $('#add-member-form').hide(500);
        $('#group-inv-status-table').toggle(500);
    }); 

});


$(document).ready(function(){
    $('#user-search').on('keyup', function() {
        var text = $('#user-search').val();
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            method: "GET",
            url: "/table/search",
            data: {text: $('#user-search').val()},
            success: function(response) {
                if (response['search'] == null) {
                    $('body').html(response['html']);
                    $('#user-search').focus();
                    $('#pagination').show();
                    $('.dropdown-toggle').dropdown();
                } else {
                    $('#tbody-participants').hide();
                    $('#tbody-participants').html(response['html']);
                    $('#tbody-participants').show(300);
                    $('#pagination').hide();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });
});

$(document).ready(function(){
    $('#user-id-select').select2({
        placeholder: 'Izberi uporabnika',
        width: '100%',
    });
});

$(document).ready(function() {
    $('#store-accept').click(function() {
        var id = $(this).attr('name');
        var confirmed = $(this).attr('value');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: "/store_user_to_group",
            data: {id: id, confirmed: confirmed},
            success: function(response) {
                $('body').html(response);
                $('.dropdown-toggle').dropdown();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });

    $('#store-reject').click(function() {
        var id = $(this).attr('name');
        var confirmed = $(this).attr('value');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: "/store_user_to_group",
            data: {id: id, confirmed: confirmed},
            success: function(response) {
                $('body').html(response);
                $('.dropdown-toggle').dropdown();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                //alert(errorThrown);
            }       
        });
    });
});

$(document).ready(function(){
    $('.group-delete-fa').click(function() {
        if (confirm('Res želite uporabnika odstraniti iz skupine?')) {
            var id = $(this).attr('id');
            var idGroup = $(this).attr('value');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "/remove_user",
                data: {id: id, idGroup: idGroup },
                success: function(response) {
                    $('body').html(response);
                    $('.dropdown-toggle').dropdown();

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    //alert(errorThrown);
                }       
            });
        }
    })

    $('#group-leave').click(function() {
        if (confirm('Res želite zapustiti skupino?')) {
            var idGroup = $(this).attr('value');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: "/leave_group",
                data: {idGroup: idGroup },
                success: function(response) {
                    $('body').html(response);
                    $('.dropdown-toggle').dropdown();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    //alert(textStatus);
                }       
            });
        }
    }) 
});

$(document).ready(function() {
    $('.li-results').click(function() {    
        var id = $(this).attr('id');
        $('#tb-' + id).toggle(500);
        $(this).find('.fa-chevron-results').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    }); 

    $('.active-predictions-dropdown').click(function() {
        $('.active-predictions').toggle(500);
        $(this).find('.fa-chevron-active-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.previous-predictions-dropdown').click(function() {
        $(this).siblings().find('.previous-prediction').toggle(500);
        $(this).find('.fa-chevron-previous-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });




    
    $('.previous-predictions-profile-dropdown').click(function() {
        $('.previous-prediction').toggle(500);
        $(this).find('.fa-chevron-previous-predictions-profile').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.previous-prediction').click(function() {
        $(this).siblings('#' + $(this).attr('id')).toggle(500);
        $(this).find('.fa-chevron-results').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });


    $('.active-predictions-profile-dropdown').click(function() {
        $('.active-prediction').toggle(500);
        $(this).find('.fa-chevron-active-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });

    $('.active-prediction').click(function() {
        $(this).siblings('#' + $(this).attr('id')).toggle(500);
        $(this).find('.fa-chevron-predictions').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
});


jQuery(document).ready(function() { 
    jQuery("time.timeago").timeago();
});

// chatroom 

$(document).ready(function() {
    // on enter press
    var input = document.getElementById('chatroom-text-field');

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

    // scroll to bottom
    var element = document.getElementById('chatbox');
    if (element) {
        element.scrollTop = element.scrollHeight;    
    }

    // disable if not logged in
    if ($('#chatroom-hidden-input').val() == null || $('#chatroom-hidden-input').val().length === 0) {
        $('#chatroom-text-field').toggleClass('disabled');
    }


    // fire event on save
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