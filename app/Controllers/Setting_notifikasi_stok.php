<?php

/**
 *	App Name	: POS Kasir Pro	
 *	Developed by: Mukhlis Hidayat
 *	Website		: https://cepatonline.com
 *	Year		: 2022-2022
 */

namespace App\Controllers;

use App\Models\SettingNotifikasiStokModel;

class Setting_notifikasi_stok extends \App\Controllers\BaseController
{
	public function __construct()
	{

		parent::__construct();

		$this->model = new SettingNotifikasiStokModel;
		$this->data['title'] = 'Setting Notifikasi Stok';

		helper(['cookie', 'form']);
	}

	public function index()
	{

		if (!empty($_POST['submit'])) {
			$error = $this->validateFormSetting();
			if ($error) {
				$this->data['message'] = ['status' => 'error', 'message' => $error];
			} else {
				$message = $this->model->saveSetting();
				$this->data['message'] = $message;
			}
		}

		$setting = $this->model->getSettingNotifikasiPiutang();
		$setting_notifikasi = [];
		foreach ($setting as $val) {
			$setting_notifikasi[$val['param']] = $val['value'];
		}

		$this->data['setting_notifikasi'] = $setting_notifikasi;
		$this->view('setting-notifikasi-stok-form.php', $this->data);
	}

	private function validateFormSetting()
	{

		$validation =  \Config\Services::validation();
		$validation->setRule('notifikasi_show', 'Tampilkan Notifikasi', 'trim|required');
		$validation->withRequest($this->request)->run();
		$form_errors = $validation->getErrors();

		return $form_errors;
	}
}
