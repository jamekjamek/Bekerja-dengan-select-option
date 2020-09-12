<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Select extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dynamic_model');
    }

    public function index()
    {
        $data['title'] = 'Data Customer';
        $data['customers'] = $this->Dynamic_model->getDataCustomer();
        $this->load->view('dynamicselect/index', $data);
    }

    public function add()
    {
        $data['provinsi'] = $this->Dynamic_model->getDataProv();
        $data['title'] = 'Tambah customer';
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('dynamicselect/getdata', $data);
        } else {
            $input = [
                'nama' => htmlspecialchars($this->input->post('nama'), true),
                'alamat' => htmlspecialchars($this->input->post('alamat'), true),
                'provinsi_id' => $this->input->post('provinsi'),
                'kabupaten_id' => $this->input->post('kabupaten'),
                'kecamatan_id' => $this->input->post('kecamatan'),
                'desa_id' => $this->input->post('desa'),
                'date_created' => time(),
                'date_modified' => time(),
            ];

            if ($this->Dynamic_model->create($input) > 0) {
                $this->session->set_flashdata('status', 'Data Barhasil di simpan');
                redirect('select');
            } else {
                $this->session->set_flashdata('status', 'server gangguan');
                redirect('select');
            };
        }
    }

    public function getKabupaten()
    {
        $kabupatenId = $this->input->post('kabupaten');
        $idprov = $this->input->post('id');
        $data = $this->Dynamic_model->getDatakabupaten($idprov);
        $output = '<option value="">--Pilih Kabupaten-- </option>';
        foreach ($data as $row) {
            if ($kabupatenId) { //edit
                if ($kabupatenId == $row->id) {
                    $output .= '<option value="' . $row->id . '" selected> ' . $row->nama . '</option>';
                } else {
                    $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
                }
            } else { //tambah
                $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function getKecamatan()
    {
        $kecamatanId = $this->input->post('kecamatan');
        $idkabupaten = $this->input->post('id');
        $data = $this->Dynamic_model->getDatakecamatan($idkabupaten);
        $output = '<option value="">--Pilih Kecamatan-- </option>';
        foreach ($data as $row) {
            if ($kecamatanId) { //edit
                if ($kecamatanId == $row->id) {
                    $output .= '<option value="' . $row->id . '" selected> ' . $row->nama . '</option>';
                } else {
                    $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
                }
            } else { //tambah
                $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function getDesa()
    {
        $desaId = $this->input->post('desa');
        $idkecamatan = $this->input->post('id');
        $data = $this->Dynamic_model->getDataDesa($idkecamatan);
        $output = '<option value="">--Pilih Desa-- </option>';
        foreach ($data as $row) {
            if ($desaId) { //edit
                if ($desaId == $row->id) {
                    $output .= '<option value="' . $row->id . '" selected> ' . $row->nama . '</option>';
                } else {
                    $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
                }
            } else { //tambah
                $output .= '<option value="' . $row->id . '"> ' . $row->nama . '</option>';
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function getById($id = null, $type = null)
    {
        if ($id && $type) {
            $data['title'] = 'Edit Data Customer';
            $data['provinsi'] = $this->Dynamic_model->getDataProv();
            $dataCustomer = $this->Dynamic_model->getByIdCustomer($id);
            if ($dataCustomer) {

                if ($type == 'edit' || $type == 'delete' || $type == 'json') {



                    if ($type == 'edit') {
                        $data['byId'] = $dataCustomer;
                        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
                        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'trim|required');
                        if ($this->form_validation->run() == FALSE) {
                            $this->load->view('dynamicselect/edit', $data);
                        } else {
                            $input = [
                                'nama' => htmlspecialchars($this->input->post('nama'), true),
                                'alamat' => htmlspecialchars($this->input->post('alamat'), true),
                                'provinsi_id' => $this->input->post('provinsi'),
                                'kabupaten_id' => $this->input->post('kabupaten'),
                                'kecamatan_id' => $this->input->post('kecamatan'),
                                'desa_id' => $this->input->post('desa'),
                                'date_modified' => time(),
                            ];

                            if ($this->Dynamic_model->update(array('id' => $this->input->post('customerId')), $input) > 0) {
                                $this->session->set_flashdata('status', 'Data Barhasil di update');
                                redirect('select');
                            } else {
                                $this->session->set_flashdata('status', 'server gangguan');
                                redirect('select');
                            };
                        }
                    } else if ($type == 'delete') {
                        if ($this->Dynamic_model->delete($id) > 0) {
                            $this->session->set_flashdata('status', 'Data Barhasil di hapus');
                            redirect('select');
                        } else {
                            $this->session->set_flashdata('status', 'server gangguan');
                            redirect('select');
                        };
                    } else {
                        //json
                        $this->output->set_content_type('application/json')->set_output(json_encode($dataCustomer));
                    }
                } else {
                    //parameter kedua
                    echo "parameter kedua salah";
                }
            } else {
                //id salah
                echo "id salah";
            }
        } else {
            //parameter kurang
            echo "parameter kurang";
        }
    }


    public function autocomplete()
    {
        $data['title'] = 'Tambah data autocomplete';
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'trim|required');
        $this->form_validation->set_rules('provinsi', 'Daerah', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('autocomplete/adddata', $data);
        } else {
            $input = [
                'nama' => htmlspecialchars($this->input->post('nama'), true),
                'alamat' => htmlspecialchars($this->input->post('alamat'), true),
                'provinsi_id' => $this->input->post('provinsi'),
                'kabupaten_id' => $this->input->post('kabupaten'),
                'kecamatan_id' => $this->input->post('kecamatan'),
                'desa_id' => $this->input->post('desa'),
                'date_created' => time(),
                'date_modified' => time(),
            ];

            if ($this->Dynamic_model->create($input) > 0) {
                $this->session->set_flashdata('status', 'Data Barhasil di simpan');
                redirect('select');
            } else {
                $this->session->set_flashdata('status', 'server gangguan');
                redirect('select');
            };
        }
    }

    public function getDataAutocomplete()
    {
        $autocomplete = $this->input->get('term');
        if ($autocomplete) {
            $getDataAutoComplete = $this->Dynamic_model->getDataAutocomplete($autocomplete);
            foreach ($getDataAutoComplete as $row) {
                $results[] = array(
                    'label' => "Provinsi " . $row['provinsi'] . ", Kabupaten " . $row['kabupaten'] . ", Kecamatan " . $row['kecamatan'] . ", Desa " . $row['desa'],
                    'provinsi' => $row['provinsi_id'],
                    'kabupaten' => $row['kabupaten_id'],
                    'kecamatan' => $row['kecamatan_id'],
                    'desa' => $row['desa_id'],
                );

                $this->output->set_content_type('application/json')->set_output(json_encode($results));
            }
        }
    }


    public function ajaxremote()
    {
        $data['title'] = 'Select2 Ajax Remote';
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'trim|required');
        $this->form_validation->set_rules('desa', 'Daerah', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('select2/ajaxremote', $data);
        } else {
            $desa = $this->input->post('desa');
            $kecamatan = $this->Dynamic_model->getDataByIdAjaxRemote($desa, 'kecamatan');
            $kabupaten = $this->Dynamic_model->getDataByIdAjaxRemote($kecamatan['kecamatan_id'], 'kabupaten');
            $provinsi = $this->Dynamic_model->getDataByIdAjaxRemote($kabupaten['kabupaten_id'], 'provinsi');
            $input = [
                'nama' => htmlspecialchars($this->input->post('nama'), true),
                'alamat' => htmlspecialchars($this->input->post('alamat'), true),
                'provinsi_id' => $provinsi['provinsi_id'],
                'kabupaten_id' => $kabupaten['kabupaten_id'],
                'kecamatan_id' => $kecamatan['kecamatan_id'],
                'desa_id' => $desa,
                'date_created' => time(),
                'date_modified' => time(),
            ];

            if ($this->Dynamic_model->create($input) > 0) {
                $this->session->set_flashdata('status', 'Data Barhasil di simpan');
                redirect('select');
            } else {
                $this->session->set_flashdata('status', 'server gangguan');
                redirect('select');
            };
        }
    }

    public function getDataAjaxRemote()
    {
        $search = $this->input->post('search');
        $page = $this->input->post('page');
        $perPage = 1;
        $results = $this->Dynamic_model->getDataAjaxRemote($perPage, $page, $search, 'data');
        $countResults = $this->Dynamic_model->getDataAjaxRemote($perPage, $page, $search, 'count');
        $selectajax = array();
        foreach ($results as $row) {
            $selectajax[] = array(
                'id' => $row['desa_id'],
                'text' => "Provinsi " . $row['provinsi'] . ", Kabupaten " . $row['kabupaten'] . ", Kecamatan " . $row['kecamatan'] . ", Desa " . $row['desa'],
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }

    public function multiple()
    {
        $data['title'] = 'Multiple Select';
        $this->form_validation->set_rules('produk', 'Produk', 'trim|required');
        $this->form_validation->set_rules('kategori[]', 'Kategori', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('multiple/select', $data);
        } else {
            $produk = $this->input->post('produk');
            $inputproduk = ['nama_produk' => $produk];
            $dataproduk = $this->Dynamic_model->insertProdukKategori($inputproduk, 'produk');
            $kategori = $this->input->post('kategori[]');
            $datainputkategori = array();
            foreach ($kategori as $key) {
                array_push($datainputkategori, array(
                    'produk_id' => $dataproduk,
                    'kategori_id' => $key
                ));
            }

            if ($this->Dynamic_model->insertProdukKategori($datainputkategori, 'kategori') > 0) {
                echo "berhasil";
            } else {
                echo "gagal";
            };
        }
    }

    public function getDataMultipleSelect()
    {
        $search = $this->input->post('search');
        $page = $this->input->post('page');
        $perPage = 10;
        $results = $this->Dynamic_model->getDataKategori($perPage, $page, $search, 'data');
        $countResults = $this->Dynamic_model->getDataKategori($perPage, $page, $search, 'count');
        $selectajax = array();
        foreach ($results as $row) {
            $selectajax[] = array(
                'id' => $row['id'],
                'text' => $row['nama_kategori']
            );
        }
        $select['total_count'] = $countResults;
        $select['items'] = $selectajax;
        $this->output->set_content_type('application/json')->set_output(json_encode($select));
    }
}
