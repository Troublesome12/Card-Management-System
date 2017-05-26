$(document).ready(function() {

	$('.menubtn').on('click', function(e){
    	var id = e.currentTarget.id;
	  	$(this).toggleClass('opened');
	  	$('#navmenu'+id).toggleClass('opened');
        return false;
	});

    $(document).on('click', function (e) {
        if($('.menubtn').hasClass('opened')) {
            $('.menubtn').removeClass('opened');
            $('.navmenu').removeClass('opened');
        }
    });
});

function cardEdit(card_id) {
    $.ajax({
        url: base_url+'card/getCard',
        type: 'POST',
        data: {
            'id' : card_id
        }
    }).done(function(card) {
        var card = jQuery.parseJSON(card);
        $('#id').val(card.id);
        $('#name').val(card.name);
        $('#designation').val(card.designation);
        $('#company').val(card.company);
        $('#address').val(card.address);
        $('#email').val(card.email);
        $('#mobile').val(card.mobile);
        $('#website').val(card.website);
        console.log(card);
        $('#editModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });        
}

function confirmEdit(){
    swal({
        title: "Are you sure to edit?",
        text: "You will not be able to recover this info",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm){
        if (isConfirm) {
            $("#cardEditForm").submit();
        } else {
            $('#editModal').modal('toggle');
        }
    });
}

function cardDuplicate(id) {
	$('#'+id).toggleClass('opened');
  	$('#navmenu'+id).toggleClass('opened');
	swal({
		title: "Are you sure?",
		text: "Do you really want to duplicate this card?",
		type: "info",
		showCancelButton: true,
		confirmButtonColor: "#6e96ff",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false
	},
	function(isConfirm){
		if (isConfirm) {
			$.ajax({
                url: base_url+'card/duplicate',
                type: 'POST',
                data: {
                    "id": id
                }
            }).done(function() {
            	window.location.reload();
            });
		}
	});
}

function cardDelete(id) {
	$('#'+id).toggleClass('opened');
  	$('#navmenu'+id).toggleClass('opened');
	swal({
		title: "Are you sure to delete?",
		text: "You will not be able to recover this card",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false
	},
	function(isConfirm){
		if (isConfirm) {
			$.ajax({
                url: base_url+'card/delete',
                type: 'POST',
                data: {
                    "id": id
                }
            }).done(function() {
            	window.location.reload();
            });
		}
	});
}

function deleteUser(user_id) {
    swal({
		title: "Are you sure to delete?",
		text: "You will not be able to recover this user",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false
	},
	function(isConfirm){
		if (isConfirm) {
			$.ajax({
                url: base_url+'user/deleteUser',
                type: 'POST',
                data: {
                    "id": user_id
                }
            }).done(function() {
            	window.location.reload();
            });
		}
	});
}