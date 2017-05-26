//export table
$('#contactExportExcel').click(function(){
	var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
	if(x.length < 1){
		$.ajax({
			url: base_url+'email/getAllDataOnTable',
			type: 'POST',
			success: function(data){
				$('#exportTableBody').append(data);
				var x=(document.getElementById("myTable").innerHTML).trim();
				$('#myTable').tableExport({type:'xlsx',escape:'false'});
			}
		});
	}else{
		$('#myTable').tableExport({type:'xlsx',escape:'false'});
	}	
});
$('#contactExportCSV').click(function(){
	var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
	if(x.length < 1){
		$.ajax({
			url: base_url+'email/getAllDataOnTable',
			type: 'POST',
			success: function(data){
				$('#exportTableBody').append(data);
				$('#myTable').tableExport({type:'csv',escape:'false'});
			}
		});
	}else{
		$('#myTable').tableExport({type:'csv',escape:'false'});
	}
});
$('#contactExportPDF').click(function(){
	var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
	if(x.length < 1){
		$.ajax({
			url: base_url+'email/getAllDataOnTable',
			type: 'POST',
			success: function(data){
				$('#exportTableBody').append(data);
				$('#myTable').tableExport({type:'pdf',escape:'false'});
			}
		});
	}else{
		$('#myTable').tableExport({type:'pdf',escape:'false'});
	}
});

// page print

$('#contactPagePrint').click(function(e){
	e.preventDefault();
	$.ajax({
		url: base_url+'email/getAllDataOnTable',
		type: 'POST',
		success: function(data){
			$('#exportTableBody').append(data);
			var originalContents = document.body.innerHTML;
			var printTable = '<table id="myTable" class="table table-striped table-bordered table-list"><thead><tr><th>Name</th><th>Email</th><th>Contact</th></tr></thead>';
			printTable +='<tbody id="exportTableBody">'+data+'</tbody></table>';
			document.body.innerHTML = printTable;
		    window.print();

		    document.body.innerHTML = originalContents;
		    location.reload();
		}
	});
});
// for create/edit/delete contact

var base_url = $('#base_url').val();

function removeHide(){
	$('.name2').removeClass('hide');
	$('.email2').removeClass('hide');
	$('.mobile2').removeClass('hide');
	$('.option2').removeClass('hide');
}
function hideAll(){
	removeHide();
	$('.name').show();
	$('.name2').addClass("hide");
	$('.email').show();
	$('.email2').addClass("hide");
	$('.mobile').show();
	$('.mobile2').addClass("hide");
	$('.option').show();
	$('.option2').addClass("hide");
}
// edit contact
function editContact(id){
	// open edit input form with values
	hideAll();
	$('#name_'+id).hide();
	$('#edit_name_'+id).removeClass('hide');
	$('#email_'+id).hide();
	$('#edit_email_'+id).removeClass('hide');
	$('#mobile_'+id).hide();
	$('#edit_mobile_'+id).removeClass('hide');
	$('#option_button_'+id).hide();
	$('#save_option_button_'+id).removeClass('hide');
}
// update contact with new edit values
function updateEditContact(id){
	// get all the value
	var name = $('#edit_name_'+id).val();
	var email = $('#edit_email_'+id).val();
	var mobile = $('#edit_mobile_'+id).val();

	// update db with new edit value
	$.post(base_url+'email/updateContact',
    { name: name, email: email, mobile: mobile, id: id},
  	function(msg) {
        if(msg == 'exist'){
        	swal({
                title: "Already exist",
                type: "warning",
                timer: 2000,
                showConfirmButton: false,
                html: true
            });
        }
        else{
        	if(msg == 'success'){
	        	swal({
                    title: "Email has successfully updated",
                    type: msg,
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                });
                setTimeout(function(){
                	location.href = base_url+"email/contact";
                }, 2000);
          	}else{
          		swal({
                    title: "Something went wrong",
                    type: msg,
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                });
          	}
        }
    });
}
function cancleEditContact(id){
	$('#name_'+id).show();
	$('#edit_name_'+id).addClass('hide');
	$('#email_'+id).show();
	$('#edit_email_'+id).addClass('hide');
	$('#mobile_'+id).show();
	$('#edit_mobile_'+id).addClass('hide');
	$('#option_button_'+id).show();
	$('#save_option_button_'+id).addClass('hide');
}
// delete contact
function deleteContact(id){
	swal({
	  title: 'Are you sure?',
	  text: "You won't be able to recover this contact",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#DD6B55',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes',
	  cancelButtonText: 'No',
	  closeOnConfirm: false
	},
	function(isConfirm){
		if(isConfirm){
			$.ajax({
				url: base_url+'email/deleteContact',
				data: {id:id},
				type: 'POST',
				success: function(msg){
					if(msg == 'success'){
			        	swal({
		                    title: "Email has successfully deleted",
		                    type: msg,
		                    timer: 2000,
		                    showConfirmButton: false,
		                    html: true
		                });
		                setTimeout(function(){
		                	location.href = base_url+"email/contact";
		                }, 1000);
		          	}else{
		          		swal({
		                    title: "Something went wrong",
		                    type: msg,
		                    timer: 2000,
		                    showConfirmButton: false,
		                    html: true
		                });
		          	}

				}
			});
		}
	});
}

// group manage

