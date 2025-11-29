'use strict';

//Javascript to handle the e-commerce product add page

(function () {
  // Select2
  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder') // for dynamic placeholder
      });
    });
  }

  var select3 = $('.select3');
  if (select3.length) {
    select3.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder') // for dynamic placeholder
      });
    });
  }

  const getLanguageByCountryId = ()=>{
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $.ajax({
        type: 'GET',
        url: `${baseUrl}dashboard/getlanguages`,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
        success: function (res) {
          console.log(res);
          let $select = $('#language');
          $select.empty(); // Clear existing options
          if (res && res.length > 0)
          {
            $('#langSelect').show();
            res.forEach(function (lang) {
              $select.append(
                $('<option>', {
                  value: lang.id,
                  text: lang.title
                })
              );
            });
          }else{
            $('#langSelect').hide();
          }
        },
        error: function (error) {
          console.log(error);
        }
      });
    } catch (error) {
      console.log({ error });
    }
  }

  $(()=>{
    getLanguageByCountryId()
  });

  $(document).on('change', '#country_id', (e)=>getLanguageByCountryId(e.target.value));

  $(document).on('change', '#make_id', function () {
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var general_id = $(this).val();
      $.ajax({
        type: 'POST',
        url: `${baseUrl}dashboard/getjson_datapare`,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
        data: { parent: general_id, table: 'brands' },
        success: function (res) {
          const SelectedValue = $(`[name=model_id]`).val();
          const stateDropdown = dQuery('#model_id');
          stateDropdown.innerHTML = '';
          res.forEach(state => {
            const option = document.createElement('option');
            option.value = state.id;
            option.textContent = state.title;

            if (state.id == SelectedValue) {
              option.setAttribute('selected', 'selected');
            }
            stateDropdown.appendChild(option);
          });

          $('#model_id').select2({ placeholder: 'Select State' });
        },
        error: function (error) {
          console.log(error);
        }
      });
    } catch (error) {
      console.log({ error });
    }
  });

  // $('[name="title"]').on('keyup', function () {
  //   const title = $(this).val();

  //   const slug = title
  //     .toLowerCase()
  //     .replace(/\s+/g, '-') // Replace spaces with hyphens
  //     .replace(/[^a-z0-9\-_]/g, ''); // Remove invalid characters

  //   $('[name="slug"]').val(slug);
  //   $('[name="metatitle"]').val(title);
  // });

  const fullToolbar = [
    [
      {
        font: []
      },
      {
        size: []
      }
    ],
    ['bold', 'italic', 'underline', 'strike'],
    [
      {
        color: []
      },
      {
        background: []
      }
    ],
    [
      {
        script: 'super'
      },
      {
        script: 'sub'
      }
    ],
    [
      {
        header: '1'
      },
      {
        header: '2'
      },
      'blockquote',
      'code-block'
    ],
    [
      {
        list: 'ordered'
      },
      {
        list: 'bullet'
      },
      {
        indent: '-1'
      },
      {
        indent: '+1'
      }
    ],
    [{ direction: 'rtl' }],
    ['link', 'image', 'video', 'formula'],
    ['clean']
  ];
  // Comment editor

  const contentEditor = document.querySelector('#content');

  if (contentEditor) {
    const content = new Quill(contentEditor, {
      modules: {
        formula: true,
        toolbar: fullToolbar
      },
      placeholder: 'Content',
      theme: 'snow'
    });
    //$('[name="content"]').val(content.root.innerHTML);
    content.on('text-change', function () {
      const quillContent = content.root.innerHTML; // Quill content as HTML
      console.log(quillContent);
      $('[name="content"]').text(quillContent); // Update the textarea's value
    });
  }

  const contentEditor1 = document.querySelector('#content1');

  if (contentEditor1) {
    const content1 = new Quill(contentEditor1, {
      modules: {
        formula: true,
        toolbar: fullToolbar
      },
      placeholder: 'Content',
      theme: 'snow'
    });
    $('[name="content1"]').val(content1.root.innerHTML);
    content1.on('text-change', function () {
      const quillContent1 = content1.root.innerHTML; // Quill content as HTML
      $('[name="content1"]').val(quillContent1); // Update the textarea's value
    });
  }

  //GET STATES BY COUNTRY ID
  function getStatesByCountryID(){
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      var general_id = $('#country_id').val();
      $.ajax({
        type: 'POST',
        url: `${baseUrl}dashboard/getstatesbycountryid`,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
        data: { country_id: general_id },
        success: function (res) {
          let pickup_id = $('#state_id');
          pickup_id.empty();
          pickup_id.append('<option value="">Select State</option>');
          res.forEach(state => {
            pickup_id.append(`<option value="${state.id}">${state.name}</option>`);
          });
        },
        error: function (error) {
          console.log(error);
        }
      });
    } catch (error) {
      console.log({ error });
    }
  }
  $(document).on('change', '#country_id', function () {
    getStatesByCountryID();
  });

  // previewTemplate: Updated Dropzone default previewTemplate
  // ! Don't change it unless you really know what you are doing
  const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

  // ? Start your code from here

  // Basic Dropzone
  // --------------------------------------------------------------------
  const dropzoneBasic = document.querySelector('#dropzone-basic');
  if (dropzoneBasic) {
    const myDropzone = new Dropzone(dropzoneBasic, {
      previewTemplate: previewTemplate,
      parallelUploads: 1,
      maxFilesize: 5,
      addRemoveLinks: true,
      maxFiles: 1
    });
  }

  // Multiple Dropzone
  // --------------------------------------------------------------------
  const dropzoneMulti = document.querySelector('#dropzone-multi');
  if (dropzoneMulti) {
    const myDropzoneMulti = new Dropzone(dropzoneMulti, {
      previewTemplate: previewTemplate,
      parallelUploads: 1,
      maxFilesize: 5,
      addRemoveLinks: true
    });
  }

  // Basic Tags

  // const tagifyBasicEl = document.querySelector('#ecommerce-product-tags');
  // const TagifyBasic = new Tagify(tagifyBasicEl);

  // Flatpickr

  // Datepicker
  const date = new Date();

  const productDate = document.querySelector('#article_date');

  if (productDate) {
    productDate.flatpickr();
  }
})();

