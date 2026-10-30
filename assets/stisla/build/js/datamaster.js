class DataMaster {
  constructor(selector, base_url) {
    this.baseUrl = base_url;
    this.form = $(selector.form);
    this.set_form_submit_action(selector);
    this.set_form_cancel_action(selector);

    this.set_delete_modal_onshow(selector);
    this.set_delete_confirm_btn(selector);
    this.set_delete_action_btn(selector);
  }

  show_master_form() {
    $("html, body").animate({ scrollTop: 0 });
    var $BOX_PANEL = this.form.closest('.x_panel'),
    $ICON = $BOX_PANEL.find('.collapse-link').find('i'),
    $BOX_CONTENT = $BOX_PANEL.find('.x_content');
    if ($BOX_PANEL.attr('style')) {
      $BOX_CONTENT.slideToggle(200, function(){
          $BOX_PANEL.removeAttr('style');
      });
      $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    }
  }

  show_message(message_text, message_type) {
    var message = '<div class="alert '+message_type+' alert-dismissible fade in" role="alert">'+
      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+
      message_text+
    "</div>";
    $('.message-container').hide().html(message).fadeIn('slow');
  }

  set_delete_modal_onshow(selector) {
    $(selector.deleteModal).on('show.bs.modal', function() {
      var id = $(this).data('id'),
      removeBtn = $(this).find(selector.deleteBtn);
      $(this).find('p').last().html('Data dengan kode '+id);
      var url = removeBtn.attr('href');
      url = url.substring(0, url.lastIndexOf('/')) + '/' + id;
      removeBtn.attr('href', url);
      removeBtn.data('id', id);
    });
  }

  set_delete_confirm_btn(selector) {
    $(document).on('click', selector.deleteConfirm, function () {
      var id = $(this).data('id');
      $(selector.deleteModal).data('id', id).modal('show');
    });
  }

  set_delete_action_btn(selector) {
    var self = this;
    $(document).on('click', selector.deleteBtn, function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      $(selector.deleteModal).modal('hide');
      $.ajax({
        type: 'GET',
        url: $(this).attr('href'),
        success: function(data) {
          if (data.status=='success') {
            var message = "<strong>Sukses!</strong> Data dengan kode "+id+' telah dihapus';
            self.show_message(message, 'alert-success');
            self.delete_table(id);
          } else {
            var message = '<strong>Terjadi kesalahan!</strong> Data gagal dihapus';
            self.show_message(message, 'alert-danger');
          }
        }
      });
    });
  }

  set_form_insert(selector, values) {
    this.form.attr('action', this.form.attr('action').replace('update_data', 'add_data'));
    this.form.find(selector.jenis).prop('disabled', !values.edit).val('');
    this.form.find(selector.rincian).prop('disabled', !values.edit).val('');
    this.form.find(selector.item).prop('disabled', !values.edit).val('');
    this.form.find(selector.rekening).prop('disabled', !values.edit).val('');
    this.form.find(selector.ura).prop('disabled', !values.edit).val('');
    this.form.find(selector.code).prop('readonly', !values.edit).val('');
    this.form.find(selector.uraian).val('');
    this.form.find(selector.opd).val('');
    this.form.find(selector.method).val(values.method);
    this.form.find(selector.submit).html(values.submit);
    this.form.find(selector.cancel).prop('disabled', !values.cancel);
    this.form.find(selector.reset).prop('disabled', !values.reset);
  }

  set_form_update(selector, values) {
    this.form.attr('action', this.form.attr('action').replace('add_data', 'update_data'));
    this.form.find(selector.jenis).prop('disabled', !values.edit).val(values.jenis);
    this.fill_rincian_option(selector.rincian, values.jenis, values.rincian, !values.edit);
    this.fill_item_option(selector.item, values.rincian, values.item, !values.edit);
    this.fill_rekening_option(selector.rekening, values.item, values.rekening, !values.edit);
    this.form.find(selector.code).inputmask(values.codemask).prop('readonly', !values.edit).val(values.code);
    this.form.find(selector.uraian).val(values.nama);
    this.form.find(selector.opd).val(values.opd);
    this.form.find(selector.method).val(values.method);
    this.form.find(selector.submit).html(values.submit);
    this.form.find(selector.cancel).prop('disabled', !values.cancel);
    this.form.find(selector.reset).prop('disabled', !values.reset);
    this.form.parsley().validate();
  }

  fill_jenis_option(jenisSelector, value) {
    var jenis_select = this.form.find(jenisSelector);
    $.get(this.baseUrl+'data_master/jenis_pendapatan/read_data', function (jenis_pendapatan) {
      jenis_select.append($('<option>', {value: ''}).append('--Pilih jenis pendapatan--'));
      jenis_pendapatan.forEach(function (data) {
        var kode = data.kode.split('.').pop();
        jenis_select.append($('<option>', {value: data.kode}).append(kode+" | "+data.nama));
      });
    });
  }

  fill_rincian_option(rincianSelector, jenisValue, value, disabled) {
    var rincian_select = this.form.find(rincianSelector);
    rincian_select.find('option').remove();
    $.get(this.baseUrl+'data_master/rincian_pendapatan/read_data/0/'+jenisValue, function (rincian_pendapatan) {
      rincian_select.append($('<option>', {value: ''}).append('--Pilih rincian pendapatan--'));
      rincian_pendapatan.forEach(function (data) {
        var kode = data.kode.split('.').pop();
        rincian_select.append($('<option>', {value: data.kode}).append(kode+" | "+data.nama));
      });

      rincian_select.prop('disabled', disabled).val(value);
    });
  }

  fill_item_option(itemSelector, rincianValue, value, disabled) {
    var item_select = this.form.find(itemSelector);
    item_select.find('option').remove();
    $.get(this.baseUrl+'data_master/item_pendapatan/read_data/0/'+rincianValue, function (item_pendapatan) {
      item_select.append($('<option>', {value: ''}).append('--Pilih item pendapatan--'));
      item_pendapatan.forEach(function (data) {
        var kode = data.kode.split('.').pop();
        item_select.append($('<option>', {value: data.kode}).append(kode+" | "+data.nama));
      });

      item_select.prop('disabled', disabled).val(value);
    });
  }

  fill_rekening_option(rekeningSelector, itemValue, value, disabled) {
    var rekenig_select = this.form.find(rekeningSelector);
    rekenig_select.find('option').remove();
    $.get(this.baseUrl+'data_master/kode_rekening/read_data/0/'+itemValue, function (kode_rekening) {
      rekenig_select.append($('<option>', {value: ''}).append('--Pilih kode rekening--'));
      kode_rekening.forEach(function (data) {
        var kode = data.kode.split('.').pop();
        rekenig_select.append($('<option>', {value: data.kode}).append(kode+" | "+data.nama));
      });

      rekenig_select.prop('disabled', disabled).val(value);
    });
  }

  enable_inputs(selector) {
    this.form.find(selector.jenis).prop('disabled', false);
    this.form.find(selector.rincian).prop('disabled', false);
    this.form.find(selector.item).prop('disabled', false);
    this.form.find(selector.rekening).prop('disabled', false);
    this.form.find(selector.ura).prop('disabled', false);
  }

  set_loading_submit(selector) {
    var button = this.form.find(selector.submit);
    button.prop('disabled', true);
    var originalText = button.text();
    var i = 0;
    var loading = setInterval(function() {
      button.append(".");
      i++;
      if (i==4) {
        button.html(originalText);
        i=0;
      }
    }, 500);

    return loading;
  }

  set_form_submit_action(selector) {
    var self = this;
    self.form.submit(function (e) {
      e.preventDefault();
      var loading = self.set_loading_submit(selector);
      self.enable_inputs(selector);
      var values = {};
      $.each($(this).serializeArray(), function(i, field) {
        values[field.name] = field.value;
      });

      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: values,
        success: function(data) {
          if (data.status == 'success') {
            clearInterval(loading);
            self.form.find(selector.submit).prop('disabled', false);

            if (values['_method'] == 'post') {
              var message = "<strong>Sukses!</strong> Data dengan kode "+values['nom-kod']+' telah ditambahkan';
              self.show_message(message, 'alert-success');
              self.insert_table([values['nom-kod'], values['nam-kod'], values['opd-tuj']]);
            } else {
              var message = "<strong>Sukses!</strong> Data dengan kode "+values['nom-kod']+' telah diperbarui';
              self.show_message(message, 'alert-success');
              self.update_table(values['nom-kod'], values['nam-kod'], values['opd-tuj']);
            }
            self.set_form_insert(selector, {
              'edit': true,
              'method': 'post',
              'submit': 'Tambah',
              'cancel': false,
              'reset': true
            });
          } else {
            self.show_message(data.message, 'alert-danger');
          }
        }
      });
    });
  }

  set_form_cancel_action(selector) {
    var self = this;
    self.form.find(selector.cancel).click(function () {
      self.set_form_insert(selector, {
        'edit': true,
        'method': 'post',
        'submit': 'Tambah',
        'cancel': false,
        'reset': true
      });
    });
  }

  insert_table(dt) {
    var data = this.data_table_format(dt);
    this.table.row.add(data).node().id = data.id;
    this.table.draw(false);
  }

  delete_table(id) {
    id = id.toString().replace(/\./g, '-');
    this.table.row($('#'+id)).remove().draw();
  }

  update_table(id, uraian, opd) {
    id = id.toString().replace(/\./g, '-');
    var d = this.table.row($('#'+id)).data();
    d.uraian = '<td>'+uraian+'</td>';
    d.opd = '<td>'+opd+'</td>';
    this.table.row($('#'+id)).data(d).draw();
  }
}
