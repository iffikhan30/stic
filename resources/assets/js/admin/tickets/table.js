// Manucatuirer Table
const ticketTable = $('#ticketTable').DataTable({
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