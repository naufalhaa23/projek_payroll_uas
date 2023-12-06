<?php

class Ganti_password extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Ganti Password";
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('form_gantipassword',$data);
        $this->load->view('templates_admin/footer');
    }

    public function ganti_password_aksi()
    {
        $passbaru = $this->input->post('passbaru');
        $ulangpassbaru = $this->input->post('ulangpassbaru');
        $hashed_password = password_hash($passbaru, PASSWORD_DEFAULT);
        $this->form_validation->set_rules('passbaru','password baru','required|matches[ulangpassbaru]');
        $this->form_validation->set_rules('ulangpassbaru','ulangi password','required');
        

        if($this->form_validation->run() != FALSE){
            $data = array('password' => md5($passbaru));
            $id = array('id_pegawai' => $this->session->userdata('id_pegawai'));
            $this->penggajian_model->update_data('data_pegawai', $data, $id);
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>password berhasil diubah!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>');
                redirect('welcome');
        }
        else{
            $data['title'] = "Ganti Password";
            $this->load->view('templates_admin/header',$data);
            $this->load->view('templates_admin/sidebar');
            $this->load->view('form_gantipassword',$data);
            $this->load->view('templates_admin/footer');
        }
     }
}

?>