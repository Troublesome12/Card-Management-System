$(document).ready(function() {
    $('#save').hide();
});

function copyToClipboard() {
    var aux = document.createElement("input");
    console.log($this.parent.find('p').find('a'));
    // aux.setAttribute("value", document.getElementById(elementId).innerHTML);
    // document.body.appendChild(aux);
    // aux.select();
    // document.execCommand("copy");
    // document.body.removeChild(aux);
}

$("#image-input").on('change', function(event) {
    var file = event.target.files[0];

    if(!file.type.match('image/jpeg')
        && !file.type.match('image/jpg')
        && !file.type.match('image/png')) {
        $('#image').hide('slow');
        $(this).addClass('error');
        $(this).val('');    //the tricky part is to "empty" the input file here I reset the form.
        $('#image-error').removeClass('hidden');
        
    } else {
        if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image')
                    .attr('src', e.target.result)
                    .show('slow');
                $('#edit-image')
                    .attr('src', e.target.result)
                    .show('slow');
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    }
});

$('#image-input').on('focus', function(event) {
    if($(this).hasClass('error')){
        $(this).removeClass('error');
        $('#image-error').addClass('hidden');
    }
});

$("#logo-input").on('change', function(event) {
    var file = event.target.files[0];

    if(!file.type.match('image/png')) {
        $(this).addClass('error');
        $(this).val('');    //the tricky part is to "empty" the input file here I reset the form.
        $('#image-error').removeClass('hidden');   
    } else {
        if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.logo-sample').attr('src', e.target.result);
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    }
});

$('#logo-input').on('focus', function(event) {
    if($(this).hasClass('error')){
        $(this).removeClass('error');
        $('#image-error').addClass('hidden');
    }
});

$('#cardExportExcel').click(function(){
    var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
    if(x.length < 1){
        $.ajax({
            url: base_url+'card/getCardList',
            type: 'POST'
        }).done(function(data) {
            $('#exportTableBody').append(data);
            $('#myTable').tableExport({type:'xlsx',escape:'false'});
        });
    }else{
        console.log('else');
        $('#myTable').tableExport({type:'xlsx',escape:'false'});
    } 
});

$('#cardExportCSV').click(function(){
    var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
    if(x.length < 1){
        $.ajax({
            url: base_url+'card/getCardList',
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

$('#cardExportPDF').click(function(){
    var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
    if(x.length < 1){
        $.ajax({
            url: base_url+'card/getCardList',
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
$('#print').click(function(){
    
    $.ajax({
        url: base_url+'card/getCardList',
        type: 'POST',
        success: function(data){
            $('#exportTableBody').append(data);
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = $('#printArea').html();
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    });
});

var $inputs = $('#settings_form :input');
$inputs.on('keyup change', function() {

    var dataChanged = $inputs.filter(function() {
        if ($(this).is(':checkbox')) {
            var originalValue = this.defaultChecked;
            var currentValue = this.checked;
        } else {
            var originalValue = this.defaultValue;
            var currentValue = this.value;
        }
        return originalValue != currentValue;
    }).length;    

    if (dataChanged == 0) {
        $('#save').hide('slow');
    } else { 
        $('#save').show('slow');
    }
});

function deleteUser(id) {
    swal({
        title: "Are you sure?",
        text: "All the logs & events of this user will be deleted as well",
        type: "info",
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
                data: {'id' : id }
            }).done(function() {
                location.reload();
            });        
        }
    });
}