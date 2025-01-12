/**
* Written by: Mukhlis Hidayat
* Year		: 2021
* Website	: cepatonline.com
*/

jQuery(document).ready(function () {

	$('.select2').select2({ 'theme': 'bootstrap-5' });
	const column = $.parseJSON($('#dataTables-column').html());
	let url = $('#dataTables-url').text();

	const settings = {
		"processing": true,
		"serverSide": true,
		"scrollX": true,
		"ajax": {
			"url": url,
			"type": "POST",
			"dataSrc": function (json) {
				if (json.data.length) {
					for (let i = 0, len = json.data.length; i < len; i++) {
						$('#total-nilai').html(json.data[i].total.total_neto);
						// $('#total-qty').html(json.data[i].total.total_qty);
						break;
					}
				}

				if (json.recordsTotal > 0) {
					$('.btn-export').removeAttr('disabled');
				} else {
					$('.btn-export').attr('disabled', 'disabled');
				}

				return json.data;
			}
		},

		"columns": column,
		"initComplete": function (settings, json) {
			if (json.data.length == 0) {
				$('.btn-export').attr('disabled', 'disabled');
			} else {
				$('.btn-export').removeAttr('disabled');
			}
		}
	}

	let $add_setting = $('#dataTables-setting');
	if ($add_setting.length > 0) {
		add_setting = $.parseJSON($('#dataTables-setting').html());
		for (k in add_setting) {
			settings[k] = add_setting[k];
		}
	}

	let dataTables = $('#table-result').DataTable(settings);

	$('#btn-excel').click(function () {
		$this = $(this);
		$this.prop('disabled', true);
		$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
		$spinner.prependTo($this);

		start_date = $('#start-date').val();
		end_date = $('#end-date').val();
		filename = 'Penjualan Barang - ' + start_date + '_' + end_date + '.xlsx';
		url = base_url + 'laporan-penjualan-perinvoice/ajaxExportExcel?start_date=' + start_date + '&end_date=' + end_date + $('.form-laporan').serialize();
		fetch(url)
			.then(resp => resp.blob())
			.then(blob => {
				$this.prop('disabled', false);
				$spinner.remove();
				saveAs(blob, filename);
			})
			.catch((xhr) => {
				$this.prop('disabled', false);
				$spinner.remove();
				console.log(xhr);
				alert('Ajax Error')

			});
	})

	$('#btn-pdf').click(function () {
		$this = $(this);
		$this.prop('disabled', true);
		$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
		$spinner.prependTo($this);

		start_date = $('#start-date').val();
		end_date = $('#end-date').val();
		filename = 'Penjualan Barang - ' + start_date + '_' + end_date + '.pdf';
		url = base_url + 'laporan-penjualan-perinvoice/ajaxExportPdf?start_date=' + start_date + '&end_date=' + end_date + '&ajax=true' + $('.form-laporan').serialize();
		fetch(url)
			.then(resp => resp.blob())
			.then(blob => {
				$this.prop('disabled', false);
				$spinner.remove();
				saveAs(blob, filename);
			})
			.catch((xhr) => {
				$this.prop('disabled', false);
				$spinner.remove();
				console.log(xhr);
				alert('Ajax Error')

			});
	})

	$('#btn-send-email').click(function () {
		$bootbox = bootbox.dialog({
			title: 'Kirim Email',
			message: '<form method="post" class="px-2">' +
				'<div class="row mb-3">' +
				'<label class="col-sm-3 col-form-label">Email</label>' +
				'<div class="col-sm-8">' +
				'<input class="form-control" name="email" id="email-address" value="laporanpenjualan@yopmail.com"/>' +
				'</div>' +
				'</div>' +
				'<div class="row mb-3">' +
				'<label class="col-sm-3 col-form-label">Format File</label>' +
				'<div class="col-sm-8">' +
				'<select class="form-select" name="fromat_file" id="format-file"><option value="excel">Excel</option><option value="pdf">PDF</option></select>' +
				'</div>' +
				'</div>' +
				'</form>',
			buttons: {
				cancel: {
					label: 'Cancel'
				},
				success: {
					label: 'Submit',
					className: 'btn-success submit',
					callback: function () {
						var $button = $bootbox.find('button').prop('disabled', true);
						var $button_submit = $bootbox.find('button.submit');

						$bootbox.find('.alert').remove();
						$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
						$button_submit.prepend($spinner);
						$button.prop('disabled', true);

						start_date = $('#start-date').val();
						end_date = $('#end-date').val();
						$.ajax({
							type: 'GET',
							url: current_url + '/ajaxSendEmail?start_date=' + start_date + '&end_date=' + end_date + '&email=' + $('#email-address').val() + '&ajax=true&file=true&file_format=' + $('#format-file').val(),
							dataType: 'text',
							success: function (data) {
								data = $.parseJSON(data);
								console.log(data);
								$spinner.remove();
								$button.prop('disabled', false);

								if (data.status == 'ok') {
									$bootbox.modal('hide');
									const Toast = Swal.mixin({
										toast: true,
										position: 'top-end',
										showConfirmButton: false,
										timer: 2500,
										timerProgressBar: true,
										iconColor: 'white',
										customClass: {
											popup: 'bg-success text-light toast p-2'
										},
										didOpen: (toast) => {
											toast.addEventListener('mouseenter', Swal.stopTimer)
											toast.addEventListener('mouseleave', Swal.resumeTimer)
										}
									})
									Toast.fire({
										html: '<div class="toast-content"><i class="far fa-check-circle me-2"></i> Email berhasil dikirim</div>'
									})
								} else {
									Swal.fire({
										title: 'Error !!!',
										html: data.message,
										icon: 'error',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
								}
							},
							error: function (xhr) {
								console.log(xhr.responseText);
								$spinner.remove();
								$button.prop('disabled', false);
								Swal.fire({
									title: 'Error !!!',
									html: xhr.responseText,
									icon: 'error',
									showCloseButton: true,
									confirmButtonText: 'OK'
								})
							}
						})
						return false;
					}
				}
			}
		});
	})

	$('#daterange').daterangepicker({
		opens: 'right',
		ranges: {
			'Hari ini': [moment(), moment()],
			'Bulan ini': [moment().startOf('month'), moment()],
			'Tahun ini': [moment().startOf('year'), moment()],
			'7 Hari Terakhir': [moment().subtract('days', 6), moment()],
			'30 Hari Terakhir': [moment().subtract('days', 29), moment()],

		},
		showDropdowns: true,
		"linkedCalendars": false,
		locale: {
			customRangeLabel: 'Pilih Tanggal',
			format: 'DD-MM-YYYY',
			applyLabel: 'Pilih',
			separator: " s.d. ",
			"monthNames": [
				"Januari",
				"Februari",
				"Maret",
				"April",
				"Mei",
				"Juni",
				"Juli",
				"Agustus",
				"September",
				"Oktober",
				"November",
				"Desember"
			],
		}
	}, function (start, end, label) {
		start_date = start.format('YYYY-MM-DD');
		end_date = end.format('YYYY-MM-DD');
		$('#start-date').val(start_date);
		$('#end-date').val(end_date);
		load_data(start_date, end_date);

	})

	$('.form-laporan').find('select').change(function () {
		start_date = $('#start-date').val();
		end_date = $('#end-date').val();
		load_data(start_date, end_date);
	});

	function load_data(start_date, end_date) {
		$spinner_total = $('<div class="spinner-border text-secondary mt-2" style="width: 20px; height: 20px;"></div>');
		$spinner_jml = $spinner_total.clone();
		$spinner_untung_rugi = $spinner_total.clone();
		$('#total-nilai').html($spinner_total);
		$('#total-qty').html($spinner_jml);
		$('#total-untung-rugi').html($spinner_untung_rugi);

		$.ajax({
			url: base_url + 'laporan-penjualan-perinvoice/ajaxGetResumePenjualan?start_date=' + start_date + '&end_date=' + end_date + $('.form-laporan').serialize(),
			dataType: 'JSON',
			success: function (data) {
				$('#total-nilai').html(format_ribuan(data.total_neto));
				$('#total-qty').html(format_ribuan(data.total_qty.replace('.', ',')));
				$('#total-untung-rugi').html(format_ribuan(data.total_untung_rugi));
			}
		})

		settings.ajax.url = base_url + 'laporan-penjualan-perinvoice/getDataDTPenjualanPerinvoice?start_date=' + start_date + '&end_date=' + end_date + '&jenis_bayar=' + $('.form-laporan').serialize();
		// settings.ajax.url = base_url + 'laporan-penjualan-perinvoice/getDataDTPenjualanPerinvoice?' + $('.form-laporan').serialize();
		dataTables.destroy();
		len = $('#table-result').find('thead').find('th').length;
		$('#table-result').find('tbody').html('<tr>' +
			'<td colspan="' + len + '" class="text-center">Loading data...</td>' +
			'</tr>');
		dataTables = $('#table-result').DataTable(settings);

	}
});