<?php helper('html') ?>
<div class="card-body dashboard">
	<div class="row">
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-bg-success shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title h4"><?= !empty($total_item_terjual['jml']) ? format_number($total_item_terjual['jml'], true) : 0 ?></h5>
						<p class="card-text">Total Item Terjual</p>

					</div>
					<div class="icon">
						<!-- <i class="fas fa-clipboard-list"></i> -->
						<i class="material-icons">local_shipping</i>
					</div>
				</div>
				<div class="card-footer bg-dark">
					<div class="card-footer-left">
						<div class="icon me-2">
							<?php
							if (!empty($total_item_terjual['growth'])) {
								$class = $total_item_terjual['growth'] > 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
								echo '<i class="fas ' . $class . '"></i>';
							} else {
								$total_item_terjual = [];
								$total_item_terjual['growth'] = 0;
							}
							?>
						</div>
						<p><?= $total_item_terjual['growth'] ? round($total_item_terjual['growth']) . '%' : '-' ?></p>
					</div>
					<div class="card-footer-right">
						<p><?= !empty($list_tahun) ? max($list_tahun) : '' ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-primary shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title"><?= !empty($total_jumlah_transaksi['jml']) ? format_number($total_jumlah_transaksi['jml']) : 0 ?></h5>
						<p class="card-text">Total Transaksi</p>
					</div>
					<div class="icon">
						<!-- <i class="fas fa-shopping-cart"></i>-->
						<i class="material-icons">local_mall</i>
					</div>
				</div>
				<div class="card-footer bg-dark">
					<div class="card-footer-left">
						<div class="icon me-2">
							<?php

							if (!empty($total_jumlah_transaksi['growth'])) {
								$class = $total_jumlah_transaksi['growth'] > 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
								echo '<i class="fas ' . $class . '"></i>';
							} else {
								$total_jumlah_transaksi = [];
								$total_jumlah_transaksi['growth'] = 0;
							}
							?>
						</div>
						<p><?= $total_jumlah_transaksi['growth'] ? round($total_jumlah_transaksi['growth']) . '%' : '-' ?></p>
					</div>
					<div class="card-footer-right">
						<p><?= !empty($list_tahun) ? max($list_tahun) : '' ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-danger shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title"><?= !empty($total_nilai_penjualan['jml']) ? format_number($total_nilai_penjualan['jml']) : 0 ?></h5>
						<p class="card-text">Total Income</p>
					</div>
					<div class="icon">
						<!-- <i class="fas fa-money-bill-wave"></i> -->
						<i class="material-icons">payments</i>
					</div>
				</div>
				<div class="card-footer bg-dark">
					<div class="card-footer-left">
						<div class="icon me-2">
							<?php
							if (!empty($total_nilai_penjualan['growth'])) {
								$class = $total_nilai_penjualan['growth'] > 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
								echo '<i class="fas ' . $class . '"></i>';
							} else {
								$total_nilai_penjualan = [];
								$total_nilai_penjualan['growth'] = 0;
							}
							?>
						</div>
						<p><?= $total_nilai_penjualan['growth'] ? round($total_nilai_penjualan['growth']) . '%' : '-' ?></p>
					</div>
					<div class="card-footer-right">
						<p><?= !empty($list_tahun) ? max($list_tahun) : '' ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6 col-xs-12 mb-4">
			<div class="card text-white bg-warning shadow">
				<div class="card-body card-stats">
					<div class="description">
						<h5 class="card-title"><?= !empty($total_pelanggan_aktif['jml']) ? format_number($total_pelanggan_aktif['jml']) : 0 ?></h5>
						<p class="card-text">Total Pelanggan Aktif</p>
					</div>
					<div class="icon">
						<!-- <i class="fas fa-money-bill-wave"></i> -->
						<i class="material-icons">person</i>
					</div>
				</div>
				<div class="card-footer bg-dark">
					<div class="card-footer-left">
						<div class="icon me-2">
							<?php
							if (!empty($total_pelanggan_aktif['growth'])) {
								$class = $total_pelanggan_aktif['growth'] > 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down';
								echo '<i class="fas ' . $class . '"></i>';
							} else {
								$total_pelanggan_aktif = [];
								$total_pelanggan_aktif['growth'] = 0;
							}
							?>
						</div>
						<p><?= $total_pelanggan_aktif['growth'] ? round($total_pelanggan_aktif['growth']) . '%' : '-' ?></p>
					</div>
					<div class="card-footer-right">
						<p><?= !empty($list_tahun) ? max($list_tahun) : '' ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-md-12 col-lg-12 col-xl-8 mb-4">
			<div class="card" style="border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h6 class="card-title"><i class="fas fa-chart-line"></i> Penjualan Perbulan</h6>
					</div>
				</div>
				<div class="card-body">
					<div style="overflow: auto">
						<canvas id="bar-container" style="min-width:500px;margin:auto;width:100%"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-4 mb-4">
			<div class="card" style="height: 100%; border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title"><i class="fas fa-chart-bar"></i> Penjualan Petahun</h5>
					</div>
				</div>
				<div class="card-body" style="display:flex">
					<canvas id="chart-total-penjualan" style="margin:auto;max-width:350px;width:100%"></canvas>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-12 col-lg-12 col-xl-12 mb-4">
			<div class="card" style="border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h6 class="card-title"><i class="fas fa-chart-line"></i> Penjualan Perhari</h6>
					</div>
					<div class="card-header-end">
						<?php
							if (!empty($list_bulan)) {
								echo '<form method="get" action="" class="d-flex">
										' . options(['name' => 'perhari', 'id' => 'filter-perhari'], $list_bulan, $bulan) . '
								</form>';
							}
						?>
					</div>
				</div>
				<div class="card-body">
					<div style="overflow: auto">
						<canvas id="bar-container-perhari" style="min-width:500px;margin:auto;width:100%;height:280px;"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	if ($setting_stok['dashboard_show'] == 'Y') {
	?>
		<div class="row">
			<div class="col-md-12 col-lg-4 mb-4">
				<div class="card" style="height:100%; border-top: 3px solid #007bff;">
					<div class="card-header">
						<div class="card-header-start">
							<h5 class="card-title">Komposisi Barang</h5>
						</div>
					</div>
					<div class="card-body" style="display:flex; justify-content: center; align-items: center;">
						<div style="overflow: auto; width:100%">
							<?php
							if ($global_jml_barang) {
								echo '<canvas id="pie-container-stok" style="margin:auto"></canvas>';
							} else {
								echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
							}
							?>

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-8 mb-4">
				<div class="card" style="height:100%; border-top: 3px solid #007bff;">
					<div class="card-header">
						<div class="card-header-start">
							<h5 class="card-title">Stok Barang</h5>
						</div>
						<div class="card-header-end">
							<?= options(['name' => 'jenis_stok', 'id' => 'jenis-stok'], ['semua_barang' => 'Semua Barang', 'dibawah_stok_minimum' => 'Dibawah Stok Minimum']) ?>
						</div>
					</div>
					<div class="card-body">
						<?php
						if (!$global_jml_barang) {
							echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
						} else {

						?>
							<div class="table-responsive">
								<?php
								$settings = [];
								$column = [
									'ignore_urut' => 'No', 'nama_barang' => 'Nama Barang', 'stok_minimum' => 'Stok Min', 'stok' => 'Stok', 'ignore_action' => 'Aksi'
								];

								$settings['order'] = [3, 'asc'];
								$index = 0;
								$th = '';
								foreach ($column as $key => $val) {
									$th .= '<th>' . $val . '</th>';
									if (strpos($key, 'ignore_') !== false) {
										$settings['columnDefs'][] = ["targets" => $index, "orderable" => false];
									}
									$index++;
								}

								?>

								<table id="tabel-stok" class="table display table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<?= $th ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="<?= count($column) ?>" class="text-center">Loading data...</td>
										</tr>
									</tbody>
								</table>
								<?php
								$column_dt = [];
								foreach ($column as $key => $val) {
									$column_dt[] = ['data' => $key];
								}

								?>
								<span id="tabel-stok-column" style="display:none"><?= json_encode($column_dt) ?></span>
								<span id="tabel-stok-setting" style="display:none"><?= json_encode($settings) ?></span>
								<span id="tabel-stok-url" style="display:none"><?= base_url() . '/barang/getDataDT' ?></span>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	if ($setting_piutang['notifikasi_show'] == 'Y') { ?>
		<div class="row">
			<div class="col-md-12 col-lg-4 mb-4">
				<div class="card" style="height:100%; border-top: 3px solid #007bff;">
					<div class="card-header">
						<div class="card-header-start">
							<h5 class="card-title">Piutang Terbesar</h5>
						</div>
					</div>
					<div class="card-body d-flex">
						<?php
						if (empty($piutang_terbesar)) {
							echo '<div class="alert alert-danger w-100">Data tidak ditemukan</div>';
						} else {
						?>
							<div class="table-responsive">
								<table class="table table-border table-hover">
									<thead>
										<tr>
											<th colspan="2">Nama</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if (!empty($piutang_terbesar)) {
											foreach ($piutang_terbesar as $val) {
												if ($val['foto']) {
													$path = ROOTPATH . '/public/images/foto/' . $val['foto'];
													if (!file_exists($path)) {
														$val['foto'] = 'noimage.png';
													}
												} else {
													$val['foto'] = 'noimage.png';
												}
												echo '<tr>
														<td><img src="' . base_url() . '/public/images/foto/' . $val['foto'] . '"></td>
														<td>' . ($val['nama_customer'] ?: 'Umum') . '</td>
														<td class="text-end">' . format_number($val['total_kurang_bayar']) . '</td>
													</tr>';
											}
										}
										?>
									</tbody>
								</table>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-8 mb-4">
				<div class="card" style="height:100%; border-top: 3px solid #007bff;">
					<?php $periode_piutang = $setting_piutang['periode_penjualan_piutang']; ?>
					<div class="card-header">
						<div class="card-header-start">
							<h5 class="card-title">Piutang Jatuh Tempo</h5>
						</div>
						<div class="card-header-end">
							<?= options(['name' => 'jatuh_tempo', 'id' => 'jenis-penjualan-jatuh-tempo'], ['' => 'Semua', 'lewat_jatuh_tempo' => 'Lewat ' . $setting_piutang['piutang_periode'] . ' hari', 'akan_jatuh_tempo' => 'Jatuh tempo dalam ' . $setting_piutang['notifikasi_periode'] . ' hari'], @$setting_piutang['default_jatuh_tempo_option']) ?>
							<input type="hidden" id="piutang-jatuh-tempo-start-date" value="<?= $periode_piutang['start_date'] ?>" />
							<input type="hidden" id="piutang-jatuh-tempo-end-date" value="<?= $periode_piutang['end_date'] ?>" />
						</div>
					</div>
					<div class="card-body">
						<?php
						if (empty($penjualan)) {
							echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
						} else {

						?>
							<div class="table-responsive">
								<?php
								$settings = [];
								$column = [
									'ignore_urut' => 'No', 'nama_customer' => 'Nama Customer', 'no_invoice' => 'No. Invoice', 'tgl_penjualan' => 'Tgl. Transkasi', 'neto' => 'Neto', 'kurang_bayar' => 'Kurang'
								];

								$settings['order'] = [3, 'desc'];
								$index = 0;
								$th = '';
								foreach ($column as $key => $val) {
									$th .= '<th>' . $val . '</th>';
									if (strpos($key, 'ignore_search') !== false) {
										$settings['columnDefs'][] = ["targets" => $index, "orderable" => false];
									}
									$index++;
								}

								?>

								<table id="tabel-penjualan-tempo" class="table display table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<?= $th ?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="<?= count($column) ?>" class="text-center">Loading data...</td>
										</tr>
									</tbody>
								</table>
								<?php
								$column_dt = [];
								foreach ($column as $key => $val) {
									$column_dt[] = ['data' => $key];
								}

								?>
								<span id="penjualan-tempo-column" style="display:none"><?= json_encode($column_dt) ?></span>
								<span id="penjualan-tempo-setting" style="display:none"><?= json_encode($settings) ?></span>
								<span id="penjualan-tempo-url" style="display:none"><?= base_url() . '/dashboard/getDataDTPenjualanTempo?start_date=' . $periode_piutang['start_date'] . '&end_date=' . $periode_piutang['end_date'] . '&jatuh_tempo=' . $setting_piutang['default_jatuh_tempo_option'] ?></span>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="row">
		<div class="col-md-12 col-lg-8 mb-4">
			<div class="card" style="height:100%; border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Penjualan Barang Terbesar</h5>
					</div>
					<div class="card-header-end">
						<?php
						if (!empty($list_tahun)) {
							echo '<form method="get" action="" class="d-flex">
									' . options(['name' => 'tahun', 'id' => 'tahun-barang-terlaris'], $list_tahun, $tahun) . '
							</form>';
						}
						?>
					</div>
				</div>
				<div class="card-body">
					<?php
					if (empty($penjualan)) {
						echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
					} else {

					?>
						<div class="table-responsive">
							<?php
							$column = [
								'ignore_search_urut' => 'No', 'nama_barang' => 'Nama Barang', 'harga_satuan' => 'Harga Satuan', 'jml_terjual' => 'Jumlah', 'total_harga' => 'Total', 'kontribusi' => 'Kontribusi'
							];
							$settings = [];
							$settings['order'] = [4, 'desc'];
							$index = 0;
							$th = '';
							foreach ($column as $key => $val) {
								$th .= '<th>' . $val . '</th>';
								if (strpos($key, 'ignore_search') !== false) {
									$settings['columnDefs'][] = ["targets" => $index, "orderable" => false];
								}
								$index++;
							}

							?>

							<table id="tabel-penjualan-terbesar" class="table display table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<?= $th ?>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="<?= count($column) ?>" class="text-center">Loading data...</td>
									</tr>
								</tbody>
							</table>
							<?php
							$column_dt = [];
							foreach ($column as $key => $val) {
								$column_dt[] = ['data' => $key];
							}
							?>
							<span id="penjualan-terbesar-column" style="display:none"><?= json_encode($column_dt) ?></span>
							<span id="penjualan-terbesar-setting" style="display:none"><?= json_encode($settings) ?></span>
							<span id="penjualan-terbesar-url" style="display:none"><?= current_url() . '/getDataDTPenjualanTerbesar?tahun=' . (!empty($list_tahun) ? max($list_tahun) : 0) ?></span>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-4 mb-4">
			<div class="card" style="height:100%; border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Paling Banyak Terjual</h5>
					</div>
					<div class="card-header-end">
						<?php
						if (!empty($list_tahun)) {
							echo '<form method="get" action="" class="d-flex">
									' . options(['name' => 'tahun', 'id' => 'tahun-item-terjual'], $list_tahun, $tahun) . '
								</form>';
						}
						?>
					</div>
				</div>
				<div class="card-body" style="display:flex; justify-content: center; align-items: center;">
					<div style="overflow: auto; width:100%">
						<?php
						if (!empty($penjualan)) {
							echo '<canvas id="pie-container" style="margin:auto"></canvas>';
						} else {
							echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
						}
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-4 mb-4">
			<div class="card" style="height:100%; border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Kategori Terlaris</h5>
					</div>
					<div class="card-header-end">
						<?php
						if (!empty($list_tahun)) {
							echo '<form method="get" action="" class="d-flex">
										' . options(['name' => 'tahun', 'id' => 'tahun-kategori-terjual'], $list_tahun, $tahun) . '
									</form>';
						}
						?>
					</div>
				</div>
				<div class="card-body" style="display:flex; justify-content: center; align-items: center;">
					<div style="overflow: auto; width:100%">
						<?php
						if (!empty($penjualan)) {
							echo '<canvas id="chart-kategori" style="margin:auto"></canvas>';
						} else {
							echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-4 mb-4">
			<div class="card" style="border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Penjualan Terbesar</h5>
					</div>
					<div class="card-header-end">
						<?php
						if (!empty($list_tahun)) {
							echo '<form method="get" action="" class="d-flex">
										' . options(['name' => 'tahun', 'id' => 'tahun-kategori-terjual-detail'], $list_tahun, $tahun) . '
									</form>';
						}
						?>
					</div>
				</div>
				<div class="card-body">
					<?php
					if (empty($penjualan)) {
						echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
					} else {
					?>

						<div class="table-responsive">
							<table class="table table-border table-hover item">
								<thead>
									<tr>
										<th colspan="2">Nama Kategori</th>
										<th>Nilai</th>
									</tr>
								</thead>
								<tbody>

									<?php
									if (!empty($kategori_terjual)) {
										foreach ($kategori_terjual as $val) {
											echo '<tr>
														<td><span class="text-warning h5"><i class="fas fa-folder"></i></span></td>
														<td>' . $val['nama_kategori'] . '</td>
														<td class="text-end">' . format_number($val['nilai']) . '</td>
													</tr>';
										}
									}
									?>
								</tbody>
							</table>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-4 mb-4">
			<div class="card" style="height:100%; border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Item Terbaru</h5>
					</div>
				</div>
				<div class="card-body" style="display:flex">
					<?php
					if (empty($item_terbaru)) {
						echo '<div class="alert alert-danger">Data tidak ditemukan</div>';
					} else {
					?>

						<div class="table-responsive">
							<table class="table table-border table-hover item">
								<tr>
									<th colspan="2">Nama Barang</th>
								</tr>

								<?php
								// echo '<pre>'; print_r($item_terbaru); die;
								foreach ($item_terbaru as $val) {
									$meta_file = json_decode($val['meta_file'], true);
									$thumbnail = key_exists('thumbnail', $meta_file) ? $meta_file['thumbnail']['small']['filename'] : $val['nama_file'];
									echo '<tr>
										<td><img src="' . base_url() . '/public/files/uploads/' . $thumbnail . '"/></td>
										<td>
											<div style="position:relative" class="d-flex justify-content-between align-items-start">
												<span>' . $val['nama_barang'] . '</span><span class="badge rounded-pill bg-primary">' . $val['harga_jual'] . '</span>
												</div>
										</td>
									</tr>';
								}
								?>
							</table>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-4 mb-4">
			<div class="card" style="border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Pelanggan Terbesar</h5>
					</div>
					<div class="card-header-end">
						<?php
						if (!empty($list_tahun)) {
							echo '<form method="get" action="" class="d-flex">
										' . options(['name' => 'tahun', 'id' => 'tahun-pelanggan-terbesar'], $list_tahun, $tahun) . '
									</form>';
						}
						?>
					</div>
				</div>
				<div class="card-body" style="display:flex">
					<?php
					if (empty($pelanggan_terbesar)) {
						echo '<div class="alert alert-danger w-100">Data tidak ditemukan</div>';
					} else {
					?>
						<div class="table-responsive">
							<table class="table table-border table-hover">
								<thead>
									<tr>
										<th colspan="2">Nama</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($pelanggan_terbesar)) {
										foreach ($pelanggan_terbesar as $val) {
											if ($val['foto']) {
												$path = ROOTPATH . '/public/images/foto/' . $val['foto'];
												if (!file_exists($path)) {
													$val['foto'] = 'noimage.png';
												}
											} else {
												$val['foto'] = 'noimage.png';
											}
											echo '<tr>
													<td><img src="' . base_url() . '/public/images/foto/' . $val['foto'] . '"></td>
													<td>' . ($val['nama_customer'] ?: 'Umum') . '</td>
													<td class="text-end">' . format_number($val['total_harga']) . '</td>
												</tr>';
										}
									}
									?>
								</tbody>
							</table>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-lg-8 mb-4">
			<div class="card" style="height:100%; border-top: 3px solid #007bff;">
				<div class="card-header">
					<div class="card-header-start">
						<h5 class="card-title">Penjualan Terbaru</h5>
					</div>
					<div class="card-header-end">
						<?php
						if (!empty($list_tahun)) {
							echo '<form method="get" action="" class="d-flex">
										' . options(['name' => 'tahun', 'id' => 'tahun-penjualan-terbaru'], $list_tahun, $tahun) . '
									</form>';
						}
						?>
					</div>
				</div>
				<div class="card-body" style="display:flex">
					<?php
					if (empty($penjualan)) {
						echo '<div class="alert alert-danger w-100">Data tidak ditemukan</div>';
					} else {
					?>
						<div class="table-responsive">
							<table class="table table-border table-hover" data-export-title="Penjualan Terbaru" id="penjualan-terbaru">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Pembeli</th>
										<th>Jml. Item</th>
										<th>Nilai</th>
										<th>Tanggal Transaksi</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="6">Loading Data...</td>
									</tr>
								</tbody>
							</table>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
$data_penjualan = [];
$data_penjualan_per_hari = [];
$data_penjualan_per_hari_labels = [];
$data_total_penjualan = [];
$label_kategori = [];
$jumlah_item_kategori = [];
$jumlah = [];
$nama = [];

if (!empty($penjualan)) {
	foreach ($penjualan as $tahun => $arr) {
		foreach ($arr as $val) {
			$data_penjualan[$tahun][] = $val['total'];
		}
	}

	foreach ($penjualan_per_hari as $tahun => $arr) {
		foreach ($arr as $val) {
			$data_penjualan_per_hari[$tahun][] = $val['total'];
			$data_penjualan_per_hari_labels[] = $val['tanggal'];
		}
	}

	foreach ($total_penjualan as $tahun => $arr) {
		foreach ($arr as $val) {
			$data_total_penjualan[$tahun] = $val['total'];
		}
	}

	foreach ($item_terjual as $val) {
		$jumlah[] = $val['jml'];
		$nama[] = $val['nama_barang'];
	}

	foreach ($kategori_terjual as $val) {
		$label_kategori[] = $val['nama_kategori'];
		$jumlah_item_kategori[] = $val['jml'];
	}
}
?>

<script type="text/javascript">
	let data_penjualan = <?= json_encode($data_penjualan) ?>;
	let data_penjualan_per_hari = <?= json_encode($data_penjualan_per_hari) ?>;
	let data_penjualan_per_hari_labels = <?= json_encode($data_penjualan_per_hari_labels) ?>;
	let total_penjualan = <?= json_encode($data_total_penjualan) ?>;
	let item_terjual = <?= json_encode($jumlah) ?>;
	let item_terjual_label = <?= json_encode($nama) ?>;
	let setting_penjualan_tempo = <?= json_encode($setting_piutang) ?>;
	let setting_stok = <?= json_encode($setting_stok) ?>;
	let stok_barang = <?= !empty($global_stok_barang) ? json_encode(array_values($global_stok_barang)) : '' ?>;
	let stok_barang_label = <?= !empty($global_stok_barang) ? json_encode(['Barang Dibawah Stok Minimum', 'Barang Diatas Stok Minimum']) : '' ?>;


	function dynamicColors() {
		var r = Math.floor(Math.random() * 255);
		var g = Math.floor(Math.random() * 255);
		var b = Math.floor(Math.random() * 255);
		return "rgba(" + r + "," + g + "," + b + ", 0.8)";
	}

	let label_kategori = '<?= json_encode($label_kategori) ?>';
	let jumlah_item_kategori = '<?= json_encode($jumlah_item_kategori) ?>';
</script>