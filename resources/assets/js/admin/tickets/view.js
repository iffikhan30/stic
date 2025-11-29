getCmsRequest = async id => {
  try {
    // fetch
    const url = `/dashboard/cms/${id}`;
    const fetchOptions = { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } };
    const res = await fetch(url, fetchOptions);

    // response
    const resJson = await res.json();
    // on success, populate states dropdown
    if (res.status === 200) {
      return resJson;
    } else {
      toastr.error('Failed to fetch states', 'Error');
    }
  } catch (error) {
    console.log({ error });
    toastr.error('Something went wrong', 'Error');
  }
};
const viewCms = async id => {
  // Fetch the operating country data
  const data = await getCmsRequest(id);
  console.log(data);
  // Check if data exists
  if (data) {
    // Populate modal fields with data
    dQuery('#viewCmsModal .modal-title').textContent = `${data.cms.title}`;
    dQuery('#viewCmsModal .modal-body').innerHTML = `
      <div>
        <!-- CMS Section -->
        <section id="cms-content">
          <h3>${data.cms.title}</h3>
          ${data.cms.subtitle ? `<h5>${data.cms.subtitle}</h5>` : ''}
          ${data.cms.slug ? `<h5>${data.cms.slug}</h5>` : ''}
          <div>${data.cms.content}</div>
          <p><strong>Type:</strong> ${data.cms.type}</p>
          <p><strong>Slug:</strong> ${data.cms.slug}</p>
          <p><strong>Created At:</strong> ${data.cms.created_at}</p>
          <p><strong>Updated At:</strong> ${data.cms.updated_at}</p>
        </section>

        ${
          data.cms_meta && data.cms_meta.length > 0
            ? `
        <!-- Meta Data Section -->
        <section id="meta-data">
          <h2>Meta Data</h2>
          <ul>
            ${data.cms_meta
              .map(
                meta => `
              <li><strong>${meta.key}:</strong> ${meta.value}</li>
            `
              )
              .join('')}
          </ul>
        </section>
        `
            : ''
        }
        ${
          data.cms_seo
            ? `
        <!-- SEO Section -->
        <section id="seo-data">
          <h2>SEO Information</h2>
          <p><strong>Title:</strong> ${data.cms_seo.title}</p>
          <p><strong>Description:</strong> ${data.cms_seo.description || 'N/A'}</p>
        </section>
        `
            : ''
        }

        ${
          data.media
            ? `
        <!-- Media Section -->
        <section id="media-data">
          <h2>Media</h2>
          <p><strong>Title:</strong> ${data.media.title}</p>
          <img src="${data.media.path}" alt="${data.media.title}" />
        </section>
        `
            : ''
        }

        <!-- Country Information -->
        <section id="country-info">
          <h2>Country</h2>
          <p><strong>Name:</strong> ${data.country_name}</p>
        </section>

        <!-- User Information -->
        <section id="user-info">
          <h2>User</h2>
          <p><strong>Name:</strong> ${data.user_name}</p>
        </section>
      </div>

    `;

    // Show the modal
    $('#viewCmsModal').modal('show');
  }
};
