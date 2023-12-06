<?php

class Laporan_absensi extends CI_Controller{

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
        $data['title'] = "Laporan Absensi";
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/filter_laporanabsensi',$data);
        $this->load->view('templates_admin/footer');
    }
    
    public function cetak_laporanabsensi()
    {
        $data['title'] = "Cetak Laporan Absensi";

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        if ($bulan === null || $bulan === '') {
            $bulan = date('m');
        }

        if ($tahun === null || $tahun === '') {
            $tahun = date('Y');
        }

        $bulantahun = $bulan . $tahun;


        
        $data['laporan_kehadiran'] = $this->db->query("SELECT * FROM data_kehadiran WHERE bulan = '$bulantahun' ORDER BY nama_pegawai ASC")->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('admin/cetak_laporanabsensi',$data);
    } 
}

?>