<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Kategori;
use App\Models\M_Rak;

class Admin extends BaseController
{
    public function antiinjection($data)
    {
        $filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
        return $filter_sql;
    }

    public function index()
    {
        return view('Backend/Login/login');
    }

    public function cek_login_admin()
    {
        $modeladmin = new M_Admin;
        $username = $this->antiinjection($this->request->getPost('username'));
        $password = $this->antiinjection($this->request->getPost('password'));

        $sqlCek = $modeladmin->getDataAdmin(['username_admin' => $username]);
        $ada = $sqlCek->getNumRows();

        if($ada == 0) {
            session()->setFlashdata('error', "Gagal... Cek Kombinasi Username dan Password!!");
            ?>
            <script type="text/javascript">
                document.location = "<?php echo base_url('admin/login-admin');?>";
            </script>
            <?php
        }
        else{
            $dataAdmin = $sqlCek->getRowArray();

            $verifyPass = password_verify($password, $dataAdmin['password_admin']);
            if (!$verifyPass) {
                session()->setFlashdata('error','Gagal... Cek Kombinasi Username dan Password!!');
                ?>
                <script type="text/javascript">
                    document.location = "<?php echo base_url('admin/login-admin');?>";
                </script>
                <?php
            }
            else{

                $dataSession =[
                    'ses_id' => $dataAdmin['id_admin'],                
                    'ses_admin' => $dataAdmin['nama_admin'],
                    'ses_level' => $dataAdmin['akses_level'], 
                    'enid' => sha1($dataAdmin['id_admin'])
                ];
                session()->set($dataSession);
                ?>
                <script type="text/javascript">
                    document.location="<?php echo base_url('admin/dashboard-admin'); ?>";
                </script>
                <?php
            }
        }
    }

    public function dashboard_admin()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Dashboard Admin";

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Login/dashboard-admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function logout()
    {
        session()->remove('ses_id');
        session()->remove('ses_admin');
        session()->remove('ses_level');
        session()->remove('enid');
        session()->setFlashdata('info', 'Keluar dari Sistem!!');
        ?>
        <script>
            document.location = "<?= base_url('admin/login-admin');?>";
        </script>
        <?php 
    }

    
   //Awal Master Kategori
    public function master_kategori()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $modelKategori = new M_Kategori;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataKategori = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();

