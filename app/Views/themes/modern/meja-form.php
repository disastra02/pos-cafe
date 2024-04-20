<form method="post" action="" class="form-horizontal p-3" enctype="multipart/form-data">
	<div>
		<div class="row mb-3">
			<label class="col-sm-3 col-form-label">Nama</label>
			<div class="col-sm-9">
				<input class="form-control" type="text" name="nama" value="<?=@$form_data['nama']?>" required="required"/>
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-sm-3 col-form-label">Status</label>
			<div class="col-sm-9">
				<?=options(['name' => 'status', 'id' => 'status'], ['0' => 'Kosong', '1' => 'Aktif'], set_value('status', @$form_data['status']))?>
			</div>
		</div>
	</div>
	<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
</form>