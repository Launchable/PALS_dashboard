/*
 * Friends JS Objects
 */

var Friends = function () {

    var $btnConfirmRequest = $('.btnFriendRequestConfirm');
    var $btnDeleteRequest = $('.btnFriendRequestDelete');

    return {

        // Friend confirm request
        confirmRequest: function () {
            $btnConfirmRequest.click(function (e) {
                e.preventDefault();

                var $dataRequestId = $(this).data('id');
                var $senderId = $('#sender-id-' + $dataRequestId).val();
                $.ajax({
                    type: 'POST',
                    url: "/home/friend/confirmRequest",
                    data: {'senderId': $senderId},
                    dataType: 'json',
                    beforeSend: function () {
                        $('#loading-box').LoadingOverlay('show')
                    },
                    success: function (data) {
                        if (data.status == 'OK') {
                            $('#media-' + $dataRequestId).hide();
                        } else {
                            alert(data.message);
                        }

                        return true;
                    }, error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });

                $('#loading-box').LoadingOverlay('hide', true);
            });
        },

        deleteRequest: function () {
            $btnDeleteRequest.click(function (e) {
                e.preventDefault();

                var $dataRequestId = $(this).data('id');
                var $requestId = $('#request-id-' + $dataRequestId).val();

                $.ajax({
                    type: 'POST',
                    url: "/home/friend/deleteRequest",
                    data: {'requestId': $requestId},
                    dataType: 'json',
                    beforeSend: function () {
                        $('#loading-box').LoadingOverlay('show')
                    },
                    success: function (data) {
                        if (data.status == 'OK') {
                            $('#media-' + $dataRequestId).hide();
                        } else {
                            alert(data.message);
                        }

                        return true;
                    }, error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                        alert('An error has occur, please contact the administrator.');
                    }
                })

                $('#loading-box').LoadingOverlay('hide', true);
            });
        },

        // Friend delete request

        // Init js objects
        init: function () {
            Friends.confirmRequest();
            Friends.deleteRequest();
        }
    }
}();

// Initialize the Friends object
Friends.init();

/*

 function confirmFriendRequest() {
 var $request = {};
 $request.sender_id = $('#sender_id').val();
 $request._token = $('input[name="_token"]').val();

 $.ajax({
 type: 'POST',
 url: {
 {
 route('ajax.friend.confirm')
 }
 },
 data: $request,
 success
 :
 function (response) {

 $('#loading').modal('hide');
 }

 ,
 error: function (response) {
 showNotification(response.responseJSON.msg);
 $('#loading').modal('hide');
 }
 })
 ;
 }*/
