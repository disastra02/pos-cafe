<?php

/**
 *	App Name	: POS Kasir Pro	
 *	Developed by: Mukhlis Hidayat
 *	Website		: https://cepatonline.com
 *	Year		: 2022-2022
 */

namespace App\Controllers;

use App\Models\PenjualanMobileModel;

class Dapur_penjualan extends \App\Controllers\BaseController
{
	public function __construct()
	{

		parent::__construct();

		$this->addJs($this->config->baseURL . 'public/vendors/jquery.select2/js/select2.full.min.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/jquery.select2/css/select2.min.css');
		$this->addStyle($this->config->baseURL . 'public/vendors/jquery.select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css');
		$this->addJs($this->config->baseURL . 'public/vendors/filesaver/FileSaver.js');

		$this->addJs($this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal.css');
		$this->addStyle($this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal-loader.css');
		$this->addStyle($this->config->baseURL . 'public/vendors/jwdmodal/jwdmodal-fapicker.css');

		$this->addJs($this->config->baseURL . 'public/vendors/flatpickr/dist/flatpickr.js');
		$this->addStyle($this->config->baseURL . 'public/vendors/flatpickr/dist/flatpickr.min.css');

		// $this->addJs($this->config->baseURL . 'public/themes/modern/js/pos-kasir.js');

		$this->addStyle($this->config->baseURL . 'public/themes/modern/css/dapur-penjualan.css');
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/dapur-penjualan.js');



		$this->model = new PenjualanMobileModel;
		$this->data['title'] = 'Penjualan';
		$this->data['action'] = 'detail';
		$this->data['penjualan_detail'] = [];
	}

	public function index()
	{

		$result = $this->model->getAllGudang();
		$id_gudang_selected = '';
		foreach ($result as $val) {
			$gudang[$val['id_gudang']] = $val['nama_gudang'];
			if ($val['default_gudang'] == 'Y') {
				$id_gudang_selected = $val['id_gudang'];
			}
		}
		$this->data['gudang'] = $gudang;
		$this->data['id_gudang_selected'] = $id_gudang_selected;

		$result = $this->model->getJenisHarga();
		$jenis_harga_selected = '';
		foreach ($result as $val) {
			$jenis_harga[$val['id_jenis_harga']] = $val['nama_jenis_harga'];
			if ($val['default_harga'] == 'Y') {
				$jenis_harga_selected = $val['id_jenis_harga'];
			}
		}
		$this->data['jenis_harga'] = $jenis_harga;
		$this->data['jenis_harga_selected'] = $jenis_harga_selected;

		return view('themes/modern/dapur-penjualan', $this->data);
		// echo view('themes/modern/dapur-penjualan.php', $this->data);
	}

	private function setData()
	{
		$result = $this->model->getAllGudang();
		foreach ($result as $val) {
			$gudang[$val['id_gudang']] = $val['nama_gudang'];
		}
		$this->data['gudang'] = $gudang;

		$result = $this->model->getJenisHarga();
		$jenis_harga_selected = '';
		foreach ($result as $val) {
			$jenis_harga[$val['id_jenis_harga']] = $val['nama_jenis_harga'];
			if ($val['default_harga'] == 'Y') {
				$jenis_harga_selected = $val['id_jenis_harga'];
			}
		}
		$this->data['jenis_harga'] = $jenis_harga;
		$this->data['jenis_harga_selected'] = $jenis_harga_selected;
	}

	public function edit()
	{
		$this->hasPermission('update_all');

		$this->addJs($this->config->baseURL . 'public/themes/modern/js/dapur-penjualan-edit.js');
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/dapur-penjualan.js');

		$this->data['loading_data'] = true;
		$this->data['action'] = 'edit';
		$this->data['penjualan_detail'] = $this->model->getPenjualanById($_GET['id']);
		return view('themes/modern/dapur-penjualan', $this->data);
	}

	public function detail()
	{
		$this->addJs($this->config->baseURL . 'public/themes/modern/js/dapur-penjualan-detail.js');

		$result = $this->model->getSettingPajak();
		foreach ($result as $val) {
			$pajak[$val['param']] = $val['value'];
		}
		$this->data['pajak'] = $pajak;

		$this->data['loading_data'] = true;
		$this->data['penjualan_detail'] = $this->model->getPenjualanById($_GET['id']);
		return view('themes/modern/dapur-penjualan', $this->data);
	}

	// Penjualan
	public function getDataDTPenjualan()
	{

		$this->hasPermissionPrefix('read');

		$num_data = $this->model->countAllDataPenjualan();
		$result['draw'] = $start = $this->request->getPost('draw') ?: 1;
		$result['recordsTotal'] = $num_data;

		$query = $this->model->getListDataPenjualanDapur();
		$result['recordsFiltered'] = $query['total_filtered'];

		helper('html');
		$id_user = $this->session->get('user')['id_user'];

		$no = $this->request->getPost('start') + 1 ?: 1;
		foreach ($query['data'] as $key => &$val) {
			$status_transaksi = '';
			if ($this->model->getJumlahBarang($val['id_penjualan'], 2) == $this->model->getJumlahBarang($val['id_penjualan'])) {
				$status_transaksi = '<span class="badge text-bg-secondary">Selesai Dikirim</span>';
			} else if ($this->model->getJumlahBarang($val['id_penjualan'], 3) == $this->model->getJumlahBarang($val['id_penjualan'])) {
				$status_transaksi = '<span class="badge text-bg-success">Selesai Transaksi</span>';
			} else {
				$status_transaksi = '<span class="badge text-bg-warning">'.$this->model->getJumlahBarang($val['id_penjualan'], 100).' Pesanan</span> &nbsp; <span class="badge text-bg-success">'.$this->model->getJumlahBarang($val['id_penjualan'], 1).' Selesai</span>';
			}

			$val['no_invoice'] = $val['no_invoice'] . '<span style="display:none" class="invoice-detail">' . json_encode($val) . '</span>';
			$val['nama_customer'] = $val['nama_customer'] ?: '-';
			$exp = explode(' ', $val['tgl_invoice']);
			// $val['tgl_invoice'] = '<div class="text-end">' . format_tanggal($exp[0]) . '</div>';
			$split = explode('-', $exp[0]);
			$val['tgl_invoice'] = '<div class="text-end text-nowrap">' . $split[2] . '-' . $split[1] . '-' . $split[0] . '</div>';
			$val['sub_total'] = '<div class="text-end">' . format_number($val['sub_total']) . '</div>';
			$val['neto'] = '<div class="text-end">' . format_number($val['neto']) . '</div>';
			$val['id_meja'] = '<div class="text-center">' . $val['id_meja'] . '</div>';
			$val['ignore_status_pesanan'] = '<div class="text-center">'.$status_transaksi.'</div>';
			$val['total_diskon_item'] = '<div class="text-end">' . format_number($val['total_diskon_item']) . '</div>';
			$val['kurang_bayar'] = '<div class="text-end">' . format_number($val['kurang_bayar']) . '</div>';

			$val['ignore_urut'] = $no;
			$val['ignore_action'] = '<div class="btn-action-group">' .
				btn_link(['url' => base_url() . '/penjualan/edit?id=' . $val['id_penjualan'], 'label' => '', 'icon' => 'fas fa-edit', 'attr' => ['target' => '_blank', 'class' => 'btn btn-success btn-xs me-1', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Edit Data']]) .
				btn_label(['label' => '', 'icon' => 'fas fa-times', 'attr' => ['class' => 'btn btn-danger btn-xs del-penjualan', 'data-id' => $val['id_penjualan'], 'data-delete-message' => 'Hapus data penjualan ?', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Delete Data']]) .
				'</div>';

			$attr_btn_email = ['label' => '', 'icon' => 'fas fa-paper-plane', 'attr' => ['data-url' => base_url() . '/penjualan/invoicePdf?email=Y&id=' . $val['id_penjualan'], 'data-id' => $val['id_penjualan'], 'class' => 'btn btn-primary btn-xs kirim-email']];
			if ($val['email']) {
				$attr_btn_email['attr']['data-bs-toggle'] = 'tooltip';
				$attr_btn_email['attr']['data-bs-title'] = 'Kirim Invoice ke Email';
			} else {
				$attr_btn_email['attr']['disabled'] = 'disabled';
				$attr_btn_email['attr']['class'] = $attr_btn_email['attr']['class'] . ' disabled';
			}

			$url_nota = base_url() . '/penjualan/printNota?id=' . $val['id_penjualan'];
			$val['ignore_invoice'] = '<div class="btn-action-group">'
				. btn_link(['url' => $url_nota, 'label' => '', 'icon' => 'fas fa-print', 'attr' => ['data-url' => $url_nota, 'class' => 'btn btn-secondary btn-xs print-nota me-1', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Print Nota']])
				. btn_link(['url' => base_url() . '/penjualan/invoicePdf?id=' . $val['id_penjualan'], 'label' => '', 'icon' => 'fas fa-file-pdf', 'attr' => ['data-filename' => 'Invoice-' . $val['no_invoice'], 'target' => '_blank', 'class' => 'btn btn-danger btn-xs save-pdf me-1', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Download Invoice (PDF)']])
				. btn_label($attr_btn_email)
				. '</div>';
			$no++;
		}

		$result['data'] = $query['data'];
		echo json_encode($result);
		exit();
	}

    public function ajaxSaveUpdateStatus()
	{
		$model = new \App\Models\PenjualanMobileModel;
		$result = $model->saveUpdateStatus();
		echo json_encode($result);
	}
}
