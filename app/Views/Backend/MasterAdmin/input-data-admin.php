<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li><a href="<?= base_url('admin/master-admin');?>>">Master Data Admin</a></li>
			<li class="active">Input Data Admin</li>
		</ol>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3>Input Admin</h3>
					<hr />
					<form action="<?php echo base_url('admin/simpan-admin');?>" method="post">               
                  <div class="form-group col-md-6">
							<label>Nama Admin</label>
							<input type="text" class="form-control" name="nama_admin" placeholder="Masukkan Nama Admin">
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<label>Username Admin</label>
							<input type="text" class="form-control" name="username_admin" placeholder="Masukkan Username Admin">
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<label>Akses Level</label>
							<Select class="form-control" name="akses_level">
								<option> --Pilih Level-- </option>
								<option value="2">SuperAdmin</option>
								<option value="3">Admin</option>
							<Select>
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-danger">Batal</button>
						</div>
						<div style="clear:both;"></div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.row-->

</div>