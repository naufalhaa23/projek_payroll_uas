<?php
class Potongan_gaji extends CI_Controller{

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
    $data['title'] = 'Setting Potongan Gaji';
    $data['potongan_gaji'] = $this->penggajian_model->get_data('potongan_gaji')->result();
    $this->load->view('templates_admin/header',$data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/potongan_gaji',$data);
    $this->load->view('templates_admin/footer');
  }  

  public function tambah_data()
  {
    $data['title'] = 'Tambah Potongan Gaji';
    $data['potongan_gaji'] = $this->penggajian_model->get_data('potongan_gaji')->result();
    $this->load->view('templates_admin/header',$data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/form_potongangaji',$data);
    $this->load->view('templates_admin/footer');
  }

  public function tambah_data_aksi()
  {
    $this->_rules();
    if($this->form_validation->run() == FALSE){
        $this->tambah_data();
    }
    else{
        $potongan = $this->input->post('potongan');
        $jml_potongan = $this->input->post('jml_potongan');
        $data = array(
            'potongan' => $potongan,
            'jml_potongan' => $jml_potongan,
        );

        $this->penggajian_model->insert_data($data,'potongan_gaji');
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Data Berhasil Ditambahkan!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('admin/potongan_gaji');
    }
  }

  public function _rules()
  {
    $this->form_validation->set_rules('potongan','jenis potongan','required');
    $this->form_validation->set_rules('jml_potongan','jumlah potongan','required');
  }

  public function update_data($id)
  {
    $where = array('id_pegawai' => $id);
    $data['title'] = 'Update Potongan Gaji';
    $data['potongan_gaji'] = $this->db->query("SELECT * FROM potongan_gaji WHERE id = '$id'")->result();
    $this->load->view('templates_admin/header',$data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/update_potongangaji',$data);
    $this->load->view('templates_admin/footer');
  }

  public function update_data_aksi()
  {
    $this->_rules();

    if($this->form_validation->run() == FALSE){
        $this->update_data();
    }
    else{
        $id             = $this->input->post('id');
        $potongan       = $this->input->post('potongan');
        $jml_potongan   = $this->input->post('jml_potongan');

        $data = array(
            'potongan'          =>$potongan,
            'jml_potongan'      =>$jml_potongan,
        );
    };

    $where = array(
        'id' => $id
    );

    $this->penggajian_model->update_data('potongan_gaji', $data, $where);
    $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Data Berhasil Diupdate!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>');
        redirect('admin/potongan_gaji');
  }

  public function delete_data($id)
  {
    $where = array('id' => $id);
        $this ->penggajian_model->delete_data($where, 'potongan_gaji');
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Berhasil Dihapus!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('admin/potongan_gaji');
  }
}
?>