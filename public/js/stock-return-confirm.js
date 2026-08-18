(function ($) {
  'use strict';

  function escapeHtml(value) {
    return String(value == null ? '' : value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function pad2(value) {
    return value < 10 ? '0' + value : String(value);
  }

  function todayIso() {
    var now = new Date();
    return now.getFullYear() + '-' + pad2(now.getMonth() + 1) + '-' + pad2(now.getDate());
  }

  function confirmReturn(opts) {
    var returnDate = opts.returnDate || todayIso();
    var issueDate = opts.issueDate || '';

    return Swal.fire({
      title: 'Return this asset?',
      html:
        '<div class="return-confirm-details">' +
          '<p><strong>Employee:</strong> ' + escapeHtml(opts.employee) + '</p>' +
          '<p><strong>Asset:</strong> ' + escapeHtml(opts.asset) + '</p>' +
          '<p><strong>Serial:</strong> ' + escapeHtml(opts.serial) + '</p>' +
          '<label for="swal-return-date">Return date</label>' +
          '<input type="date" id="swal-return-date" class="swal2-input" value="' + escapeHtml(returnDate) + '">' +
        '</div>',
      icon: 'question',
      showCancelButton: true,
      focusCancel: true,
      reverseButtons: true,
      confirmButtonText: 'Yes, return to stock',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#26B99A',
      cancelButtonColor: '#73879C',
      customClass: {
        popup: 'return-confirm-popup',
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-default',
      },
      buttonsStyling: false,
      preConfirm: function () {
        var dateInput = document.getElementById('swal-return-date');
        var date = dateInput ? dateInput.value : '';

        if (!date) {
          Swal.showValidationMessage('Please choose a return date');
          return false;
        }

        if (issueDate && date < issueDate) {
          Swal.showValidationMessage('Return date cannot be before the issue date');
          return false;
        }

        return date;
      },
    });
  }

  function postReturn(url, date) {
    var token = $('meta[name="csrf-token"]').attr('content');
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.style.display = 'none';
    form.innerHTML =
      '<input type="hidden" name="_token" value="' + escapeHtml(token) + '">' +
      '<input type="hidden" name="_method" value="PUT">' +
      '<input type="hidden" name="return_date" value="' + escapeHtml(date) + '">';
    document.body.appendChild(form);
    form.submit();
  }

  $(document).on('click', '.js-return-asset', function (event) {
    if (typeof Swal === 'undefined') {
      return;
    }

    event.preventDefault();

    var $el = $(this);

    confirmReturn({
      employee: $el.attr('data-employee'),
      asset: $el.attr('data-asset'),
      serial: $el.attr('data-serial'),
      issueDate: $el.attr('data-issue-date'),
    }).then(function (result) {
      if (result.isConfirmed) {
        postReturn($el.attr('data-url'), result.value);
      }
    });
  });

  $(document).on('submit', '#return-issuance-form', function (event) {
    var form = this;

    if (form.dataset.confirmed === '1' || typeof Swal === 'undefined') {
      return;
    }

    event.preventDefault();

    confirmReturn({
      employee: form.getAttribute('data-employee'),
      asset: form.getAttribute('data-asset'),
      serial: form.getAttribute('data-serial'),
      issueDate: form.getAttribute('data-issue-date'),
      returnDate: form.return_date ? form.return_date.value : todayIso(),
    }).then(function (result) {
      if (!result.isConfirmed) {
        return;
      }

      if (form.return_date) {
        form.return_date.value = result.value;
      }

      form.dataset.confirmed = '1';
      HTMLFormElement.prototype.submit.call(form);
    });
  });
})(jQuery);
