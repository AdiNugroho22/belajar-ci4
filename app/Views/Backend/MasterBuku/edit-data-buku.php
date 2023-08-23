<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li><a href="<?= base_url('admin/master-buku');?>>">Master Data Buku</a></li>
			<li class="active">Edit Data Buku</li>
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3>Edit Buku</h3>
					<hr />
					<form action="<?php echo base_url('admin/update-buku');?>" method="post" enctype="multipart/form-data">
						<div class="form-group col-md-6">
							<label>Judul Buku</label>
							<input type="text" class="form-control" name="judul_buku" placeholder="Masukkan Judul Buku" value="<?php echo $data_buku['judul_buku'];?>" required="required" >
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Pengarang</label>
							<input type="text" class="form-control" name="pengarang" placeholder="Masukkan Nama Pengarang" value="<?php echo $data_buku['pengarang'];?>" required="required" >
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Penerbit</label>
							<input type="text" class="form-control" name="penerbit" placeholder="Masukkan Nama Penerbit" value="<?php echo $data_buku['penerbit'];?>" required="required" >
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Tahun</label>
							<input type="text" class="form-control" name="tahun" placeholder="Masukkan Tahun" value="<?php echo $data_buku['tahun'];?>" required="required" >
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Jumlah Eksemplar</label>
							<input type="text" class="form-control" name="jumlah_eksemplar" placeholder="Masukkan Jumlah Eksemplar" value="<?php echo $data_buku['jumlah_eksemplar'];?>" required="required" >
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Kategori Buku</label>
							<Select class="form-control" name="kategori_buku" required="required">
								<option> --Pilih Kategori Buku-- </option>
								<?php
								foreach($datakategori as $data1){
								?>
								<option value="<?php echo $data1['id_kategori'];?>" <?php if($data_buku['id_kategori']==$data1['id_kategori']){echo "selected";} else echo "";?>><?php echo $data1['nama_kategori'];?></option>
								<?php
								}
								?>
							<Select>
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Keterangan</label>
							<input type="text" class="form-control" name="keterangan" placeholder="Masukkan Keterangan" value="<?php echo $data_buku['keterangan'];?>" required="required" >
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Kategori Buku</label>
							<Select class="form-control" name="rak" required="required">
								<option> -- Pilih Rak -- </option>
								<?php
								foreach($datarak as $data2){
								?>
								<option value="<?php echo $data2['id_rak'];?>" <?php if($data_buku['id_rak']==$data2['id_rak']){echo "selected";} else echo "";?>><?php echo $data2['nama_rak'];?></option>
								<?php
								}
								?>
							<Select>
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Cover Buku</label>
							<image src="/Assets/CoverBuku/<?php echo $data_buku['cover_buku'];?>" width="100%">
							<input type="file" class="form-control" name="cover_buku" accept="image/*,.jpg,.jpeg,.png" required>
							<i>Format file yang diizinkan : jpg, jpeg, png Maximal ukuran 1 MB</i>
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<label>E-Book</label>
							<iframe src="/Assets/E-Book/<?php echo $data_buku['e_book'];?>" width="100%" height="400"></iframe>
							<input type="file" class="form-control" name="e_book" accept=".pdf" required>
							<i>Format file yang diizinkan : pdf Maximal ukuran 10 MB</i>
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="<?php echo base_url('admin/master-buku');?>"><button type="button" class="btn btn-danger">Batal</button></a>
						</div>
						<div style="clear:both;"></div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.row-->
</div>