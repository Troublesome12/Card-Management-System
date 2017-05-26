    
    <div class="container">
        <div class="row">
            <div class="well well-sm" style="margin-top: 10px;">
                
                <?php echo form_open('email/search',['class'=>'form-inline','method'=>'get']); ?>
                <?php echo form_input(['name'=>'search','id'=>'search', 'class'=>'form-control input-custom', 'placeholder'=>'search']); ?>
                <?php echo form_hidden('from', 'groups'); ?>
                <?php echo form_submit(['value'=>'Search', 'class'=>'btn btn-default btn-sm']); ?>  
                <?php echo anchor('email/group', 'Show All', ['class'=>'btn btn-default btn-sm']); ?>
                <?php echo form_close(); ?>

                <?php if($hasPermission) : ?>
                <div class="btn-group pull-right">      
                    <a href="#" data-toggle="collapse" data-target="#create-group" class="btn btn-default btn-sm">Create New</a>
                </div>
                <?php endif; ?>
                <div class="dropdown pull-right">
                    <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Export
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" id="groupExportPDF">PDF</a></li>
                    </ul>
                </div>
                <a href="#" id="groupPagePrint" class="btn btn-default btn-sm pull-right"><span class="fa fa-print"></span> Print</a>

            </div>
            
            <?php if($hasPermission) : ?>
            <div id="create-group" class="well collapse <?php if(validation_errors()){echo 'in';} ?>">
                <?php echo form_open('email/createGroup'); ?>
                <div class="form-group">
                    <label for="name">Group Name</label>
                        <?php echo form_input(['name'=>'name','id'=>'name', 'class'=>'form-control', 'value'=> set_value('name'), 'placeholder'=>'Name','required'=>'']); ?>
                        <?php echo form_error('name'); ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <select class="ms" multiple="multiple" name="emails[]">
                        <?php foreach ($contacts as $contact){ ?>
                            <option value="<?php echo $contact->id;?>"><?php echo $contact->email;?></option>
                        <?php }?>
                    </select>
                    <?php echo form_error('email'); ?>
                </div>
                <div class="text-right">
                 <?php echo form_submit(['value'=>'Create Group', 'class'=>'btn btn-primary']); ?>
                </div>  
                <?php echo form_close(); ?>
            </div>  
            <?php endif; ?>
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3 class="panel-title">Group List</h3>
                        </div>
                    </div>
                </div>
                <div id="printList" class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                            <tr>
                                <th class="hidden-xs">ID</th>
                                <th>Group Name</th>
                                <th>Members</th>
                                <?php if($hasPermission) : ?>
                                    <th style="text-align: center"><i class="fa fa-cog"></i></th>
                                <?php endif; ?>
                            </tr> 
                        </thead>
                        <tbody>
            
                        <?php
                        if($page == 0){ $id = 1;}
                        else{ $id = $page+1;}
                        if($groups):
                            $this->load->database();
                            foreach($groups as $group):
                        ?>
                            <tr>
                                <td align="center" class="hidden-xs"><?=$id++;?></td>
                                
                                <td>
                                    <div class="group-name">
                                        <div class="col-md-10">
                                            <span id="group_name_display_<?=$group->id;?>"><?=$group->name;?></span>
                                        </div>
                                        <input type="hidden" id="group_name_<?=$group->id;?>" value="<?=$group->name;?>">
                                    </div> 
                                </td>
                                
                                <td>
                                    <span id="email_display_<?=$group->id;?>">
                                    <?php
                                        $emails = '';
                                       $groupList = $this->db->get_where('contact_group',['group_id'=>$group->id])->result();
                                        foreach($groupList as $data):
                                            $contact = $this->db->get_where('contacts',['id'=>$data->contact_id])->row();
                                            $emails .= $contact->email.',';
                                    ?>
                                        <?=$contact->email;?><br>
            
                                    <?php endforeach ?>
                                    </span>
                                    <input type="hidden" id="email_<?=$group->id;?>" value="<?=$emails;?>">
                                </td>
                                
                                <?php if($hasPermission) : ?>
                                <td align="center">
                                    <div class="option">
                                        <button type="button" onclick="editGroup('<?=$group->id;?>')" class="btn btn-default"><i class="fa fa-pencil"></i></button>
                                        <button type="button" onclick="deleteGroup('<?=$group->id;?>')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php
                                    endforeach;
                                else:
                                    echo "<tr><td colspan='5'><h3 align='center'>No cantact information found</h3></td></tr>";
                                endif
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- edit groups modal -->
                <!-- Modal -->
                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Edit Group</h4>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                                <label for="name">Group Name</label>
                                    <?php echo form_input(['name'=>'editname','id'=>'editname', 'class'=>'form-control', 'placeholder'=>'Name','required'=>'']); ?>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <select id="editEmail" class="ms" multiple="multiple" name="editemail[]">
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="editId">
                        <div class="modal-footer">
                            <button type="button" id="updateEditGroup" class="btn btn-primary">Save Change</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      
                    </div>
                </div>
                <!-- hidden group list to print all the groups -->
                <div id="printArea" style="opacity: 0; height: 0px">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>Member</th>
                            </tr>
                        </thead>
                        <tbody id="exportTableBody" ></tbody>
                    </table>
                </div>
                <center><?php echo $links; ?></center>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('/assets/js/export/jquery.min.js'); ?>"></script>
    <!-- export table library -->
    <script src="<?php echo base_url('/assets/js/export/FileSaver/FileSaver.min.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/export/js-xlsx/xlsx.core.min.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/export/jsPDF/jspdf.min.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/export/jsPDF-AutoTable/jspdf.plugin.autotable.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/export/tableExport.min.js'); ?>"></script>
    <!-- custom script file -->
    <script src="<?php echo base_url();?>assets/js/customEmail.js"></script>

    </div> <!-- End of main-body -->    
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-6 col-sm-6 text-right">
                        <div class="footer-bottom-text">
                            <p>© <?php echo $settings->copyright; ?>. All rights reserved. Developed by <a href="https://www.flickmax.net/" target="blank">Flick Max Ltd.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootsnav.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/easejs.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/azexo_transitions.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/tweenjs.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/lucid.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/wow.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/customEmail.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/sweetalert.min.js'); ?>"></script>

        <script>
            $(window).on('load', function() {
                $(this).impulse();
            });
            new WOW().init();
        </script>
        <!-- sweet alert to show flush message -->
        <script>
            <?php if ( isset($_SESSION['message']) ) :?>
                swal({
                    title: "<?php echo $_SESSION['message']; ?>",
                    type: "<?php echo $_SESSION['type']; ?>",
                    timer: 2000,
                    showConfirmButton: false,
                    html: true
                });
            <?php endif; ?>
        </script>

        <script>
            var base_url = "<?php echo base_url();?>";
        </script> 
        <!-- custom edit and delete.. this part will be moving on customEmail.js  -->
        <script>
            // print group list
            $('#groupPagePrint').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: base_url+'email/getGroupList',
                    type: 'POST',
                    success: function(data){
                        var originalContents = document.body.innerHTML;
                        var printTable = '<table id="myTable" class="table table-striped table-bordered table-list"><thead><tr><th>Group Name</th><th>Member</th></tr></thead>';
                        printTable +='<tbody id="exportTableBody">'+data+'</tbody></table>';
                        document.body.innerHTML = printTable;
                        window.print();

                        document.body.innerHTML = originalContents;
                        location.reload();
                    }
                });
            });
            // export as pdf
            $('#groupExportPDF').click(function(){
                var x=(document.getElementById("myTable").tBodies.item(0).innerHTML).trim();
                if(x.length < 1){
                    $.ajax({
                        url: base_url+'email/getGroupList',
                        type: 'POST',
                        success: function(data){
                            $('#exportTableBody').append(data);
                            $('#myTable').tableExport({type:'pdf',escape:'false'});
                        }
                    });
                }else{
                    $('#myTable').tableExport({type:'pdf',escape:'false'});
                }
                return false;
            });

        </script>
        <script src="<?php echo base_url('assets/js/select2.min.js');?>"></script>
        <script>
            $('.ms').select2({ width: '100%' });
        </script>
    </body>
</html>