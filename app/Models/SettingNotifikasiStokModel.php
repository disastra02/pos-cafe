<?php

/**
 *	App Name	: POS Kasir Pro	
 *	Developed by: Mukhlis Hidayat
 *	Website		: https://cepatonline.com
 *	Year		: 2022-2022
 */

namespace App\Models;

class SettingNotifikasiStokModel extends \App\Models\BaseModel
{
	public function getSettingNotifikasiPiutang()
	{
		$sql = 'SELECT * FROM setting WHERE type = ?';
		$result = $this->db->query($sql, 'stok')->getResultArray();
		return $result;
	}

	public function saveSetting()
	{
		$result = [];

		$data_db[] = ['type' => 'stok', 'param' => 'notifikasi_show', 'value' => $_POST['notifikasi_show']];
		$data_db[] = ['type' => 'stok', 'param' => 'dashboard_show', 'value' => $_POST['dashboard_show']];

		$this->db->transStart();
		$this->db->table('setting')->delete(['type' => 'stok']);
		$this->db->table('setting')->insertBatch($data_db);
		$this->db->transComplete();

		if ($this->db->transStatus()) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		}

		return $result;
	}
}
