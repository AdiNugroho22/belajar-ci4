<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
            <li class="active">Master Data Rak</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>
                        Data Rak Buku
                        <a href="<?= base_url('admin/input-rak');?>">
                            <button type="button" class="btn btn-primary btn-sm pull-right"><span class="glyphicon glyphicon-plus"></span> Tambah Data Rak</button>
                        </a>
                    </h3>
                    
                    <hr />
                    <table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-sortable="true">No</th>
                            <th data-sortable="true">Nama Rak</th>
                            <th data-sortable="true">Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 0;
                        //variable dari GetResultArray
                        foreach($dataRak as $data){
                        ?>
                        <tr>
                            <td data-sortable="true"><?php echo $no=$no+1;?></td>
                            <td data-sortable="true"><?php echo $data['nama_rak'];?></td>
                            <td data-sortable="true">
                                <a href="<?= base_url('admin/edit-rak')."/".sha1($data['id_rak']);?>" title="Edit Data">
                                    <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></button>
                                </a>

                                <a href="#" onclick="doDelete('<?= sha1($data['id_rak']);?>')" title="Hapus Data">
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
            title: "Hapus Data Rak?",
            text: "Data ini akan terhapus permanen!!",
            icon: "warning",
            buttons: true,
            dangerMode: false,
        })
        .then(ok => {
            if (ok) {
                window.location.href = '<?= base_url() ?>/admin/hapus-rak/' + idDelete;
            } else {
                $(this).removeAttr('disabled')
            }
        })
    }
</script>