<?php

/**
 *	App Name	: POS Kasir Pro	
 *	Developed by: Mukhlis Hidayat
 *	Website		: https://cepatonline.com
 *	Year		: 2022-2022
 */

namespace App\Models;

class MejaModel extends \App\Models\BaseModel
{
	public function deleteData()
	{
		$result = $this->db->table('meja')->delete(['id_meja' => $_POST['id']]);
		return $result;
	}

	public function getMejaById($id)
	{
		$sql = 'SELECT * FROM meja WHERE id_meja = ?';
		$result = $this->db->query($sql, trim($id))->getRowArray();
		return $result;
	}

	public function saveData()
	{
		$data_db['nama'] = $_POST['nama'];
		$data_db['status'] = $_POST['status'] == 0 ? null : $_POST['status'];

		if ($_POST['id']) {
			$query = $this->db->table('meja')->update($data_db, ['id_meja' => $_POST['id']]);
		} else {
			$query = $this->db->table('meja')->insert($data_db);
		}

		if ($query) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		}

		return $result;
	}

	public function countAllData()
	{
		$sql = 'SELECT COUNT(*) AS jml FROM meja';
		$result = $this->db->query($sql)->getRow();
		return $result->jml;
	}

	public function getListData()
	{

		$columns = $this->request->getPost('columns');

		// Search
		$where = ' WHERE 1=1 ';
		$search_all = @$this->request->getPost('search')['value'];
		if ($search_all) {

			foreach ($columns as $val) {

				if (strpos($val['data'], 'ignore_search') !== false)
					continue;

				if (strpos($val['data'], 'ignore') !== false)
					continue;

				$where_col[] = $val['data'] . ' LIKE "%' . $search_all . '%"';
			}
			$where .= ' AND (' . join(' OR ', $where_col) . ') ';
		}

		// Order		
		$order_data = $this->request->getPost('order');
		$order = '';
		if (@strpos($_POST['columns'][$order_data[0]['column']]['data'], 'ignore_search') === false) {
			$order_by = $columns[$order_data[0]['column']]['data'] . ' ' . strtoupper($order_data[0]['dir']);
			$order = ' ORDER BY ' . $order_by;
		}

		// Query Total Filtered
		$sql = 'SELECT COUNT(*) AS jml_data FROM meja ' . $where;
		$total_filtered = $this->db->query($sql)->getRowArray()['jml_data'];

		// Query Data
		$start = $this->request->getPost('start') ?: 0;
		$length = $this->request->getPost('length') ?: 10;
		$sql = 'SELECT * FROM meja 
				' . $where . $order  . ', id_meja DESC LIMIT ' . $start . ', ' . $length;
		$data = $this->db->query($sql)->getResultArray();

		return ['data' => $data, 'total_filtered' => $total_filtered];
	}
}
