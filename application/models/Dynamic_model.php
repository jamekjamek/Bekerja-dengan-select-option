<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dynamic_model extends CI_Model
{

    public function getDataProv()
    {
        return $this->db->get('wilayah_provinsi')->result_array();
    }

    public function getDatakabupaten($idprov)
    {
        return $this->db->get_where('wilayah_kabupaten', ['provinsi_id' => $idprov])->result();
    }

    public function getDatakecamatan($idkab)
    {
        return $this->db->get_where('wilayah_kecamatan', ['kabupaten_id' => $idkab])->result();
    }

    public function getDataDesa($idkec)
    {
        return $this->db->get_where('wilayah_desa', ['kecamatan_id' => $idkec])->result();
    }

    public function create($input)
    {
        $this->db->insert('m_customer', $input);
        return $this->db->affected_rows();
    }

    public function getDataCustomer()
    {
        $this->db->select('a.id,a.nama as customer,a.alamat,b.nama as provinsi,c.nama as kabupaten, d.nama as kecamatan, e.nama as desa');
        $this->db->from('m_customer as a');
        $this->db->join('wilayah_provinsi as b', 'a.provinsi_id=b.id');
        $this->db->join('wilayah_kabupaten as c', 'a.kabupaten_id=c.id');
        $this->db->join('wilayah_kecamatan as d', 'a.kecamatan_id=d.id');
        $this->db->join('wilayah_desa as e', 'a.desa_id=e.id');
        return $this->db->get()->result_array();
    }

    public function getByIdCustomer($id)
    {
        return $this->db->get_where('m_customer', ['id' => $id])->row_array();
    }

    public function update($where, $input)
    {
        $this->db->update('m_customer', $input, $where);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->delete('m_customer', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getDataAutocomplete($autocomplete)
    {
        $this->db->select('a.id as provinsi_id, a.nama as provinsi,b.id as kabupaten_id, b.nama as kabupaten,c.id as kecamatan_id, c.nama as kecamatan,d.id as desa_id,d.nama as desa');
        $this->db->from('wilayah_provinsi as a');
        $this->db->join('wilayah_kabupaten as b', 'a.id=b.provinsi_id');
        $this->db->join('wilayah_kecamatan as c', 'b.id=c.kabupaten_id');
        $this->db->join('wilayah_desa as d', 'c.id=d.kecamatan_id');
        $this->db->like('d.nama', $autocomplete);
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }


    public function getDataAjaxRemote($perPage, $page, $search, $type)
    {
        $this->db->select('a.id as provinsi_id, a.nama as provinsi,b.id as kabupaten_id, b.nama as kabupaten,c.id as kecamatan_id, c.nama as kecamatan,d.id as desa_id,d.nama as desa');
        $this->db->from('wilayah_provinsi as a');
        $this->db->join('wilayah_kabupaten as b', 'a.id=b.provinsi_id');
        $this->db->join('wilayah_kecamatan as c', 'b.id=c.kabupaten_id');
        $this->db->join('wilayah_desa as d', 'c.id=d.kecamatan_id');
        $this->db->like('d.nama', $search);
        $this->db->limit($perPage, $page);
        $this->db->or_like('c.nama', $search);
        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function getDataByIdAjaxRemote($id, $type)
    {
        if ($type == 'kecamatan') {
            return $this->db->get_where('wilayah_desa', ['id' => $id])->row_array();
        } else if ($type == 'kabupaten') {
            return $this->db->get_where('wilayah_kecamatan', ['id' => $id])->row_array();
        } else {
            return $this->db->get_where('wilayah_kabupaten', ['id' => $id])->row_array();
        }
    }

    public function getDataKategori($perPage, $page, $search, $type)
    {
        $this->db->select('*');
        $this->db->from('m_kategori');
        $this->db->like('nama_kategori', $search);
        $this->db->limit($perPage, $page);
        if ($type == 'data') {
            return $this->db->get()->result_array();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function insertProdukKategori($data, $type)
    {
        if ($type == 'produk') {
            $this->db->insert('m_produk', $data);
            return $this->db->insert_id();
        } else {
            $this->db->insert_batch('tr_produk_to_kategori', $data);
            return $this->db->affected_rows();
        }
    }
}
