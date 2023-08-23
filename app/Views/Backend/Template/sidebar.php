<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
   
    <ul class="nav menu">
        <li class="<?php if($page=="dashboard-admin") echo "active"; else echo "";?>"><a href="<?= base_url('admin/dashboard-admin');?>"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
        <li class="<?php if($page=="master-admin" || $page=="edit-admin" || $page=="input-admin") echo "active"; else echo "";?>"><a href="<?= base_url('admin/master-admin');?>"><span class="glyphicon glyphicon-briefcase"></span> Master Data Admin</a></li>
        <li class="<?php if($page=="master-buku" || $page=="edit-buku" || $page=="input-buku") echo "active"; else echo "";?>"><a href="<?= base_url('admin/master-buku');?>"><span class="glyphicon glyphicon-briefcase"></span> Master Data Buku</a></li>
        <li class="<?php if($page=="master-anggota" || $page=="edit-anggota" || $page=="input-anggota") echo "active"; else echo "";?>"><a href="<?= base_url('admin/master-anggota');?>"><span class="glyphicon glyphicon-briefcase"></span> Master Data Anggota</a></li>
        <li class="<?php if($page=="master-kategori" || $page=="edit-kategori" || $page=="input-kategori") echo "active"; else echo "";?>"><a href="<?= base_url('admin/master-kategori');?>"><span class="glyphicon glyphicon-briefcase"></span> Master Data Kategori</a></li>
        <li class="<?php if($page=="master-rak" || $page=="edit-rak" || $page=="input-rak") echo "active"; else echo "";?>"><a href="<?= base_url('admin/master-rak');?>"><span class="glyphicon glyphicon-briefcase"></span> Master Data Rak</a></li>
        <li class="parent ">
            <a href="#">
                <span class="glyphicon glyphicon-flash"></span> Transaksi <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
            </a>
            <ul class="children collapse" id="sub-item-1">
                <li>
                    <a class="" href="<?= base_url('admin/data-transaksi-peminjaman');?>">
                        <span class="glyphicon glyphicon-share-alt"></span> Data Peminjaman
                    </a>
                </li>
                <li>
                    <a class="" href="<?= base_url('admin/data-transaksi-pengembalian');?>">
                        <span class="glyphicon glyphicon-share-alt"></span> Data Pengembalian
                    </a>
                </li>
                <li>
                    <a class="" href="<?= base_url('admin/peminjaman-step-1');?>">
                        <span class="glyphicon glyphicon-share-alt"></span> Input Peminjaman
                    </a>
                </li>
            </ul>
        </li>
        <li class="parent ">
            <a href="#">
                <span class="glyphicon glyphicon-file"></span> Laporan <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
            </a>
            <ul class="children collapse" id="sub-item-2">
                <li>
                    <a class="" href="<?= base_url('admin/laporan-transaksi-peminjaman');?>">
                        <span class="glyphicon glyphicon-share-alt"></span> Laporan Peminjaman
                    </a>
                </li>
                <li>
                    <a class="" href="<?= base_url('admin/laporan-transaksi-pengembalian');?>">
                        <span class="glyphicon glyphicon-share-alt"></span> Laporan Pengembalian
                    </a>
                </li>
            </ul>
        </li>
        <li role="presentation" class="divider"></li>
        <li><a href="<?= base_url('admin/logout');?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
    <div class="attribution">Template by <a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/">Medialoot</a></div>
</div><!--/.sidebar--> 