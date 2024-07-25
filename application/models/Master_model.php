<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master_model extends CI_Model
{
    public function get_data_tanah()
    {
        $this->db->select(
            'a.*,b.nama_proyek,
            c.kode as kode_sertifikat1,
            d.kode as kode_sertifikat2,
            e.*'
        )
            ->from('master_tanah a')
            ->join('master_proyek b', 'a.proyek_id = b.id', 'left')
            ->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left')
            ->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left')
            ->join('master_status_proyek e', 'e.id = a.status_proyek', 'left');
        $data = $this->db->get();
        return $data;
    }

    // DATATABLE MASTER TANAH START //
    public $column_search_tanah = array('a.id', 'a.nama_penjual', 'a.nama_surat_tanah1', 'a.nama_makelar', 'b.nama_proyek');
    public $column_order_tanah = array(null, 'a.id', 'a.nama_penjual', 'a.nama_surat_tanah1', 'a.nama_makelar', 'b.nama_proyek');
    public $order_tanah = array('updated_at' => 'DESC');
    private function _get_query_tanah()
    {
        $get = $this->input->get();
        $this->db->select('a.*,a.id as tanah_id,b.nama_proyek,c.kode as kode_sertifikat1,d.kode as kode_sertifikat2,e.*');
        $this->db->from('master_tanah a');
        $this->db->join('master_proyek b', 'a.proyek_id = b.id', 'left');
        $this->db->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left');
        $this->db->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');
        $this->db->join('master_status_proyek e', 'e.id = a.status_proyek', 'left');
        if (!empty($get['status_perumahan'])) {
            $this->db->where('a.status_proyek', $get['status_perumahan']);
        }
        if (!empty($get['perumahan'])) {
            $this->db->where('b.id', $get['perumahan']);
        }
        if (!empty($get['firstdate']) && !empty($get['lastdate'])) {
            $this->db->where('a.tgl_pembelian BETWEEN "' . $get['firstdate'] . '" and "' . $get['lastdate'] . '"');
        }

        $i = 0;
        foreach ($this->column_search_tanah as $item) {
            if ($get['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $get['search']['value']);
                } else {
                    $this->db->or_like($item, $get['search']['value']);
                }

                if (count($this->column_search_tanah) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($get['order'])) {
            $this->db->order_by($this->column_order_tanah[$get['order']['0']['column']], $get['order']['0']['dir']);
        } else if (isset($this->order_tanah)) {
            $order = $this->order_tanah;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function count_all_datatable_tanah()
    {
        $this->db->from('master_tanah');
        return $this->db->count_all_results();
    }
    public function count_filtered_datatable_tanah()
    {
        $this->_get_query_tanah();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_tanah_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_tanah();
        if ($get['length'] != -1) {
            $this->db->limit($get['length'], $get['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }
    // DATATABLE MASTER TANAH END //

    public function detail_tanah($id)
    {
        $this->db->select('a.*,b.nama_proyek,c.kode as kode_sertifikat1,d.kode as kode_sertifikat2,e.*');
        $this->db->from('master_tanah a');
        $this->db->join('master_proyek b', 'a.proyek_id = b.id', 'left');
        $this->db->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left');
        $this->db->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');
        $this->db->join('master_status_proyek e', 'e.id = a.status_proyek', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query;
    }
}
