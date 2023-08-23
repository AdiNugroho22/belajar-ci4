<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li><a href="<?= base_url('admin/master-buku');?>>">Master Data Buku</a></li>
			<li class="active">Input Data Buku</li>
		</ol>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3>Input Buku</h3>
					<hr />
					<form action="<?php echo base_url('admin/simpan-buku');?>" method="post" enctype="multipart/form-data">               
                  <div class="form-group col-md-6">
							<label>Judul Buku</label>
							<input type="text" class="form-control" name="judul_buku" placeholder="Masukkan Judul Buku" required="required">
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Pengarang</label>
							<input type="text" class="form-control" name="pengarang" placeholder="Masukkan Nama Pengarang" required="required">
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Penerbit</label>
							<input type="text" class="form-control" name="penerbit" placeholder="Masukkan Nama Penerbit" required="required">
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Tahun</label>
							<input type="number" class="form-control" name="tahun" placeholder="Masukkan Tahun" required="required">
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Jumlah Eksemplar</label>
							<input type="number" class="form-control" name="jumlah_eksemplar" placeholder="Masukkan Jumlah Eksemplar" required="required">
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Kategori Buku</label>
							<Select class="form-control" name="kategori_buku" required="required">
								<option> --Pilih Kategori Buku-- </option>
								<?php
								foreach($datakategori as $data1){
								?>
								<option value="<?php echo $data1['id_kategori'];?>"><?php echo $data1['nama_kategori'];?></option>
								<?php
								}
								?>
							<Select>
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Keterangan</label>
							<input type="text" class="form-control" name="keterangan" placeholder="Masukkan Keterangan" required="required">
						</div>
						<div style="clear:both;"></div>

						<div class="form-group col-md-6">
							<label>Rak</label>
							<Select class="form-control" name="rak" required="required">
								<option> -- Pilih Rak -- </option>
								<?php
								foreach($datarak as $data2){
								?>
								<option value="<?php echo $data2['id_rak'];?>"><?php echo $data2['nama_rak'];?></option>
								<?php
								}
								?>
							<Select>
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<label>Cover Buku</label>
							<input type="file" class="form-control" name="cover_buku" accept="image/*,.jpg,.jpeg,.png">
							<i>Format file yang diizinkan : jpg, jpeg, png Maximal ukuran 1 MB</i>
						</div>
						<div style="clear:both;"></div>
						
						<div class="form-group col-md-6">
							<label>E-Book</label>
							<input type="file" class="form-control" name="e_book" accept=".pdf">
							<i>Format file yang diizinkan : pdf Maximal ukuran 10 MB</i>
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