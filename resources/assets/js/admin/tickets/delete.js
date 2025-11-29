// Delete Record
$(document).on('click', '.delete-image-record', function () {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var general_id = $(this).data('id'),
    dtrModal = $('.dtr-bs-modal.show');

  // hide responsive modal in small screen
  if (dtrModal.length) {
    dtrModal.modal('hide');
  }

  // sweetalert for confirmation of delete
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    customClass: {
      confirmButton: 'btn btn-primary me-3',
      cancelButton: 'btn btn-label-secondary'
    },
    buttonsStyling: false
  }).then(function (result) {
    if (result.value) {
      // delete the data
      $.ajax({
        type: 'DELETE',
        url: `${baseUrl}dashboard/media/${general_id}`,
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
        }
      });
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire({
        title: 'Cancelled',
        text: 'The is not deleted!',
        icon: 'error',
        customClass: {
          confirmButton: 'btn btn-success'
        }
      });
    }
  });
});

const deleteCms = id => {
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
      await deleteCmsRequest(id);
    }
  });
};

// delete request
const deleteCmsRequest = async id => {
  try {
    // Fetch request
    const fetchUrl = `/dashboard/cms/${id}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const fetchOptions = {
      method: 'DELETE',
      body: { id: id },
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
