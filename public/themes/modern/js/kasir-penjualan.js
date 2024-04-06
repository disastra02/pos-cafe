var statusForm = null;
function show_detail_penjualan (detail) 
{
	$spinner = $('<div class="d-flex justify-content-center text-secondary"><div class="spinner-border" role="status"></div>');
	$container = $('.right-panel-body').empty();
	$container.append($spinner);
	
	if (!detail) {
		$container.html('<div class="alert alert-danger">Data tidak ditemukan</div>');
		$spinner.remove();
		return;
	}
	
	
	$buttons = $('.right-panel-footer').find('button');
	$link = $('.right-panel-footer').find('a');
	$buttons.prop('disabled', true);
	$link.addClass('disabled');
	// $link.removeClass('link-spa');
	
	$.get(base_url + 'penjualan/detailKasir?mobile=true&id=' + detail['id_penjualan'], function (data) {
		$container.html(data);
		$spinner.remove();
		$footer_right = $('.right-panel-footer');
		
		$btn_save = $footer_right.find('.btn-save');
		$btn_save.hide();
		// $btn_save.find('.invoice-detail').remove();
		// $btn_save.append('<span style="display:none" class="invoice-detail">' + JSON.stringify(detail) + '</span>');
		$('.invoice-detail-view').html('');
		$('.invoice-detail-view').html(JSON.stringify(detail));
		
		$footer_right.find('.btn-detail').show();
		$buttons.prop('disabled', false);
		$buttons.attr('data-id', detail['id_penjualan']);
		$link.attr('data-id', detail['id_penjualan']);
		$footer_right.find('.btn-kirim-email-invoice').attr('data-email', detail['email']);	
		$footer_right.find('.btn-download-invoice-pdf').attr('data-filename', 'Invoice-' + detail['no_invoice']);	
		
		$link.prop('disabled', false);
		$link.removeClass('disabled').attr('href', base_url + 'kasir-penjualan/edit?id=' + detail['id_penjualan']);
		
		if (osRightPanel) {
			osRightPanel.destroy();
		}

		if (detail.status_transaksi == 2) {
			$('.link-edit').css('display', 'block');
		} else if (detail.status_transaksi == 3) {
			$('.link-edit').css('display', 'none');
		} else {
			$('.link-edit').css('display', 'none');
		}
		statusForm = 'detail';

		osRightPanel = OverlayScrollbars( $('.right-panel-body'), {scrollbars : {autoHide: 'leave', autoHideDelay: 100}} );
	})
}

function show_form_penjualan(id) {
	
	$spinner = $('<div class="d-flex justify-content-center text-secondary"><div class="spinner-border" role="status"></div>');
	$container = $('.right-panel-body').empty();
	$container.append($spinner);
	
	$buttons = $('.right-panel-footer').find('button');
	$link = $('.right-panel-footer').find('a');
	$buttons.prop('disabled', true);
	$link.addClass('disabled');
	

	$.get(base_url + 'penjualan/editKasirPenjualan?mobile=true&id=' + id, function (data) {

		if (!data) {
			data = '<div class="alert alert-danger">Data tidak ditemukan</div>';
			$container.html(data);
			$spinner.remove();
			return;
		}

		$container.html(data);
		$spinner.remove();
		$footer_right = $('.right-panel-footer');
		
		$footer_right.find('.btn-save').show();
		$footer_right.find('.btn-detail').hide();
		
		$buttons.prop('disabled', false);
		statusForm = 'form';

		if (osRightPanel) {
			osRightPanel.destroy();
		}
		
		if (flatpickr_instance) {
			// flatpickr_instance.destroy();
			flatpickr_instance.map(function (instance) {
				instance.destroy();
			})
		}
		flatpickr_instance = $('.flatpickr').flatpickr({
			enableTime: false,
			dateFormat: "d-m-Y",
			time_24hr: true
		});
		osRightPanel =  OverlayScrollbars( $('.right-panel-body'), {scrollbars : {autoHide: 'leave', autoHideDelay: 100}} );
	})
}

