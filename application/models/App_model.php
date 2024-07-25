<?php
defined('BASEPATH') or exit('No direct script access allowed');
class App_model extends CI_Model
{
    public function get_data_user()
    {
        $this->db->select('
            user.*,
            user.nama AS nama_user,
            user_role.nama,
            user_role.nama AS nama_role,
        ')
            ->from('user')
            ->join('user_role', 'user.id_role = user_role.id');
        $data = $this->db->get();
        return $data;
    }

    public function get_data_menu($parent = null, $role = null)
    {
        $user = get_user();
        $type = [1, 2];
        $this->db->select('
            menu.*,
            menu_access.id_role
        ')
            ->from('menu')
            ->join('menu_access', 'menu.id = menu_access.id_menu');
        if ($role) {
            $this->db->where('menu_access.id_role', $role);
        } else {
            $this->db->where('menu_access.id_role', $user->id_role);
        }
        if ($parent) {
            $this->db->where('menu.parent', $parent)
                ->where('menu.type', 3);
        } else {
            $this->db->where_in('menu.type', $type);
        }
        $data = $this->db->get();
        return $data;
    }

    public function get_master_proyek($id = null)
    {
        $this->db->select('
            desa.nama_desa,
            desa.id_kecamatan,
            kecamatan.nama_kecamatan,
            kabupaten.nama_kabupaten,
            master_proyek.*
        ')
            ->from('master_proyek')
            ->join('desa', 'master_proyek.kelurahan_id = desa.id_desa')
            ->join('kecamatan', 'desa.id_kecamatan = kecamatan.id_kecamatan')
            ->join('kabupaten', 'desa.id_kabupaten = kabupaten.id_kabupaten');
        if ($id) {
            $this->db->where('master_proyek.id', $id);
        }
        $data = $this->db->get();
        return $data;
    }

    public function get_month_data()
    {
        $month = [
            [
                'bulan' => 'Januari',
                'short' => 'Jan',
                'val' => 1
            ],
            [
                'bulan' => 'Febuari',
                'short' => 'Feb',
                'val' => 2
            ],
            [
                'bulan' => 'Maret',
                'short' => 'Mar',
                'val' => 3
            ],
            [
                'bulan' => 'April',
                'short' => 'Apr',
                'val' => 4
            ],
            [
                'bulan' => 'Mei',
                'short' => 'Mei',
                'val' => 5
            ],
            [
                'bulan' => 'Juni',
                'short' => 'Jun',
                'val' => 6
            ],
            [
                'bulan' => 'Juli',
                'short' => 'Jul',
                'val' => 7
            ],
            [
                'bulan' => 'Agustus',
                'short' => 'Agu',
                'val' => 8
            ],
            [
                'bulan' => 'September',
                'short' => 'Sep',
                'val' => 9
            ],
            [
                'bulan' => 'Oktober',
                'short' => 'Okt',
                'val' => 10
            ],
            [
                'bulan' => 'November',
                'short' => 'Nov',
                'val' => 11
            ],
            [
                'bulan' => 'Desember',
                'short' => 'Des',
                'val' => 12
            ]
        ];
        return $month;
    }

    public function get_target_proyek($proyek)
    {
        $this->db->select('
            master_proyek_target.tahun,
            master_proyek_target.group_id,
            master_proyek.nama_proyek,
            master_proyek.id,
        ')
            ->from('master_proyek_target')
            ->join('master_proyek', 'master_proyek_target.proyek_id = master_proyek.id')
            ->where('master_proyek.id', $proyek)
            ->group_by('master_proyek_target.group_id');
        $data = $this->db->get();
        return $data;
    }

    public function all_menu_in_laporan()
    {
        $data = [
            [
                'title' => 'EVALUASI PROSES DAN IJIN LOKASI TANAH',
                'menu' => [
                    [
                        'title' => 'Rincian Ijin Lokasi',
                        'color' => 'danger',
                        'url' => 'dashboard/ijin_lokasi'
                    ],
                    [
                        'title' => 'Detail Proses Ijin Lokasi',
                        'color' => 'primary',
                        'url' => 'dashboard/proses_ijin_lokasi'
                    ],

                ]
            ],

            [
                'title' => 'EVALUASI PEMBELIAN TANAH',
                'menu' => [

                    [
                        'title' => 'Rekap Evaluasi Pembelian',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_pembelian_tanah'
                    ],
                    [
                        'title' => 'Detail Evaluasi Pembelian',
                        'color' => 'primary',
                        'url' => 'dashboard/evaluasi_pembelian_tanah'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI LAND BANK',
                'menu' => [
                    [
                        'title' => 'Land Bank Rekap',
                        'color' => 'danger',
                        'url' => 'dashboard/evaluasi_landbank'
                    ],
                    [
                        'title' => 'Land Bank Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/landbank_perum'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI TANAH PROYEK BELUM SHGB',
                'menu' => [
                    [
                        'title' => 'Rekap Tanah Belum SHGB',
                        'color' => 'danger',
                        'url' => 'dashboard/evaluasi_belum_shgb'
                    ],
                    [
                        'title' => 'Tanah Belum SHGB Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/belum_shgb_perum'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI PROSES INDUK',
                'menu' => [
                    [
                        'title' => 'Rekap Proses Induk',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_data_proses_induk'
                    ],
                    [
                        'title' => 'Evaluasi Data Proses Induk',
                        'color' => 'primary',
                        'url' => 'dashboard/evaluasi_data_proses_induk'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI PENGGABUNGAN DAN REVISI SPLIT',
                'menu' => [
                    [
                        'title' => 'Rekap Penggabungan',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_revisi_split'
                    ],
                    [
                        'title' => 'Penggabungan Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/evaluasi_revisi_split'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI TANAH PROYEK SUDAH SHGB',
                'menu' => [
                    [
                        'title' => 'Rekap Tanah SHGB',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_sudah_shgb'
                    ],
                    [
                        'title' => 'Tanah SHGB Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/evaluasi_sudah_shgb'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI PROSES SPLITSING',
                'menu' => [
                    [
                        'title' => 'Rekap Splitsing',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_proses_splitsing'
                    ],
                    [
                        'title' => 'Splitsing Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/evaluasi_proses_splitsing'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI HUTANG SERT BELUM SPLIT',
                'menu' => [
                    [
                        'title' => 'Rekap Hutang Sertifikat',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_sert_perum'
                    ],
                    [
                        'title' => 'Hutang Sertifikat Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/data_sert_perum'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI STOK SPLITSING',
                'menu' => [
                    [
                        'title' => 'Rekap Stok Splitsing',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_splitsing'
                    ],
                    [
                        'title' => 'Splitsing per Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/data_splitsing'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI BALIK NAMA',
                'menu' => [
                    [
                        'title' => 'Rekap Balik Nama',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_baliknama'
                    ],
                    [
                        'title' => 'Balik Nama Per Perumahan',
                        'color' => 'primary',
                        'url' => 'dashboard/data_baliknama'
                    ],
                ]
            ],

            [
                'title' => 'EVALUASI PBB',
                'menu' => [
                    [
                        'title' => 'Rekap Evaluasi PBB',
                        'color' => 'danger',
                        'url' => 'dashboard/rekap_pbb'
                    ],
                    [
                        'title' => 'Data SPPT PBB',
                        'color' => 'primary',
                        'url' => 'dashboard/data_pbb'
                    ],
                ]
            ],

            [
                'title' => 'Laporan Penjualan',
                'menu' => [
                    [
                        'title' => 'Laporan Penjualan',
                        'color' => 'danger',
                        'url' => ''
                    ],
                ]
            ],
        ];

        return $data;
    }

    public function get_lokasi_proses_ijin()
    {
        $this->db->select('
            master_tanah.status_pengalihan,
            master_tanah.id AS id_tanah,
            master_tanah.nama_surat_tanah1,
            master_tanah.keterangan1,
            master_status_proyek.*,
            master_proyek.nama_proyek
        ')
            ->from('master_tanah')
            ->join('master_proyek', 'master_tanah.proyek_id = master_proyek.id')
            ->join('master_status_proyek', 'master_tanah.status_proyek = master_status_proyek.id');

        return $this->db->get();
    }


    //
    public function get_pembayaran_belum($date = null)
    {
        $this->db->select('
            tbl_pembayaran_tanah.tgl_pembayaran,
            tbl_pembayaran_tanah.total_bayar,
            tbl_pembayaran_tanah.ket,
            master_tanah.nama_penjual,
            master_proyek.nama_proyek,
            master_status_proyek.nama_status
        ')
            ->from('tbl_pembayaran_tanah')
            ->join('master_tanah', 'tbl_pembayaran_tanah.tanah_id = master_tanah.id')
            ->join('master_proyek', 'master_proyek.id = master_tanah.proyek_id')
            ->join('master_status_proyek', 'master_status_proyek.id = master_tanah.status_proyek')
            ->where('tbl_pembayaran_tanah.status_bayar', 1);

        if ($date) {
            $this->db->where_in('tbl_pembayaran_tanah.tgl_pembayaran', $date);
        }
        $data = $this->db->get();
        return $data;
    }
}
