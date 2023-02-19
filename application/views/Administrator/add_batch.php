<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch Serial  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="batchname" name="batchname" placeholder="batch Name" value="" class="col-xs-10 col-sm-4" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="submit()" name="btnSubmit">
						Submit
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
			</div>
		</div>
		
</div>
</div>
</div>


			
<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<div class="table-header">
			Batch Information
		</div>

		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
		<div id="saveResult">
			<table id="dynamic-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</th>
						<th>SL No</th>
						<th>batch Name</th>
						<th>Action</th>
						<th></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php 
					$query = $this->db->query("SELECT * FROM tbl_batch");
					$row = $query->result();
					 ?>
					<?php $i=1; foreach($row as $row){ ?>
					<tr>
						<td class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td><?php echo $i++; ?></td>
						<td><a href="#"><?php echo $row->Batch_Serial; ?></a></td>
						<td>
						<div class="hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="ace-icon fa fa-search-plus bigger-130"></i>
								</a>

								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a class="green" href="<?php echo base_url() ?>batchedit/<?php echo $row->id; ?>" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" href="#" onclick="deleted(<?php echo $row->id; ?>)">
									<i class="ace-icon fa fa-trash-o bigger-130"></i>
								</a>
								<?php }?>
							</div>
						</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ"><?php //echo $row->ProductCategory_Name; ?></span>
						</td>

						<td></td>
					</tr>
					
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
    function submit(){
        var batchname= $("#batchname").val();
        if(batchname==""){
            $("#batchname").css("border-color","red");
            return false;
        }
        var inputdata = 'batchname='+batchname;
        var urldata = "<?php echo base_url(); ?>insertbatch";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
				if(data=="false"){
					 alert("This Name Allready Exists");
				}else{
					alert("Save Success");
					location.reload();
				}
            }
        });
    }
</script>
<script type="text/javascript">
    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
		var confirmation = confirm("are you sure you want to delete this ?");
        var urldata = "<?php echo base_url();?>batchdelete";
		if(confirmation){
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                alert("Delete Success");
				location.reload();
            }
        });
		};
    }
</script>					