$(document).ready(function() {
	
	$(document).undelegate('.btn-download-invoice-pdf', 'click').delegate('.btn-download-invoice-pdf', 'click', function(e) 
	{
		e.preventDefault();
		$this = $(this);
		url_pdf = base_url + 'penjualan/invoicePdf?id=' + $this.attr('data-id');
		filename = $this.attr('data-filename').replace('/','_').replace('\\', '_');
		$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
		$this.prepend($spinner);
		$this.prop('disabled', true);
		
		fetch(url_pdf)
		  .then(resp => resp.blob())
		  .then(blob => {
				saveAs(blob, filename + '.pdf');
				$spinner.remove();
				$this.prop('disabled', false);
		  })
		.catch(() => alert('Ajax Error'));
	})
	
	$(document).undelegate('.btn-print-nota', 'click').delegate('.btn-print-nota', 'click', function(e) {
		e.preventDefault();
		url = base_url + 'penjualan/printNota?id=' + $(this).attr('data-id');
		is_mobile = /android|mobile/ig.test(navigator.userAgent);
		if (is_mobile) {
			const $this = $(this);
			$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
			$spinner.prependTo($this);
			$this.prop('disabled', true);
			let html_container = "print://escpos.org/escpos/bt/print?srcTp=uri&srcObj=html&src='data:text/html,";
			$.ajax({
				url: url,
				success: function(html) {
					html_container += html
					window.location.href = html_container;
					$this.prop('disabled', false);
					$spinner.remove();
				}, error: function() {
					$this.prop('disabled', false);
					$spinner.remove();
					bootbox.alert('Ajax Error, cek console browser');
				}
			})
		} else {
			window.open(url, top = 500, left = 500, width = 600, height = 600, menubar = 'no', status = 'no', titlebar = 'no'); 
		}
		return false;
	});
	
	$(document).undelegate('.btn-print-invoice', 'click').delegate('.btn-print-invoice', 'click', function(e) {
		e.preventDefault();
		url = base_url + 'penjualan/printInvoice?id=' + $(this).attr('data-id');
		window.open(url, top = 500, left = 500, width = 600, height = 600, menubar = 'no', status = 'no', titlebar = 'no'); 
		return false;
	});
	
	$(document).undelegate('.btn-kirim-email-invoice', 'click').delegate('.btn-kirim-email-invoice', 'click', function(e){
		e.preventDefault();
		email = $(this).attr('data-email') || '';
		id = $(this).attr('data-id');
		html_content = '<div class="alert alert-warning" style="display:none"></div><div class="row">' + 
							'<label class="col-sm-3">Email</label>' +
							'<div class="col-sm-9">' + 
								'<input type="email" class="form-control" name="email" value="' + email + '" required="required"/>' + 
							'</div>' +
						'</div>';
						
		$bootbox =  bootbox.dialog({
			title: 'Kirim Invoice',
			message: html_content,
			buttons: {
				cancel: {
					label: 'Cancel'
				},
				success: {
					label: 'Kirim',
					className: 'btn-success submit',
					callback: function() 
					{
						email = $bootbox.find('input[name="email"]').val();
						if (!email) {
							$bootbox.find('.alert').show().html('Email harus diisi')
							return false;
						}
						
						$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
						$btn_all = $bootbox.find('button');
						$btn_submit = $bootbox.find('.submit');
						
						$btn_all.prop('disabled', true);
						$btn_submit.prepend($spinner);

						$.ajax({
							url: base_url + 'penjualan/invoicePdf?email=' + email + '&id=' + id,
							method: 'get',
							success: function(data) {
								$spinner.remove();
								$btn_all.prop('disabled', false);
								data = JSON.parse(data);
								$bootbox.modal('hide');
								
								if (data.status == 'ok') {
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
										html: '<div class="toast-content d-flex"><i class="far fa-check-circle me-2 mt-1"></i>' + parse_message(data.message) + '</div>'
									})
								} else {
									bootbox.alert('<div class="d-flex my-2"><span class="text-danger"><i class="fas fa-times-circle me-3" style="font-size:20px"></i></span>' + parse_message(data.message) + '</div>');
								}
								
							}, error: function(xhr) {
								$spinner.remove();
								$btn_all.prop('disabled', false);
								Swal.fire({
									text: 'Ajax Error, cek console browser',
									title: 'AJAX Error',
									icon: 'error',
									showCloseButton: true,
									confirmButtonText: 'OK'
								})
								console.log(xhr);
							}
						})
						return false;
					}
					
				}
			}
		});
	})
	
	$(document).undelegate('.btn-cancel', 'click').delegate('.btn-cancel', 'click', function() {
		
		let invoice_detail = $(this).parent().find('.invoice-detail-view').text();
		detail = JSON.parse(invoice_detail);
		
		url_detail = base_url + 'kasir-penjualan/detail?id=' + detail['id_penjualan'];
		history.pushState( url_detail,'',url_detail);
		
		show_detail_penjualan(detail);
	})

	$(document).undelegate('.btn-selesai', 'click').delegate('.btn-selesai', 'click', function() 
	{
		$this = $(this);
		let id = $(this).data('id');

		$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
		$this.prepend($spinner);
		
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Pesanan telah selesai dibuat!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Selesai",
			cancelButtonText: "Batal"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + 'kasir-penjualan/ajaxSaveUpdateStatus',
					data: {id:id},
					method: 'post',
					success: function(data) {
						$spinner.remove();
						data = JSON.parse(data);
						if (data.status == 'ok') {
							show_toast('Data berhasil diperbarui');
							dataTables.draw();
							show_detail_penjualan(detail);
							return;
						}
						
					}, error: function(xhr) {
						$spinner.remove();
						console.log(xhr);
					}
				})
			}
		});
	});
	
	$(document).undelegate('.btn-submit', 'click').delegate('.btn-submit', 'click', function() {
		
		$btn_submit = $(this);
		$spinner = $('<div class="spinner-border spinner-border-sm me-2"></div>');
		$btn_all = $btn_submit.parent().find('button');
		
		$btn_all.prop('disabled', true);
		$btn_submit.prepend($spinner);

		let invoice_detail = $(this).parent().find('.invoice-detail-view').text();
		detail = JSON.parse(invoice_detail);
		
		$.ajax({
			url: base_url + 'kasir-penjualan/ajaxSaveData',
			data: $('form').serialize(),
			method: 'post',
			success: function(data) {
				$spinner.remove();
				$btn_all.prop('disabled', false);
				// console.log(data);
				data = JSON.parse(data);
				
				if (data.status == 'ok') {
					$btn_submit.prop('disabled', false);
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
						html: '<div class="toast-content d-flex"><i class="far fa-check-circle me-2 mt-1"></i>' + parse_message(data.message) + '</div>'
					})

					dataTables.draw();
					url_detail = base_url + 'kasir-penjualan/detail?id=' + detail['id_penjualan'];
					history.pushState( url_detail,'',url_detail);
					detail.status_transaksi = data.penjualan.status_transaksi ?? 3;
					show_detail_penjualan(detail);
					statusForm = 'detail';

					socketConnection.emit('kirimAll', data.no_invoice);
				} else {
					bootbox.alert('<div class="d-flex my-2"><span class="text-danger"><i class="fas fa-times-circle me-3" style="font-size:20px"></i></span>' + parse_message(data.message) + '</div>');
				}
				
			}, error: function(xhr) {
				$spinner.remove();
				$btn_all.prop('disabled', false);
				console.log(xhr);
			}
		})
	})
	
	$(document).undelegate('.add-barang').delegate('.add-barang', 'click', function() 
	{
		$this = $(this);
		if ($this.hasClass('disabled')) {
			return false;
		}
		
		let $table = $('#barang-pilih-tabel');
		let gudang = $('#id-gudang').val();
		let harga = $('#id-jenis-harga').val();
		var $modal = jwdmodal({
			title: 'Pilih Barang',
			url: base_url + '/penjualan/getDataDTListBarang?id_gudang=' + gudang + '&id_jenis_harga=' + harga,
			width: '850px',
			action :function () 
			{
				$tbody = $table.find('tbody.barang-pilih-detail');
				var list_barang = '<span class="belum-ada mb-2">Silakan pilih barang</span>';
				if ($table.is(':visible')) {
					var list_barang = '';
					$tbody.each (function (i, elm) {
						nama_barang = $(elm).find('.nama-barang').text();
						list_barang += '<small  class="px-3 py-2 me-2 mb-2 text-success bg-success bg-opacity-10 border border-success rounded-2">' + nama_barang + '</small>';
					});
				}
				$('.jwd-modal-header-panel').prepend('<div class="list-barang-terpilih">' + list_barang + '</div>');
			}
			
		});
		
		$(document)
		.undelegate('.pilih-barang', 'click')
		.delegate('.pilih-barang', 'click', function() {
			

			// Barang Popup
			$tr = $(this).parents('tr').eq(0);
			barang = JSON.parse($tr.find('.detail-barang').text());
			
			// List barang
			$first_tbody = $table.find('tbody.barang-pilih-detail').eq(0);
			$tbody = $first_tbody.clone()
			if ($table.is(':hidden')) {
				$first_tbody.remove();
			}
			harga_satuan = barang.harga_jual || 0;
			
			$tbody.find('.nama-barang').text(barang.nama_barang);
			$tbody.find('.harga-satuan-text').text(format_ribuan(harga_satuan));
			$tbody.find('.stok-text').text(format_ribuan(barang.stok));
			$tbody.find('.barang-pilih-item-detail').text(JSON.stringify(barang));
			
			$tbody.find('.id-barang').val(barang.id_barang);
			$tbody.find('.harga-satuan').val(harga_satuan);
			$tbody.find('.stok').val(barang.stok);
			$tbody.find('.satuan').val(barang.satuan);
							
			$table.show();
			$tbody.insertBefore($('#subtotal-tbody'));
			$tbody.find('.qty').val(1).trigger('keyup');
			
			$('.barang-pilih-empty').hide();
			
			$('.list-barang-terpilih').find('.belum-ada').remove();
			$('.list-barang-terpilih').append('<small  class="px-3 py-2 me-2 mb-2 text-success bg-success bg-opacity-10 border border-success rounded-2">' + barang.nama_barang + '</small>');
			
			// $(document);
		});
	});
	
	$(document).undelegate('tr', 'click').delegate('tr', 'click', function() {

		jenis = $(this).parents('table').eq(0).attr('data-tabel-jenis');
		if (jenis != 'tabel-penjualan')
			return;
		
		if ($(this).parents('table').eq(0).attr('id') != 'tabel-data')
			return;
		
		$('.barang-pilih-empty').hide();
		
		$btn_close_panel = $(this).parents('.left-panel').eq(0).find('.btn-close-panel');
		if (!$btn_close_panel.is(':hidden')) {
			$btn_close_panel.trigger('click');
		}
		
		invoice_detail = $(this).find('.invoice-detail').text();
		detail = JSON.parse(invoice_detail);
		url_detail = base_url + 'kasir-penjualan/detail?id=' + detail['id_penjualan'];
		history.pushState( url_detail,'',url_detail);
		
		show_detail_penjualan(detail);
	})
	
	
	$(document).undelegate('.link-edit', 'click').delegate('.link-edit', 'click', function(e) {
		
		e.preventDefault();
		
		url_detail = $(this).attr('href');
		history.pushState( url_detail,'',url_detail);
		
		id = $(this).attr('data-id');
		show_form_penjualan(id);
	})

	// Realtime dari pelayan -> kasir
	socketConnection.on('terimaKasir', data => {
		dataTables.draw();

		if (statusForm) {
			if ((typeof(detail) !== "undefined")) {
				show_detail_penjualan(detail);
			}
		}

		if (statusForm == 'form') {
			const query_string = new URLSearchParams(window.location.search);
			id = query_string.get('id');
			
			show_form_penjualan(id)
		}

		let suara = new Audio(base_url + 'public/files/audio/success.wav');
		suara.play();
		show_toast(`Pesanan selesai (Invoice: ${data.no_invoice})`);
	})

	// Kalkulasi
	$(document).undelegate('.item-bayar', 'keyup').delegate('.item-bayar', 'keyup', function(e) 
	{
		calculate_total();
	});

	function calculate_total() 
	{
		$harga_barang = $('.right-panel-body').find('.harga-barang-input');

		subtotal = 0;
		$harga_barang.each(function(i, elm) 
		{
			value = $(elm).val();
			subtotal += setInt( value );
		});
		
		// Diskon barang
		$('.diskon-barang-nilai').each(function(i, elm) {
			$elm = $(elm);
			diskon_nilai = setInt($elm.val());
			if (diskon_nilai) {
				$tbody = $elm.parents('tbody').eq(0);
				jenis = $tbody.find('.diskon-barang-jenis').val();
				nilai = setInt($tbody.find('.harga-barang-input').val());
				if (jenis == '%') {
					diskon_nilai = diskon_nilai / 100 * nilai;
				}
				subtotal -= diskon_nilai;
			}
		});
		
		$('#subtotal-text').text(format_ribuan(subtotal));
		$('#subtotal-input').val(subtotal);
		
		// Diskon
		let diskon_total_jenis = $('#diskon-total-jenis').val();
		let diskon_total = setInt( $('#diskon-total-nilai').val(), 10 );
		
		if (diskon_total) {
			if (diskon_total_jenis == '%') {
				if (diskon_total >= 100) {
					diskon_total = 100;
				}
				jumlah_diskon = Math.round(subtotal * diskon_total / 100);
			} else {
				jumlah_diskon = diskon_total;
			}
			subtotal = subtotal - jumlah_diskon;
		}

		// Penyesuaian
		let penyesuaian = setInt( $('#penyesuaian-nilai').val());
		let neto = subtotal + penyesuaian;

		// Pajak
		tarif_pajak = $('#pajak-nilai').val();
		if (tarif_pajak) {
			pajak = Math.round( neto * parseInt(tarif_pajak) / 100 );
			neto = neto + pajak;
		}

		$('.total-text').text(format_ribuan(neto));
		$('#total-input').val(neto);
		$('.jml-tagihan').val(neto);
		
		$('.jml-bayar').trigger('keyup');
		
		// Bayar
		let $item_bayar = $('.item-bayar');
		let total_bayar = 0;
		$item_bayar.each(function(i, elm) {
			bayar = setInt( $(elm).val() );
			total_bayar += bayar;
		})
		
		$('#total-bayar').text(format_ribuan(total_bayar));
		
		if (total_bayar < neto) {
			$('#kembali-row').hide();
			$('#kurang-bayar-row').show();
			$('#kurang-bayar-nilai').text( format_ribuan(neto - total_bayar) );
		} else {
			$('#kurang-bayar-row').hide();
			$('#kembali-row').show();
			$('#kembali-nilai').text( format_ribuan(total_bayar - neto) );
		}
		// $('.item-bayar').eq(0).trigger('keyup');
		// $('.kurang-bayar').val(format_ribuan(neto));
		
	}

	$(window).on('beforeunload',function(){
		window.location.reload()
	});
})