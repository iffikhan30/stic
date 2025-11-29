// Manucatuirer Table
const cmsTable = $('#cmsTable').DataTable({
  language: handleDataTableLanguage(),
  search: false,
  order: false,
  layout: {
    top2Start: 'pageLength',
    top2End: 'search',
    topStart: {
      //buttons: ['excel', 'copy', 'csv']
    },
    topEnd: null,
    bottomStart: 'info',
    bottomEnd: 'paging',
    bottom2Start: null,
    bottom2End: null
  }
});

const excludeFromSearchListMT = ['Action'];

//$('#operatingCountryTable thead tr').clone(true).appendTo('#operatingCountryTable thead'); // copy the head
// $('#operatingCountryTable thead tr:eq(1) th').each(function (i) {
//   this.removeAttribute('data-dt-column');
//   this.className = '';

//   const title = $(this).text();

//   // dont add search input if column is from excludeFromSearchListMT
//   if (excludeFromSearchListMT.includes(title)) {
//     $(this).html('');
//     return;
//   }

//   // replace each cell of new head with input box
//   $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');

//   // add listner on input fields for search feature
//   $('input', this).on('keyup change', function () {
//     const value = operatingCountryTable.column(i).search();
//     if (value !== this.value) operatingCountryTable.column(i).search(this.value).draw();
//   });
// });