        $data['page'] = $page;
        $data['web_title'] = "Master Data Kategori Buku";
        $data['dataKategori'] = $dataKategori; // mengirim array data kategori ke view //var pemanggil foreach baris32 master

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/master-data-kategori', $data);
        echo view('Backend/Template/footer', $data);
    }

   //Awal input Kategori
    public function input_kategori()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Input Data Kategori Buku";

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/input-data-kategori', $data);
        echo view('Backend/Template/footer', $data);
    }
   // Akhir input Kategori

    public function simpan_kategori()
    {
        $modelKategori = new M_Kategori;

        $nama = $this->request->getPost('nama_kategori');

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
            $hasil = $modelKategori->autoNumber()->getRowArray();
            if(!$hasil){
                $id = "KTG001";
            }
            else{
                $kode = $hasil['id_kategori'];

                $noUrut = (int) substr($kode,-3);
                $noUrut++;
                $id = "KTG".sprintf("%03s", $noUrut);
            }

            $dataSimpan = [
                'id_kategori' => $id,
                'nama_kategori' => $nama,
                'is_delete_kategori' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $modelKategori->saveDataKategori($dataSimpan);

            session()->setFlashdata('success','Data kategori berhasil ditambahkan!!')
            ?>
            <script>
            document.location = "<?= base_url('admin/master-kategori');?>";
            </script>
            <?php
           }
    }

    public function edit_kategori()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $idEdit = $uri->getSegment(3);

        $modelKategori = new M_Kategori;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataKategori = $modelKategori->getDataKategori(['sha1(id_kategori)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataKategori['id_kategori']]);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Kategori Buku";
        $data['data_kategori'] = $dataKategori; // mengirim array data kategori ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/edit-data-kategori', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_kategori()
    {
        $modelKategori = new M_Kategori;

        $idUpdate = session()->get('idUpdate');
        $nama = $this->request->getPost('nama_kategori');

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $dataUpdate = [
            'nama_kategori' => $nama,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['id_kategori' => $idUpdate];
        $modelKategori->updateDataKategori($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success','Data Kategori Berhasil Diperbarui!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-kategori');?>";
        </script>
        <?php
        }
    }

    public function hapus_kategori()
    {
        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $modelKategori = new M_Kategori;

        $dataUpdate = [
            'is_delete_kategori' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_kategori)' => $idHapus];
        $modelKategori->updateDataKategori($dataUpdate, $whereUpdate);
        session()->setFlashdata('success','Data Kategori Berhasil dihapus!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-kategori');?>";
        </script>
        <?php
    }
    // Akhir Kategori

    //Awal Modul rak buku
    public function master_rak()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $modelRak = new M_Rak;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataRak = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

        $data['page'] = $page;
        $data['web_title'] = "Master Data Rak Buku";
        $data['dataRak'] = $dataRak; // mengirim array data kategori ke view //var pemanggil foreach baris32 master

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterRak/master-data-rak', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_rak()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Input Data Rak Buku";

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterRak/input-data-rak', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_rak()
    {
        $modelRak = new M_Rak;

        $nama = $this->request->getPost('nama_rak');

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $hasil = $modelRak->autoNumber()->getRowArray();
        if(!$hasil){
            $id = "RAK001";
        }
        else{
            $kode = $hasil['id_rak'];

            $noUrut = (int) substr($kode,-3);
            $noUrut++;
            $id = "RAK".sprintf("%03s", $noUrut);
        }

        $dataSimpan = [
            'id_rak' => $id,
            'nama_rak' => $nama,
            'is_delete_rak' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $modelRak->saveDataRak($dataSimpan);

        session()->setFlashdata('success','Data Rak berhasil ditambahkan!!')
        ?>
        <script>
        document.location = "<?= base_url('admin/master-rak');?>";
        </script>
        <?php
        }
    }

    public function edit_rak()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $idEdit = $uri->getSegment(3);

        $modelRak = new M_Rak;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataRak = $modelRak->getDataRak(['sha1(id_rak)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataRak['id_rak']]);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Rak Buku";
        $data['data_rak'] = $dataRak; // mengirim array data kategori ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterRak/edit-data-rak', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_rak()
    {
        $modelRak = new M_Rak;

        $idUpdate = session()->get('idUpdate');
        $nama = $this->request->getPost('nama_rak');

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $dataUpdate = [
            'nama_rak' => $nama,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['id_rak' => $idUpdate];
        $modelRak->updateDataRak($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success','Data Rak Berhasil Diperbarui!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-rak');?>";
        </script>
        <?php
        }
    }

    public function hapus_rak()
    {
        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $modelKategori = new M_Rak;

        $dataUpdate = [
            'is_delete_rak' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_rak)' => $idHapus];
        $modelKategori->updateDataRak($dataUpdate, $whereUpdate);
        session()->setFlashdata('success','Data Rak Berhasil dihapus!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-rak');?>";
        </script>
        <?php
    }
    //akhir modul rak

    //Awal Modul Input Admin
    public function master_admin()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $modelAdmin = new M_Admin;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataAdmin = $modelAdmin->getDataAdmin(['is_delete_admin' => '0', 'akses_level !=' => '1'])->getResultArray();

        $data['page'] = $page;
        $data['web_title'] = "Master Data Admin";
        $data['dataAdmin'] = $dataAdmin; // mengirim array data kategori ke view //var pemanggil foreach baris32 master

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAdmin/master-data-admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_admin()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Input Data Admin";

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAdmin/input-data-admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_admin()
    {
        $modelAdmin = new M_Admin;

        $nama = $this->request->getPost('nama_admin');
        $username = $this->request->getPost('username_admin');
        $akses = $this->request->getPost('akses_level');
        $sqlCek = $modelAdmin->getDataAdmin(['username_admin' => $username]);
        $cekuser = $sqlCek->getNumRows();

        if($nama =="" or $username =="" or $akses==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        elseif ($cekuser > 0) {
            session()->setFlashdata('error','Username sudah ada!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $hasil = $modelAdmin->autoNumber()->getRowArray();
        if(!$hasil){
            $id = "ADM001";
        }
        else{
            $kode = $hasil['id_admin'];

            $noUrut = (int) substr($kode,-3);
            $noUrut++;
            $id = "ADM".sprintf("%03s", $noUrut);
        }

        $dataSimpan = [
            'id_admin' => $id,
            'nama_admin' => $nama,
            'username_admin' => $username,
            'password_admin' => password_hash("adminw3b", PASSWORD_DEFAULT),
            'akses_level' => $akses,
            'is_delete_admin' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $modelAdmin->saveDataAdmin($dataSimpan);

        session()->setFlashdata('success','Data Admin berhasil ditambahkan!!')
        ?>
        <script>
        document.location = "<?= base_url('admin/master-admin');?>";
        </script>
        <?php
        }
    }
 
    public function edit_admin()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $idEdit = $uri->getSegment(3);

        $modelAdmin = new M_Admin;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataAdmin = $modelAdmin->getDataAdmin(['sha1(id_admin)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataAdmin['id_admin']]);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Admin";
        $data['data_admin'] = $dataAdmin; // mengirim array data kategori ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAdmin/edit-data-admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_admin()
    {
        $modelAdmin = new M_Admin;

        $idUpdate = session()->get('idUpdate');
        $nama = $this->request->getPost('nama_admin');
        $username = $this->request->getPost('username_admin');
        $akses = $this->request->getPost('akses_level');
        $sqlCek = $modelAdmin->getDataAdmin(['username_admin' => $username]);
        $cekuser = $sqlCek->getNumRows();

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $dataUpdate = [
            'nama_admin' => $nama,
            'akses_level' => $akses,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['id_admin' => $idUpdate];
        $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success','Data Admin Berhasil Diperbarui!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-admin');?>";
        </script>
        <?php
        }
    }

    public function hapus_admin()
    {
        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $modelAdmin = new M_Admin;

        $dataUpdate = [
            'is_delete_admin' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_admin)' => $idHapus];
        $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
        session()->setFlashdata('success','Data Admin Berhasil dihapus!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-admin');?>";
        </script>
        <?php
    }
    //Akhir Input Admin

    //Master Data Anggota
    public function master_anggota()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $modelAnggota = new M_Anggota;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataAnggota = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();

        $data['page'] = $page;
        $data['web_title'] = "Master Data Anggota";
        $data['dataAnggota'] = $dataAnggota; // mengirim array data kategori ke view //var pemanggil foreach baris32 master

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAnggota/master-data-anggota', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_anggota()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Input Data Anggota";

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAnggota/input-data-anggota', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_anggota()
    {
        $modelAnggota = new M_Anggota;

        $nama = $this->request->getPost('nama_anggota');
        $jns_agt = $this->request->getPost('jenis_anggota');
        $jns_klmn = $this->request->getPost('jenis_kelamin');
        $email = $this->request->getPost('email');
        $no_tlp = $this->request->getPost('no_tlp');
        $alamat = $this->request->getPost('alamat');
        $password = $this->request->getPost('password_anggota');
        $sqlCek = $modelAnggota->getDataAnggota(['nama_anggota' => $nama]);
        $cekuser = $sqlCek->getNumRows();

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        elseif ($cekuser > 0) {
            session()->setFlashdata('error','Username sudah ada!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $hasil = $modelAnggota->autoNumber()->getRowArray();
        if(!$hasil){
            $id = "AGT001";
        }
        else{
            $kode = $hasil['id_anggota'];

            $noUrut = (int) substr($kode,-3);
            $noUrut++;
            $id = "AGT".sprintf("%03s", $noUrut);
        }

        $dataSimpan = [
            'id_anggota' => $id,
            'nama_anggota' => $nama,
            'jenis_anggota' => $jns_agt,
            'jenis_kelamin' => $jns_klmn,
            'no_tlp' => $no_tlp,
            'alamat' => $alamat,
            'email' => $email,
            'password_anggota' => password_hash($password, PASSWORD_DEFAULT),
            'is_delete_anggota' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $modelAnggota->saveDataAnggota($dataSimpan);

        session()->setFlashdata('success','Data Anggota berhasil ditambahkan!!')
        ?>
        <script>
        document.location = "<?= base_url('admin/master-anggota');?>";
        </script>
        <?php
        }
    }
 
    public function edit_anggota()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $idEdit = $uri->getSegment(3);

        $modelAnggota = new M_Anggota;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataAnggota = $modelAnggota->getDataAnggota(['sha1(id_anggota)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataAnggota['id_anggota']]);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Anggota";
        $data['data_anggota'] = $dataAnggota; // mengirim array data kategori ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAnggota/edit-data-anggota', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_anggota()
    {
        $modelAnggota = new M_Anggota;

        $idUpdate = session()->get('idUpdate');
        $nama = $this->request->getPost('nama_anggota');
        $jns_agt = $this->request->getPost('jenis_anggota');
        $jns_klmn = $this->request->getPost('jenis_kelamin');
        $email = $this->request->getPost('email');
        $no_tlp = $this->request->getPost('no_tlp');
        $alamat = $this->request->getPost('alamat');

        if($nama ==""){
            session()->setFlashdata('error','Inputan Tidak Boleh Kosong!')
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
        }
        else{
        $dataUpdate = [
            'nama_anggota' => $nama,
            'jenis_anggota' => $jns_agt,
            'jenis_kelamin' => $jns_klmn,
            'no_tlp' => $no_tlp,
            'alamat' => $alamat,
            'email' => $email,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['id_anggota' => $idUpdate];
        $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success','Data Anggota Berhasil Diperbarui!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-anggota');?>";
        </script>
        <?php
        }
    }

    public function hapus_anggota()
    {
        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $modelAnggota = new M_Anggota;

        $dataUpdate = [
            'is_delete_anggota' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_anggota)' => $idHapus];
        $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
        session()->setFlashdata('success','Data Anggota Berhasil dihapus!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-anggota');?>";
        </script>
        <?php
    }
    //Akhir Data Anggota

    //Awal Data Buku
    public function master_buku()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $modelBuku = new M_Buku;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataBuku = $modelBuku->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])->getResultArray();

        $data['page'] = $page;
        $data['web_title'] = "Master Data Buku";
        $data['dataBuku'] = $dataBuku; // mengirim array data kategori ke view //var pemanggil foreach baris32 master

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/master-data-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_buku()
    {
        
        $modelKategori = new M_Kategori;
        $modelRak = new M_Rak;

        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['datakategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
        $data['datarak'] = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();
        $data['web_title'] = "Input Data Buku";

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/input-data-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_buku()
    {
        $modelBuku = new M_Buku;

        $judulBuku = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
        $kategoriBuku = $this->request->getPost('kategori_buku');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('rak');

        if(!$this->validate([
            'cover_buku' => 'uploaded[cover_buku]|max_size[cover_buku, 1024]|ext_in[cover_buku,jpg,jpeg,png]',
        ])){
            session()->setFlashdata('error', "Format file yang diizinkan : jpg, jpeg, png dengan maksimal ukuran 1 MB");
            return redirect()->to('/admin/input-buku')->withInput();
        }

        if(!$this->validate([
            'e_book' => 'uploaded[e_book]|max_size[e_book, 10240]|ext_in[e_book,pdf]',
        ])){
            session()->setFlashdata('error', "Format file yang diizinkan : pdf dengan maksimal ukuran 10 MB");
            return redirect()->to('/admin/input-buku')->withInput();
        }

        $coverBuku = $this->request->getFile('cover_buku');
        $ext1 = $coverBuku->getClientExtension();
        $namaFile1 = "Cover-Buku-".date("ymdHis").".".$ext1;
        $coverBuku->move('Assets/CoverBuku',$namaFile1);

        $eBook = $this->request->getFile('e_book');
        $ext2 = $eBook->getClientExtension();
        $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
        $eBook->move('Assets/E-Book',$namaFile2);

        $hasil = $modelBuku->autoNumber()->getRowArray();
        if(!$hasil){
            $id = "BKU001";
        }
        else{
            $kode = $hasil['id_buku'];

            $noUrut = (int) substr($kode, -3);
            $noUrut++;
            $id = "BKU".sprintf("%03s", $noUrut);
        }

        $dataSimpan = [
            'id_buku' => $id,
            'judul_buku' => ucwords ($judulBuku),
            'pengarang' => ucwords ($pengarang),
            'penerbit' => ucwords ($penerbit),
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlahEksemplar,
            'id_kategori' => $kategoriBuku,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'cover_buku' => $namaFile1,
            'e_book' => $namaFile2,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelBuku->saveDataBuku($dataSimpan);
        session()->setFlashdata('success', 'Data Buku Berhasil Diperbaharui!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-buku');?>";
        </script>
        <?php
   }
 
    public function edit_buku()
    {
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $idEdit = $uri->getSegment(3);

        $modelBuku = new M_Buku;
        $modelKategori = new M_Kategori;
        $modelRak = new M_Rak;
        // Mengambil data keseluruhan kategori dari table kategori di database
        $dataBuku = $modelBuku->getDataBukuJoin(['sha1(id_buku)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataBuku['id_buku']]);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Anggota";
        $data['datakategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
        $data['datarak'] = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();
        $data['data_buku'] = $dataBuku; // mengirim array data kategori ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/edit-data-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_buku()
    {
        $modelBuku = new M_Buku;

        $idUpdate = session()->get('idUpdate');
        $judulBuku = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
        $kategoriBuku = $this->request->getPost('kategori_buku');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('rak');

        if(!$this->validate([
            'cover_buku' => 'uploaded[cover_buku]|max_size[cover_buku, 1024]|ext_in[cover_buku,jpg,jpeg,png]',
        ])){
            session()->setFlashdata('error', "Format file yang diizinkan : jpg, jpeg, png dengan maksimal ukuran 1 MB");
            return redirect()->to('/admin/update-buku')->withInput();
        }

        if(!$this->validate([
            'e_book' => 'uploaded[e_book]|max_size[e_book, 10240]|ext_in[e_book,pdf]',
        ])){
            session()->setFlashdata('error', "Format file yang diizinkan : pdf dengan maksimal ukuran 10 MB");
            return redirect()->to('/admin/update-buku')->withInput();
        }

        $coverBuku = $this->request->getFile('cover_buku');
        $ext1 = $coverBuku->getClientExtension();
        $namaFile1 = "Cover-Buku-".date("ymdHis").".".$ext1;
        $coverBuku->move('Assets/CoverBuku',$namaFile1);

        $eBook = $this->request->getFile('e_book');
        $ext2 = $eBook->getClientExtension();
        $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
        $eBook->move('Assets/E-Book',$namaFile2);

        $dataUpdate = [
            'judul_buku' => ucwords ($judulBuku),
            'pengarang' => ucwords ($pengarang),
            'penerbit' => ucwords ($penerbit),
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlahEksemplar,
            'id_kategori' => $kategoriBuku,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'cover_buku' => $namaFile1,
            'e_book' => $namaFile2,
            'is_delete_buku' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['id_buku' => $idUpdate];
        $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success','Data Buku Berhasil Diperbarui!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-buku');?>";
        </script>
        <?php

        }

    public function hapus_buku()
    {
        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $modelBuku = new M_Buku;

        $dataUpdate = [
            'is_delete_buku' => '1',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $whereUpdate = ['sha1(id_buku)' => $idHapus];
        $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);
        session()->setFlashdata('success','Data Buku Berhasil dihapus!!');
        ?>
        <script> 
        document.location = "<?= base_url('admin/master-buku');?>";
        </script>
        <?php
    }
    //Akhir Data Buku
}