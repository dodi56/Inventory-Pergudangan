<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_staff extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_login');
  }

  public function index()
  {
    $this->load->view('login/register_staff');
  }

  private function hash_password($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  public function proses_register()
  {

    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('nik', 'NIK', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
    $this->form_validation->set_rules('role', '1', 'required');

    if ($this->form_validation->run() == TRUE) {
      $username = $this->input->post('username', TRUE);
      $nik    = $this->input->post('nik', TRUE);
      $password = $this->input->post('password', TRUE);
      $role = $this->input->post('role', TRUE);

      if ($this->M_login->cek_username('user', $username)) {
        $this->session->set_flashdata('msg', 'Username Telah Digunakan');
        redirect(base_url('login/register_staff'));
      } else {
        $data = array(
          'username' => $username,
          'nik'    => $nik,
          'password' => $this->hash_password($password),
          'role' => $role
        );

        $dataUpload = array(
          'id'     => '',
          'username_user' => $username,
          'nama_file' => 'nopic2.png',
          'ukuran_file' => '6.33'
        );

        $this->M_login->insert('user', $data);
        $this->M_login->insert('tb_upload_gambar_user', $dataUpload);

        $this->session->set_flashdata('msg_terdaftar', 'Anda Berhasil Register');
        redirect(base_url('login/register_staff'));
      }
    } else {
      $this->load->view('login/register_staff');
    }
  }
}

// { ( CODINGAN VIEW ROLE PILIHAN )
//<div class="form-group" style="display:block;">
//<label for="role" style="width:73%;"> Role </label>
//<select class="form-control" name="role" style="width:11%;margin-right: 18px;">
//    <option value="1" selected=""></option>
    //                    <option value="0">User Admin</option>
//<option value="1">User Staff Gudang</option> }