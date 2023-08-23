<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Master Data Anggota</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>
                        Data Anggota
                        <a href="<?= base_url('admin/input-anggota');?>">
                            <button type="button" class="btn btn-primary btn-sm pull-right"><span class="glyphicon glyphicon-plus"></span> Tambah Data Anggota</button>
                        </a>
                    </h3>
                    
                    <hr />
                    <table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-sortable="true">No</th>
                            <th data-sortable="true">Nama Anggota</th>
                            <th data-sortable="true">Jenis Anggota</th>
                            <th data-sortable="true">Jenis Kelamin</th>
                            <th data-sortable="true">Telepon</th>
                            <th data-sortable="true">Alamat</th>
                            <th data-sortable="true">Email</th>
                            <th data-sortable="true">Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 0;
                        //variable dari GetResultArray
                        foreach($dataAnggota as $data){
                        ?>
                        <tr>
                            <td data-sortable="true"><?php echo $no=$no+1;?></td>
                            <td data-sortable="true"><?php echo $data['nama_anggota'];?></td>
                            <td data-sortable="true"><?php echo $data['jenis_anggota'];?></td>
                            <td data-sortable="true"><?php echo $data['jenis_kelamin'];?></td>
                            <td data-sortable="true"><?php echo $data['no_tlp'];?></td>
                            <td data-sortable="true"><?php echo $data['alamat'];?></td>
                            <td data-sortable="true"><?php echo $data['email'];?></td>
                            <td data-sortable="true">
                                <a href="<?= base_url('admin/edit-anggota')."/".sha1($data['id_anggota']);?>" title="Edit Data">
                                    <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></button>
                                </a>

                                <a href="#" onclick="doDelete('<?= sha1($data['id_anggota']);?>')" title="Hapus Data">
                                    <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->	
</div>	<!--/.main-->

<script type="text/javascript">
    function doDelete(idDelete) {
        swal({
            title: "Hapus Data Anggota?",
            text: "Data ini akan terhapus permanen!!",
            icon: "warning",
            buttons: true,
            dangerMode: false,
        })
        .then(ok => {
            if (ok) {
                window.location.href = '<?= base_url() ?>/admin/hapus-anggota/' + idDelete;
            } else {
                $(this).removeAttr('disabled')
            }
        })
    }
</script>