function _deleteConfirmation(id, fullURL){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to recover it !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        closeOnConfirm: false
    },
    function(isConfirm){
        if(isConfirm){
            $.ajax({
                url: fullURL,
                data: {id:id},
                type: 'POST',
                success: function(msg){
                   if(msg == 'success'){
                        swal({
                            title: "Group has successfully deleted",
                            type: msg,
                            timer: 2000,
                            showConfirmButton: false,
                            html: true
                        });
                        setTimeout(function(){
                            location.href = base_url+"email/group";
                        }, 1000);
                    }else{
                        swal({
                            title: "Something went wrong",
                            type: msg,
                            timer: 2000,
                            showConfirmButton: false,
                            html: true
                        });
                    }
                }
            });
        }
    });
}
function deleteGroup(id){
    _deleteConfirmation(id,base_url+'email/deleteGroup');
}

// edit modal group open
function editGroup(id){
    $('.ms').find('option').remove();
    var email = $('#email_'+id).val();
    var emails = email.split(',');
    emails = emails.slice(0,emails.length-1);
    var value = "";
    $.ajax({
        url: base_url+'email/getEmailList',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            //console.log(data);
            for(var i=0; i< data.length; i++){
                var check='';
                if(jQuery.inArray( data[i], emails ) >= 0){
                    check = "selected=selected ";
                }
                value = value + "<option " + check + "value=" + data[i] + ">" + data[i] + "</option>";
            }
            $('.ms').append(value);
        }
    });
    
    $('#editname').val($('#group_name_'+id).val());
    $('#editId').val(id);
    $('#editModal').modal();
}

// update contact with new edit values
$('#updateEditGroup').click(function(){
    // get all the value
    var id = $('#editId').val();
    var name = $('#editname').val();
    var email = $('#editEmail').val();
    if(email){
        // update db with new edit value
        $.post(base_url+'email/updateGroup',
        { name: name, email:email, id: id},
        function(msg) {
            if(msg == 'existGroup'){
                swal({
                    title: "Group already exist",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                });
            }else if(msg == 'noEmailFound'){
                swal({
                    title: "TO create a group, you need at least one email",
                    type: "warning",
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                });
            }else{
                if(msg == 'success'){
                    swal({
                        title: "Email has successfully updated",
                        type: msg,
                        timer: 2000,
                        showConfirmButton: false,
                        html: true
                    });
                    setTimeout(function(){
                        location.reload();
                    },2000);
                }else{
                    swal({
                        title: "Something went wrong",
                        type: msg,
                        timer: 2000,
                        showConfirmButton: false,
                        html: true
                    });
                }
            }
        });
    }else{
        // email must not be empty message
        swal({
            title: "Email can not be empty",
            type: "warning",
            timer: 2000,
            showConfirmButton: false,
            html: true
        });
    }
});

// manage email
$('#manageForm').submit(function(){
    var groups = $('#groups').val();
    var contacts = $('#contacts').val();
    var subject = $('#subject').val();
    var footer = $('iframe').contents().find("body").html();
    var id = $('#userId').val();
    if(groups || contacts || subject || footer){
        $.post(base_url+'email/manageStore',
            { groups: groups, contacts:contacts, subject: subject, footer: footer, id: id },
            function(msg) {
                if(msg == "save"){
                    swal({
                        title: "Email has successfully inserted",
                        type: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        html: true
                    });
                    setTimeout(function(){
                        location.reload();
                    },2000);
                }else{
                    swal({
                        title: "Email has successfully updated",
                        type: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        html: true
                    });
                    setTimeout(function(){
                        location.reload();
                    },2000);
                }
                
            }
        );
    }
    return false;
    //alert(groups + ' ' + contacts + ' ' + subject + ' ' + footer);
    
});

// reset manage email
$('#manageReset').on("click", function(){
    var id = $('#userId').val();
    $.post(base_url+'email/manageReset',
        { id: id },
        function(msg) {
            if(msg == 'done'){
                $('.select2-selection__choice').remove();
                $('#subject').val('');
                $('iframe').contents().find("body").html('');
            }else{
                return false;
            }
        }
    ); 
    return false;
});

// file selection

$('#file').on("change", function(e){
    var file = e.target.files[0];
    var form_data = new FormData();
    form_data.append("file", file);
    $.ajax({
        url: base_url+'email/emailFileUpload',
        dataType: 'text',
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(src){
            if(src == 'error'){
                // alert as corrupted file
            }else{
                src = base_url+src;
                var name = "'" + file.name + "'";
                var data2 = '<div id="'+file.name+'" class="alert alert-success mceNonEditable">';
                data2 += '<div><a onclick="deleteFile('+name+')" class="close">×</a></div>';
                data2 += '<a href="'+src+'">'+file.name+'</a></div>';
                // delete file from storage
                data2 += '<script>function deleteFile(e){ document.getElementById(e).innerHTML="";document.getElementById(e).style.display="none"; }</script>';

                // add on email body
                $('iframe').contents().find("body").find("#email-footer").prepend(data2);
            }
        }
    });
});

$('#sendEmailForm').submit(function(){
    var to = $('#to').val();
    var from = $('#from').val();
    var subject = $('#subject').val();
    var message = $('iframe').contents().find("body").html();
    var id = $('#userId').val();
    // message filter
    var msg = message.split("<div");
    var new_message = "";
    for(var i=0; i< msg.length; i++){
        if(msg[i].startsWith('><a onclick="deleteFile')){
            var anc = msg[i].split("<a");
            msg[i] = anc[0]+'</div><a'+anc[2];
        }
        if(msg[i] != '')
            new_message += "<div"+msg[i];
        else
            new_message += msg[i];
    }
    
    console.log(new_message);
    // send email
    /*$.post(base_url+'email/sendEmail',
        { to: to, from:from, subject: subject, message: new_message, id: id },
        function(msg) {
            console.log(msg);
            //location.reload();
        }
    );*/
    return false;
});
