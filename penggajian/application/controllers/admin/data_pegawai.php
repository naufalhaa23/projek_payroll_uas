<?php
class Data_pegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('penggajian_model');
        if($this->session->userdata('hak_akses') !='1'){
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>anda harus memasukan username dan password!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('welcome');
        }
    }

    public function index()
    {
        $data['title'] = "Data Pegawai";
        $data['pegawai'] = $this->penggajian_model->get_data('data_pegawai')->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/data_pegawai',$data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_data()
    {
        $data['title'] = "Tambah Data Pegawai";
        $data['jabatan'] = $this->penggajian_model->get_data('data_jabatan')->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/form_tambahpegawai',$data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_data_aksi()
    {
        $this->_rules();
        if($this->form_validation->run() == FALSE){
            $this->tambah_data();
        }
        else{
            $nik            = $this->input->post('nik');
            $nama_pegawai   = $this->input->post('nama_pegawai');
            $jenis_kelamin  = $this->input->post('jenis_kelamin');
            $tanggal_masuk  = $this->input->post('tanggal_masuk');
            $jabatan        = $this->input->post('jabatan');
            $status         = $this->input->post('status');
            $hak_akses      = $this->input->post('hak_akses');
            $username       = $this->input->post('username');
            $password       = md5($this->input->post('password'));
            $foto           = $_FILES['foto']['name'];
            if($foto=''){}
            else{
                $config ['upload_path'] = './assets/foto';
                $config ['allowed_types'] = 'jpg|jpeg|png|tiff';
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('foto')){
                    echo "Foto Gagal Diupload!";
                }
                else{
                    $foto=$this->upload->data('file_name');
                }
            }
            $data = array(
                'nik'           =>  $nik,
                'nama_pegawai'  =>  $nama_pegawai,
                'jenis_kelamin' =>  $jenis_kelamin,
                'jabatan'       =>  $jabatan,
                'tanggal_masuk' =>  $tanggal_masuk,
                'status'        =>  $status,
                'hak_akses'     =>  $hak_akses,
                'username'      =>  $username,
                'password'      =>  $password,
                'foto'          =>  $foto,
            );

            $this->penggajian_model->insert_data($data,'data_pegawai');
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Berhasil Ditambahkan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('admin/data_pegawai');
        }
    }

    public function update_data($id)
    {
        $where = array('id_pegawai' => $id);
        $data['title'] = 'Update Data Pegawai';
        $data['jabatan'] = $this->penggajian_model->get_data('data_jabatan')->result();
        $data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai = '$id'")->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/form_updatepegawai',$data);
        $this->load->view('templates_admin/footer');
    }

    public function update_data_aksi()
    {
        $this->_rules();
        if($this->form_validation->run() == FALSE){
            $this->update_data();
        }
        else{
            $id             = $this->input->post('id_pegawai');
            $nik            = $this->input->post('nik');
            $nama_pegawai   = $this->input->post('nama_pegawai');
            $jenis_kelamin  = $this->input->post('jenis_kelamin');
            $tanggal_masuk  = $this->input->post('tanggal_masuk');
            $jabatan        = $this->input->post('jabatan');
            $status         = $this->input->post('status');
            $hak_akses      = $this->input->post('hak_akses');
            $username       = $this->input->post('username');
            $password       = md5($this->input->post('password'));
            $foto           = $_FILES['foto']['name'];
            if($foto){
                $config ['upload_path']     = './assets/foto';
                $config ['allowed_types']   = 'jpg|jpeg|png|tiff';
                $this->load->library('upload', $config);
                if($this->upload->do_upload('foto')){
                    $foto=$this->upload->data('file_name');
                    $this->db->set('foto', $foto);
                }
                else{
                    echo $this->upload->display_errors();
                }
            }
            $data = array(
                'nik'           =>  $nik,
                'nama_pegawai'  =>  $nama_pegawai,
                'jenis_kelamin' =>  $jenis_kelamin,
                'jabatan'       =>  $jabatan,
                'tanggal_masuk' =>  $tanggal_masuk,
                'status'        =>  $status,
                'username'      =>  $username,
                'password'      =>  $password,
                'hak_akses'     =>  $hak_akses,
                'foto'          =>  $foto,
            );

            $where = array(
                'id_pegawai' => $id
            );

            $this->penggajian_model->update_data('data_pegawai',$data,$where);
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Berhasil Diupdate!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('admin/data_pegawai');
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nik','NIK','required');
        $this->form_validation->set_rules('nama_pegawai','Nama Pegawai','required');
        $this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
        $this->form_validation->set_rules('tanggal_masuk','Tanggal Masuk','required');
        $this->form_validation->set_rules('jabatan','Jabatan','required');
        $this->form_validation->set_rules('status','Status','required');
    }

    public function delete_data($id)
    {
        $where = array('id_pegawai' => $id);
        $this ->penggajian_model->delete_data($where, 'data_pegawai');
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Berhasil Dihapus!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('admin/data_pegawai');
    }
    
}


?>