//Jquery to handle the e-commerce product add page

$(function () {
  // Select2
  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder') // for dynamic placeholder
      });
    });
  }

  var formRepeater = $('.list-repeater');

  // Form Repeater
  // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
  // -----------------------------------------------------------------------------------------------------------------

  if (formRepeater.length) {
    var row = 2;
    var col = 1;
    formRepeater.on('submit', function (e) {
      e.preventDefault();
    });
    formRepeater.repeater({
      show: function () {
        var fromControl = $(this).find('.form-control, .form-select');
        var formLabel = $(this).find('.form-label');

        fromControl.each(function (i) {
          var id = 'seo-meta-' + row + '-' + col;
          $(fromControl[i]).attr('id', id);
          $(formLabel[i]).attr('for', id);
          col++;
        });

        row++;
        $(this).slideDown();
        $('.select2-container').remove();
        $('.select2.form-select').select2({
          placeholder: 'Placeholder text'
        });
        $('.select2-container').css('width', '100%');
        $('.seo-meta:first .form-select').select2({
          dropdownParent: $(this).parent(),
          placeholder: 'Placeholder text'
        });
        $('.position-relative .select2').each(function () {
          $(this).select2({
            dropdownParent: $(this).closest('.position-relative')
          });
        });
      },
      hide: function (deleteElement) {
        if ($(this).attr('mid')) {
          console.log($(this).attr('mid'));
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          const general_id = $(this).attr('mid');
          $.ajax({
            type: 'DELETE',
            url: `${baseUrl}dashboard/cmsmeta/${general_id}`,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
            success: function (res) {
              console.log(res);
              //window.location.reload();
              // success sweetalert
              Swal.fire({
                icon: 'success',
                title: res.title,
                text: res.message,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
              $('#media_id_' + res.data).remove();
            },
            error: function (error) {
              console.log(error);
              Swal.fire({
                title: 'Cancelled',
                text: 'Something Went Wrong!',
                icon: 'error',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
          });
        }
        $(this).slideUp(deleteElement);
      }
    });
  }

  var formRepeaterSeo = $('.list-seo-repeater');

  // Form Repeater
  // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
  // -----------------------------------------------------------------------------------------------------------------

  if (formRepeaterSeo.length) {
    var row = 2;
    var col = 1;
    formRepeaterSeo.on('submit', function (e) {
      e.preventDefault();
    });
    formRepeaterSeo.repeater({
      show: function () {
        var fromControl = $(this).find('.form-control, .form-select');
        var formLabel = $(this).find('.form-label');

        fromControl.each(function (i) {
          var id = 'seo-meta-' + row + '-' + col;
          $(fromControl[i]).attr('id', id);
          $(formLabel[i]).attr('for', id);
          col++;
        });

        row++;
        $(this).slideDown();
        $('.select2-container').remove();
        $('.select2.form-select').select2({
          placeholder: 'Placeholder text'
        });
        $('.select2-container').css('width', '100%');
        $('.seo-meta:first .form-select').select2({
          dropdownParent: $(this).parent(),
          placeholder: 'Placeholder text'
        });
        $('.position-relative .select2').each(function () {
          $(this).select2({
            dropdownParent: $(this).closest('.position-relative')
          });
        });
      },
      hide: function (deleteElement) {
        if ($(this).attr('mid')) {
          console.log($(this).attr('mid'));
          const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          const general_id = $(this).attr('mid');
          $.ajax({
            type: 'DELETE',
            url: `${baseUrl}dashboard/seometa/${general_id}`,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken },
            success: function (res) {
              console.log(res);
              //window.location.reload();
              // success sweetalert
              Swal.fire({
                icon: 'success',
                title: res.title,
                text: res.message,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
              $('#media_id_' + res.data).remove();
            },
            error: function (error) {
              console.log(error);
              Swal.fire({
                title: 'Cancelled',
                text: 'Something Went Wrong!',
                icon: 'error',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
          });
        }
        $(this).slideUp(deleteElement);
      }
    });
  }
});
