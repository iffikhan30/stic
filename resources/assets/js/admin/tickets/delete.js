// Delete Record

const deleteTicket = (db,id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    customClass: {
      confirmButton: 'btn btn-primary me-1',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(async result => {
    if (result.isConfirmed) {
      await deleteTicketRequest(db,id);
    }
  });
};

// delete request
const deleteTicketRequest = async (db,id) => {
  try {
    // Fetch request
    const fetchUrl = `/dashboard/tickets/${id}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const iddb = `${id}-${db}`;
    console.log(iddb);
    const fetchOptions = {
      method: 'DELETE',
      body: { id: iddb },
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
    };

    const res = await fetch(fetchUrl, fetchOptions);

    if (res.status === 422) {
      Swal.fire({
        icon: 'warning',
        title: 'Not Selected!',
        text: 'Record is not selected',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });
    } else if (res.status === 200) {
      Swal.fire({
        icon: 'success',
        title: 'Deleted!',
        text: 'The record has been deleted.',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      }).then(() => {
        // Reload the page after the alert is closed
        window.location.reload();
      });

      // Optionally, remove the deleted item from the DOM or refresh the list
      // Example: document.querySelector(`#row-${id}`).remove();
    } else {
      const errorData = await res.json();
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: errorData.message || 'An error occurred while deleting.',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Something went wrong!',
      text: error.message || 'Unable to delete the cms',
      customClass: {
        confirmButton: 'btn btn-success'
      }
    });
  }
};

// const deleteOperatingCountry = () => {
//   $('#deleteOperatingCountryModal').modal('show');
//   document.querySelector('#deleteOperatingCountryModal #deleteOperatingCountryModal').onsubmit = e =>
//     deleteOperatingCountryRequest(e, id);
// };
