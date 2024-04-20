<?php

/**
 *	App Name	: POS Kasir Pro	
 *	Developed by: Mukhlis Hidayat
 *	Website		: https://cepatonline.com
 *	Year		: 2022
 */

namespace App\Controllers;

use App\Models\MejaModel;

class Meja extends \App\Controllers\BaseController
{
	protected $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = new MejaModel;
		$this->data['site_title'] = 'Jenis Harga';
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/meja.js');
		helper('html');
	}

	public function index()
	{
		$this->hasPermission('read_all');
		$this->view('meja-result.php', $this->data);
	}

	public function ajaxGetFormData()
	{
		$this->data['form_data'] = [];
		if (isset($_GET['id'])) {
			if ($_GET['id']) {
				$this->data['form_data'] = $this->model->getMejaById($_GET['id']);
				if (!$this->data['form_data'])
					return;
			}
		}
		echo view('themes/modern/meja-form.php', $this->data);
	}

	public function ajaxUpdateData()
	{

		$message = $this->model->saveData();
		echo json_encode($message);
	}

	public function ajaxDeleteData()
	{

		$delete = $this->model->deleteData();
		if ($delete) {
			$message['status'] = 'ok';
			$message['message'] = 'Data berhasil dihapus';
		} else {
			$message['status'] = 'error';
			$message['message'] = 'Data gagal dihapus';
		}
		echo json_encode($message);
	}

	public function getDataDT()
	{

		$this->hasPermissionPrefix('read');

		$num_data = $this->model->countAllData();
		$result['draw'] = $start = $this->request->getPost('draw') ?: 1;
		$result['recordsTotal'] = $num_data;

		$query = $this->model->getListData();
		$result['recordsFiltered'] = $query['total_filtered'];

		helper('html');

		$no = $this->request->getPost('start') + 1 ?: 1;
		foreach ($query['data'] as $key => &$val) {
			$val['ignore_urut'] = $no;
			$val['status'] = $val['status'] == 1 ? '<span class="badge text-bg-danger">Aktif</span>' : '<span class="badge text-bg-success">Kosong</span>';
			$val['ignore_action'] = '<div class="form-inline btn-action-group">'
				. btn_label(
					[
						'icon' => 'fas fa-edit', 'attr' => ['class' => 'btn btn-success btn-edit btn-xs me-1', 'data-id' => $val['id_meja']], 'label' => 'Edit'
					]
				)
				. btn_label(
					[
						'icon' => 'fas fa-times', 'attr' => [
							'class' => 'btn btn-danger btn-delete btn-xs', 'data-id' => $val['id_meja'], 'data-delete-title' => 'Hapus data jenis harga : <strong>' . $val['nama'] . '</strong>'
						], 'label' => 'Delete'
					]
				) .

				'</div>';
			$no++;
		}

		$result['data'] = $query['data'];
		echo json_encode($result);
		exit();
	}
}
