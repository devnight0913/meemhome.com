<template>
  <div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1 h5 fw-bold m-0 ff-montserrat">Products</div>
    <button class="btn btn-primary ms-auto px-md-4" data-bs-toggle="modal" data-bs-target="#itemModal">Add Product</button>
  </div>

  <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
    <div>
      <DataTable :value="itemList" stripedRows showGridlines responsiveLayout="scroll" ref="dt" :paginator="true" :rows="20" :loading="loadingData">
        <template #empty>
          <NoContent />
        </template>

        <template #loading>
          <div class="text-center">
            <h6>Loading...</h6>
          </div>
        </template>
        <template #header class="bg-white">
          <div class="d-flex">
            <div class="flex-grow-1">
              <div>
                <div class="position-relative">
                  <input
                    type="search"
                    class="form-control w-auto"
                    name="search"
                    v-model="search"
                    id="search"
                    autocomplete="off"
                    placeholder="Search..."
                    style="padding-left: 2.5rem !important"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2">
                    <SearchIcon />
                  </div>
                </div>
              </div>
            </div>
            <button class="btn btn-primary px-4 d-flex align-items-center" @click="exportCSV($event)">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-1">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                />
              </svg>
              Export
            </button>
          </div>
        </template>
        <Column field="name" header="Item Name" :sortable="true">
          <template #body="slotProps">
            <div class="d-flex align-items-center mb-2">
              <div class="flex-shrink-0 me-2" v-if="slotProps.data.image_path">
                <a :href="slotProps.data.url" target="_blank">
                  <div class="item-image-wrapper-sm">
                    <picture>
                      <source type="image/jpg" :srcset="slotProps.data.sm_thumbnail_image_url" />
                      <img :alt="slotProps.data.name" :src="slotProps.data.sm_thumbnail_image_url" aria-hidden="true" class="img-sm rounded-0 border" />
                    </picture>
                  </div>
                </a>
              </div>
              <div class="flex-grow-1">
                <div class="text-muted small" v-if="slotProps.data.serial_number">
                  Serial Number: <span class="fw-bold">{{ slotProps.data.serial_number }}</span>
                </div>
                <div class="mb-1">
                  <a :href="slotProps.data.url" class="link-primary small" target="_blank">
                    {{ slotProps.data.name }}
                  </a>
                </div>
                <div class="mb-1">
                  <Rating v-model="slotProps.data.avg_rating" disabled :cancel="false">
                    <template #onicon>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 1rem; height: 1rem" class="text-warning">
                        <path
                          fill-rule="evenodd"
                          d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </template>
                    <template #officon>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        style="width: 1rem; height: 1rem"
                        class="text-dark"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
                        />
                      </svg>
                    </template>
                  </Rating>
                </div>
                <a :href="`${slotProps.data.url}#reviews`" class="link-primary small mb-2" target="_blank"> Reviews ({{ slotProps.data.sum_rating }}) </a>
              </div>
            </div>
          </template>
        </Column>
        <Column field="category.name" header="Category" :sortable="true">
          <template #body="slotProps">
            <a :href="slotProps.data.category.url" class="link-primary small" target="_blank">
              {{ slotProps.data.category.name }}
            </a>
            <div class="text-danger small" v-if="!slotProps.data.category.is_active">(Category is {{ slotProps.data.category.status }})</div>
          </template>
        </Column>
        <!-- <Column field="in_stock" header="In Stock" :sortable="true">
          <template #body="slotProps">
            <template v-if="slotProps.data.track_stock"> {{ slotProps.data.in_stock.toLocaleString() }}</template>
            <template v-else> <span class="text-muted small">Inventory not tracked</span> </template>
          </template>
        </Column> -->
        <Column field="price" header="Price" :sortable="true">
          <template #body="slotProps">
            {{ formatNumber(slotProps.data.base_price) }}
          </template>
        </Column>
        <Column field="views" header="Views" :sortable="true">
          <template #body="slotProps">
            <span class="badge rounded-pill bg-secondary d-flex align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1" style="width: 1rem; height: 1rem">
                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                <path
                  fill-rule="evenodd"
                  d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                  clip-rule="evenodd"
                />
              </svg>

              {{ slotProps.data.views.toLocaleString() }}
            </span>
          </template>
        </Column>
        <Column field="status" header="Status" :sortable="true">
          <template #body="slotProps">
            <span :class="slotProps.data.is_active ? 'text-bg-primary' : 'text-bg-danger'" class="badge rounded-pill">
              {{ slotProps.data.status }}
            </span>
          </template>
        </Column>
        <Column header=" " :sortable="false">
          <template #body="slotProps">
            <div class="dropdown">
              <button class="btn btn-link text-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                  />
                </svg>
              </button>
              <ul class="dropdown-menu rounded-4" aria-labelledby="dropdownMenuButton">
                <li>
                  <button class="dropdown-item d-flex align-items-center" v-on:click="copyLinkToClipBoard(slotProps.data)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-2">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"
                      />
                    </svg>
                    Copy Link
                  </button>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center" :href="slotProps.data.url" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-2">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
                      />
                    </svg>

                    Open in new tab
                  </a>
                </li>
                <li>
                  <a
                    class="dropdown-item d-flex align-items-center"
                    :href="'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + slotProps.data.url"
                    target="_blank"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-2">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"
                      />
                    </svg>

                    QR Code
                  </a>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center" @click="shareToFacebook(slotProps.data.url)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="hero-icon me-2">
                      <path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z" />
                      <path
                        fill="#fff"
                        d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"
                      />
                    </svg>
                    Share on Facebook
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center" @click="tweet(slotProps.data.url)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="hero-icon me-2">
                      <path
                        fill="#03A9F4"
                        d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429"
                      />
                    </svg>
                    Tweet about this
                  </button>
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center" @click="sendViaWhatsApp(slotProps.data.url)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="hero-icon me-2" fill-rule="evenodd" clip-rule="evenodd">
                      <path
                        fill="#fff"
                        d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"
                      />
                      <path
                        fill="#fff"
                        d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"
                      />
                      <path
                        fill="#cfd8dc"
                        d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"
                      />
                      <path
                        fill="#40c351"
                        d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"
                      />
                      <path
                        fill="#fff"
                        fill-rule="evenodd"
                        d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    Share via WhatsApp
                  </button>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <button class="dropdown-item text-info" data-bs-toggle="modal" data-bs-target="#editItemModal" v-on:click="openEditModal(slotProps.data)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-2">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                      />
                    </svg>

                    Edit
                  </button>
                </li>

                <li>
                  <button class="dropdown-item d-flex align-items-center d-flex align-items-center" v-on:click="replicate(slotProps.data.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-2">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"
                      />
                    </svg>

                    Replicate
                  </button>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <button class="dropdown-item d-flex align-items-center text-danger" v-on:click="deleteItem(slotProps.data.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon me-2">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                      />
                    </svg>

                    Delete
                  </button>
                </li>
              </ul>
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal" id="itemModal" tabindex="-1" no-enforce-focus aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-lg modal-dialog-scrollable">
      <form @submit.prevent="storeItem" class="modal-content rounded-4">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="itemModalLabel">Add Product</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal" @click="restoreFormControl()">Discard</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body bg-body">
          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="text-center">
              <label
                for="input-image"
                class="cursor-pointer position-relative rounded-4"
                :class="{
                  'border border-dark': !imageUrl
                }"
                style="width: 160px; height: 160px"
              >
                <img
                  :src="imageUrl"
                  class="border border-dark rounded-4"
                  alt="placeholder-image"
                  v-if="imageUrl"
                  style="width: 160px; height: 160px; object-fit: contain"
                />
                <div class="position-absolute top-50 start-50 translate-middle" v-if="!imageUrl">
                  <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48">
                      <path
                        d="M180 936q-24.75 0-42.375-17.625T120 876V276q0-24.75 17.625-42.375T180 216h409v60H180v600h600V468h60v408q0 24.75-17.625 42.375T780 936H180Zm520-498v-81h-81v-60h81v-81h60v81h81v60h-81v81h-60ZM240 774h480L576 582 449 749l-94-124-115 149Zm-60-498v600-600Z"
                      />
                    </svg>
                  </div>
                  <div class="fw-bold">Choose Image</div>
                </div>
              </label>

              <div class="text-danger" v-if="errors.hasOwnProperty('image')">
                {{ errors.image[0] }}
              </div>
              <input id="input-image" class="d-none" type="file" name="input-image" accept="image/x-png, image/jpeg, image/jpg" value="" @change="openImage" />
            </div>
          </div>

          <!-- Product Status -->
          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="status_id" class="form-label fw-bold">Product Status </label>
              <select
                class="form-select"
                v-model="data.status_id"
                id="status_id"
                :class="{ 'is-invalid': errors.hasOwnProperty('status_id') }"
                name="status_id"
              >
                <option value="1">Active</option>
                <option value="2">Drafted</option>
              </select>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('status_id')">
                {{ errors.status_id[0] }}
              </div>
              <div v-if="data.status_id == 1" class="form-text">This product will be available to checked sales channels</div>
              <div v-if="data.status_id == 2" class="form-text">This product will be <span class="fw-bold">hidden</span> from all sales channels</div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Sales Channels and APPS </label>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.pos" id="posCheckbox" />
                <label class="form-check-label" for="posCheckbox"> Point of Sale </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.website" id="websiteCheckbox" />
                <label class="form-check-label" for="websiteCheckbox"> Website </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.android_app" id="androidCheckbox" />
                <label class="form-check-label" for="androidCheckbox"> Android APP </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="data.ios_app" id="iosCheckbox" />
                <label class="form-check-label" for="iosCheckbox"> IOS APP </label>
              </div>
            </div>
          </div>
          <!--/ END Product Status -->

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="category" class="form-label fw-bold">Category</label>
              <Dropdown
                v-model="data.category"
                :options="categories"
                placeholder="Select Category*"
                :filter="false"
                filterPlaceholder="Search..."
                emptyFilterMessage="No results found"
                emptyMessage="No results found"
              >
                <template #value="slotProps">
                  <div class="d-flex align-items-center" v-if="slotProps.value">
                    <img
                      :alt="slotProps.value.name"
                      :src="slotProps.value.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.value.image_path }"
                    />
                    <span>{{ slotProps.value.name }}</span>
                  </div>
                </template>
                <template #option="slotProps">
                  <div class="d-flex align-items-center">
                    <img
                      :alt="slotProps.option.name"
                      :src="slotProps.option.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.option.image_path }"
                    />
                    <span>{{ slotProps.option.name }}</span>
                  </div>
                </template>
              </Dropdown>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('category')">
                {{ errors.category[0] }}
              </div>
            </div>

            <div class="mb-3">
              <label for="name" class="form-label fw-bold">Product Name</label>
              <input type="text" class="form-control" v-model="data.name" id="name" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" name="name" />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
                {{ errors.name[0] }}
              </div>
            </div>

            <!-- <div class="mb-3">
              <label for="serial_number" class="form-label fw-bold">Serial Number</label>
              <input
                type="text"
                class="form-control"
                v-model="data.serial_number"
                id="serial_number"
                :class="{ 'is-invalid': errors.hasOwnProperty('serial_number') }"
                name="serial_number"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('serial_number')">
                {{ errors.serial_number[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="warranty_period" class="form-label fw-bold">Warranty Period (Days)</label>
              <input
                type="number"
                class="form-control"
                v-model="data.warranty_period"
                id="warranty_period"
                :class="{ 'is-invalid': errors.hasOwnProperty('warranty_period') }"
                name="warranty_period"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('warranty_period')">
                {{ errors.warranty_period[0] }}
              </div>
            </div> -->

            <div class="mb-3">
              <label for="formFile" class="form-label fw-bold">Data Sheet</label>
              <input class="form-control" type="file" id="formFile" accept="application/pdf" @change="openDataSheet" />
              <div class="text-danger" v-if="errors.hasOwnProperty('data_sheet')">
                {{ errors.data_sheet[0] }}
              </div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label fw-bold"> Description </label>
              <ckeditor :editor="editor" v-model="data.description" :config="editorConfig"></ckeditor>
              <div class="text-danger" v-if="errors.hasOwnProperty('description')">
                {{ errors.description[0] }}
              </div>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Pricing</div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cost" class="form-label fw-bold"> Cost Per Item</label>
                <div class="position-relative">
                  <input
                    type="number"
                    class="form-control ps-4"
                    v-model="data.cost"
                    placeholder="0.00"
                    autocomplete="off"
                    step="0.01"
                    min="0"
                    id="cost"
                    :class="{ 'is-invalid': errors.hasOwnProperty('cost') }"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">
                    {{ currency }}
                  </div>
                </div>
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('cost')">
                  {{ errors.cost[0] }}
                </div>
                <div class="form-text">Customers won't see this</div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="row mb-1 small border-bottom">
                  <div class="col-6 text-muted">
                    <div>Margin</div>
                    <div class="fw-bold">{{ percentageFormat(margin) }}</div>
                  </div>
                  <div class="col-6 text-muted">
                    <div>Profit</div>
                    <div class="fw-bold">{{ formatNumber(profit) }}</div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="price" class="form-label fw-bold"> Price </label>
                <div class="position-relative">
                  <input
                    type="number"
                    class="form-control ps-4"
                    v-model="data.price"
                    placeholder="0.00"
                    autocomplete="off"
                    step="0.01"
                    min="0"
                    id="price"
                    :class="{ 'is-invalid': errors.hasOwnProperty('price') }"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">
                    {{ currency }}
                  </div>
                </div>
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('price')">
                  {{ errors.price[0] }}
                </div>
                <div class="form-text" v-if="data.discount > 0">
                  Price after Discount: <span class="fw-bold">{{ formatNumber(priceAfterDiscount) }}</span>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="discount" class="form-label fw-bold"> Discount </label>
                <div class="position-relative">
                  <input
                    type="number"
                    class="form-control ps-4"
                    v-model="data.discount"
                    step="0.1"
                    min="0"
                    max="100"
                    id="discount"
                    :class="{ 'is-invalid': errors.hasOwnProperty('discount') }"
                    placeholder="0"
                    autocomplete="off"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">%</div>
                </div>
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('discount')">
                  {{ errors.discount[0] }}
                </div>
              </div>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Inventory</div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="code" class="form-label fw-bold"> Product Code (the unique identifier and digital fingerprint of product) </label>
                <input type="text" class="form-control" v-model="data.code" id="code" :class="{ 'is-invalid': errors.hasOwnProperty('code') }" name="code" />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('code')">
                  {{ errors.code[0] }}
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="sku" class="form-label fw-bold">SKU Stock keeping unit </label>
                <input type="text" class="form-control" v-model="data.sku" id="sku" :class="{ 'is-invalid': errors.hasOwnProperty('sku') }" name="sku" />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('sku')">
                  {{ errors.sku[0] }}
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="barcode" class="form-label fw-bold">Barcode (ISBN, UPC, GTIN, etc.)</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="data.barcode"
                  id="barcode"
                  :class="{ 'is-invalid': errors.hasOwnProperty('barcode') }"
                  name="barcode"
                />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('barcode')">
                  {{ errors.barcode[0] }}
                </div>
              </div>
            </div>
            <!-- <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" v-model="data.track_stock" id="trackStockCheckbox" />
              <label class="form-check-label" for="trackStockCheckbox"> Track Stock </label>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" v-model="data.continue_selling_when_out_of_stock" id="continueSellingCheckbox" />
              <label class="form-check-label" for="continueSellingCheckbox"> Continue Selling when out of stock</label>
            </div>-->
            <div class="mb-3">
              <label for="in_stock" class="form-label fw-bold"> In Stock (Available)</label>
              <input
                type="number"
                class="form-control"
                v-model="data.in_stock"
                step="1"
                min="0"
                id="in_stock"
                :class="{ 'is-invalid': errors.hasOwnProperty('in_stock') }"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('in_stock')">
                {{ errors.in_stock[0] }}
              </div>
            </div>
          </div>
          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Media</div>
            <div class="mb-3">
              <label for="formFile" class="form-label fw-bold">Additional Images</label>
              <FileUpload
                name="images[]"
                :fileLimit="10"
                @select="openImages"
                :multiple="true"
                :maxFileSize="2097152"
                :showCancelButton="false"
                :showUploadButton="false"
                @remove="removeImage"
                ref="inputAdditionalImage"
              />
            </div>
          </div>
          <div class="border rounded-4 p-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Search engine listing preview</div>
            <div class="mb-3">
              <div class="seo-url">{{ `${app_url}/p/product` }}</div>
              <div class="seo-title">{{ data.meta_title || data.name.substring(0, 69) + '...' }}</div>
              <div class="small text-muted">{{ data.meta_description }}</div>
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label fw-bold">Page Title</label>
              <input
                type="text"
                class="form-control"
                v-model="data.meta_title"
                id="meta_title"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_title') }"
                name="meta_title"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_title')">
                {{ errors.meta_title[0] }}
              </div>
              <div class="form-text">Max 70 Characters</div>
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label fw-bold">Description</label>
              <textarea
                class="form-control"
                v-model="data.meta_description"
                id="meta_description"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_description') }"
                maxlength="320"
                name="meta_description"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_description')">
                {{ errors.meta_description[0] }}
              </div>
              <div class="form-text">Max 320 Characters</div>
            </div>
            <div class="mb-3">
              <label for="keywords" class="form-label fw-bold">Search Keywords</label>
              <input
                type="text"
                class="form-control"
                v-model="data.keywords"
                id="keywords"
                :class="{ 'is-invalid': errors.hasOwnProperty('keywords') }"
                name="keywords"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('keywords')">
                {{ errors.keywords[0] }}
              </div>
              <div class="form-text">Max 160 Characters, separated by comma</div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL EDIT -->
  <div class="modal" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-lg modal-dialog-scrollable">
      <form @submit.prevent="updateItem(editData.id)" class="modal-content rounded-4">
        <div class="modal-header d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <BackBtn />
            <h5 class="modal-title" id="editItemModalLabel">Edit Product</h5>
          </div>
          <div>
            <button type="button" class="btn btn-outline-danger px-md-4 me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary px-md-4" :disabled="loading">Save</button>
          </div>
        </div>
        <div class="modal-body bg-body">
          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div
              class="text-center"
              :class="{
                ' mb-3': editData.image_path
              }"
            >
              <label
                for="input-image-edit"
                class="cursor-pointer position-relative rounded-4"
                :class="{
                  'border border-dark': !editData.image_url
                }"
                style="width: 160px; height: 160px"
              >
                <img
                  :src="editData.image_url"
                  class="border border-dark rounded-4"
                  alt="placeholder-image"
                  v-if="editData.image_url"
                  style="width: 160px; height: 160px; object-fit: contain"
                />
                <div class="position-absolute top-50 start-50 translate-middle" v-if="!editData.image_url">
                  <div class="">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 96 960 960" width="48">
                      <path
                        d="M180 936q-24.75 0-42.375-17.625T120 876V276q0-24.75 17.625-42.375T180 216h409v60H180v600h600V468h60v408q0 24.75-17.625 42.375T780 936H180Zm520-498v-81h-81v-60h81v-81h60v81h81v60h-81v81h-60ZM240 774h480L576 582 449 749l-94-124-115 149Zm-60-498v600-600Z"
                      />
                    </svg>
                  </div>
                  <div class="fw-bold">Choose Image</div>
                </div>
              </label>

              <div class="text-danger" v-if="errors.hasOwnProperty('image')">
                {{ errors.image[0] }}
              </div>
              <input
                id="input-image-edit"
                class="d-none"
                type="file"
                name="input-image-edit"
                accept="image/x-png, image/jpeg, image/jpg"
                value=""
                @change="openImageEdit"
              />
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <button type="button" class="btn btn-sm btn-outline-danger px-4" @click="deleteImage" v-if="this.editData.image_path">Delete Image</button>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="edit_status_id" class="form-label fw-bold">Product Status </label>
              <select
                class="form-select"
                v-model="editData.status_id"
                id="edit_status_id"
                :class="{ 'is-invalid': errors.hasOwnProperty('status_id') }"
                name="edit_status_id"
              >
                <option value="1">Active</option>
                <option value="2">Drafted</option>
              </select>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('status_id')">
                {{ errors.status_id[0] }}
              </div>
              <div v-if="editData.status_id == 1" class="form-text">This product will be available to checked sales channels</div>
              <div v-if="editData.status_id == 2" class="form-text">This product will be <span class="fw-bold">hidden</span> from all sales channels</div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Sales Channels and APPS </label>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.pos" id="posEditCheckbox" />
                <label class="form-check-label" for="posEditCheckbox"> Point of Sale </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.website" id="websiteEditCheckbox" />
                <label class="form-check-label" for="websiteEditCheckbox"> Website </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.android_app" id="androidEditCheckbox" />
                <label class="form-check-label" for="androidEditCheckbox"> Android APP </label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" v-model="editData.ios_app" id="iosEditCheckbox" />
                <label class="form-check-label" for="iosEditCheckbox"> IOS APP </label>
              </div>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="mb-3">
              <label for="category" class="form-label fw-bold">Category</label>
              <Dropdown
                v-model="editData.category"
                :options="categories"
                placeholder="Select Category*"
                :filter="false"
                filterPlaceholder="Search..."
                emptyFilterMessage="No results found"
                emptyMessage="No results found"
              >
                <template #value="slotProps">
                  <div class="d-flex align-items-center" v-if="slotProps.value">
                    <img
                      :alt="slotProps.value.name"
                      :src="slotProps.value.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.value.image_path }"
                    />
                    <span>{{ slotProps.value.name }}</span>
                  </div>
                </template>
                <template #option="slotProps">
                  <div class="d-flex align-items-center">
                    <img
                      :alt="slotProps.option.name"
                      :src="slotProps.option.select_icon_url"
                      height="40"
                      class="me-2"
                      :class="{ border: !slotProps.option.image_path }"
                    />
                    <span>{{ slotProps.option.name }}</span>
                  </div>
                </template>
              </Dropdown>
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('category')">
                {{ errors.category[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="name" class="form-label fw-bold">Product Name</label>
              <input type="text" class="form-control" v-model="editData.name" id="name" :class="{ 'is-invalid': errors.hasOwnProperty('name') }" name="name" />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('name')">
                {{ errors.name[0] }}
              </div>
            </div>

            <!-- <div class="mb-3">
              <label for="serial_number" class="form-label fw-bold">Serial Number</label>
              <input
                type="text"
                class="form-control"
                v-model="editData.serial_number"
                id="serial_number"
                :class="{ 'is-invalid': errors.hasOwnProperty('serial_number') }"
                name="serial_number"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('serial_number')">
                {{ errors.serial_number[0] }}
              </div>
            </div>

            <div class="mb-3">
              <label for="warranty_period" class="form-label fw-bold">Warranty Period (Days)</label>
              <input
                type="number"
                class="form-control"
                v-model="editData.warranty_period"
                id="warranty_period"
                :class="{ 'is-invalid': errors.hasOwnProperty('warranty_period') }"
                name="warranty_period"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('warranty_period')">
                {{ errors.warranty_period[0] }}
              </div>
            </div> -->

            <div class="mb-3">
              <label for="formFileEdit" class="form-label fw-bold">Data Sheet</label>
              <input class="form-control" type="file" id="formFileEdit" accept="application/pdf" @change="openDataSheetEdit" />
              <div class="text-danger" v-if="errors.hasOwnProperty('data_sheet')">
                {{ errors.data_sheet[0] }}
              </div>
            </div>
            <div class="mb-3">
              <label for="edit-description" class="form-label fw-bold"> Description </label>
              <ckeditor :editor="editor" v-model="editData.description" :config="editorConfig"></ckeditor>
              <div class="text-danger" v-if="errors.hasOwnProperty('description')">
                {{ errors.description[0] }}
              </div>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Pricing</div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cost-edit" class="form-label fw-bold"> Cost Per Item</label>
                <div class="position-relative">
                  <input
                    type="number"
                    class="form-control ps-4"
                    v-model="editData.cost"
                    placeholder="0.00"
                    autocomplete="off"
                    step="0.01"
                    min="0"
                    id="cost-edit"
                    :class="{ 'is-invalid': errors.hasOwnProperty('cost') }"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">
                    {{ currency }}
                  </div>
                </div>
                <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('cost')">
                  {{ errors.cost[0] }}
                </div>
                <div class="form-text">Customers won't see this</div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="row mb-1 small border-bottom">
                  <div class="col-6 text-muted">
                    <div>Margin</div>
                    <div class="fw-bold">{{ percentageFormat(marginEdit) }}</div>
                  </div>
                  <div class="col-6 text-muted">
                    <div>Profit</div>
                    <div class="fw-bold">{{ formatNumber(profitEdit) }}</div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="price_edit" class="form-label fw-bold"> Price </label>
                <div class="position-relative">
                  <input
                    type="number"
                    class="form-control ps-4"
                    v-model="editData.price"
                    placeholder="0.00"
                    autocomplete="off"
                    step="0.01"
                    min="0"
                    id="price_edit"
                    :class="{ 'is-invalid': errors.hasOwnProperty('price') }"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">
                    {{ currency }}
                  </div>
                </div>
                <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('price')">
                  {{ errors.price[0] }}
                </div>
                <div class="form-text" v-if="editData.discount > 0">
                  Price after Discount: <span class="fw-bold">{{ formatNumber(priceAfterDiscountEdit) }}</span>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="discount_edit" class="form-label fw-bold"> Discount </label>
                <div class="position-relative">
                  <input
                    type="number"
                    class="form-control ps-4"
                    v-model="editData.discount"
                    step="0.1"
                    min="0"
                    max="100"
                    id="discount_edit"
                    :class="{ 'is-invalid': errors.hasOwnProperty('discount') }"
                    placeholder="0"
                    autocomplete="off"
                  />
                  <div class="position-absolute top-50 start-0 translate-middle-y p-2 text-muted user-select-none">%</div>
                </div>
                <div class="text-danger mt-1 small" v-if="errors.hasOwnProperty('discount')">
                  {{ errors.discount[0] }}
                </div>
              </div>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Inventory</div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <label for="code-edit" class="form-label fw-bold"> Product Code (the unique identifier and digital fingerprint of product) </label>
                <input
                  type="text"
                  class="form-control"
                  v-model="editData.code"
                  id="code-edit"
                  :class="{ 'is-invalid': errors.hasOwnProperty('code') }"
                  name="code-edit"
                />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('code')">
                  {{ errors.code[0] }}
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sku-edit" class="form-label fw-bold">SKU Stock keeping unit </label>
                <input
                  type="text"
                  class="form-control"
                  v-model="editData.sku"
                  id="sku-edit"
                  :class="{ 'is-invalid': errors.hasOwnProperty('sku') }"
                  name="sku-edit"
                />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('sku')">
                  {{ errors.sku[0] }}
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="barcode-edit" class="form-label fw-bold">Barcode (ISBN, UPC, GTIN, etc.)</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="editData.barcode"
                  id="barcode-edit"
                  :class="{ 'is-invalid': errors.hasOwnProperty('barcode') }"
                  name="barcode-edit"
                />
                <div class="invalid-feedback" v-if="errors.hasOwnProperty('barcode')">
                  {{ errors.barcode[0] }}
                </div>
              </div>
            </div>
            <!-- <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" v-model="editData.track_stock" id="trackStockCheckboxEdit" />
              <label class="form-check-label" for="trackStockCheckboxEdit"> Track Stock </label>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" v-model="editData.continue_selling_when_out_of_stock" id="continueSellingCheckboxEdit" />
              <label class="form-check-label" for="continueSellingCheckboxEdit"> Continue Selling when out of stock</label>
            </div> -->
            <div class="mb-3">
              <label for="in_stock" class="form-label fw-bold"> In Stock (Available)</label>
              <input
                type="number"
                class="form-control"
                v-model="editData.in_stock"
                step="1"
                min="0"
                id="in_stock"
                :class="{ 'is-invalid': errors.hasOwnProperty('in_stock') }"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('in_stock')">
                {{ errors.in_stock[0] }}
              </div>
            </div>
          </div>

          <div class="border rounded-4 p-3 mb-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Media</div>
            <div class="mb-3">
              <label for="formFile" class="form-label fw-bold">Additional Images</label>
              <FileUpload
                name="imagesEdit[]"
                :fileLimit="itemAdditionalImages.length ? 10 - itemAdditionalImages.length : 10"
                @select="openImagesEdit"
                :multiple="true"
                :maxFileSize="2097152"
                :showCancelButton="false"
                :showUploadButton="false"
                @remove="removeImageEdit"
                ref="inputAdditionalImageEdit"
              />
            </div>
            <div class="mb-3">
              <table class="table">
                <tbody>
                  <tr v-for="additionalImage in itemAdditionalImages" :key="additionalImage.id">
                    <th>
                      <img :src="additionalImage.thumbnail_url" width="50" />
                    </th>
                    <td>
                      <button type="button" class="btn btn-sm btn-danger shadow-none" @click="deleteAdditionalImage(additionalImage)" :disabled="loading">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon">
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                          />
                        </svg>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="border rounded-4 p-3 bg-white border-light shadow-sm">
            <div class="form-label fw-bold mb-3">Search engine listing preview</div>
            <div class="mb-3">
              <div class="seo-url">{{ `${app_url}/p/product` }}</div>
              <div class="seo-title">{{ editData.meta_title || editData.name.substring(0, 69) + '...' }}</div>
              <div class="small text-muted">{{ editData.meta_description }}</div>
            </div>
            <div class="mb-3">
              <label for="meta_title_edit" class="form-label fw-bold">Page Title</label>
              <input
                type="text"
                class="form-control"
                v-model="editData.meta_title"
                id="meta_title_edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_title') }"
                name="meta_title_edit"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_title')">
                {{ errors.meta_title[0] }}
              </div>
              <div class="form-text">Max 70 Characters</div>
            </div>
            <div class="mb-3">
              <label for="meta_description_edit" class="form-label fw-bold">Description</label>
              <textarea
                class="form-control"
                v-model="editData.meta_description"
                id="meta_description_edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('meta_description') }"
                maxlength="320"
                name="meta_description_edit"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('meta_description')">
                {{ errors.meta_description[0] }}
              </div>
              <div class="form-text">Max 320 Characters</div>
            </div>
            <div class="mb-3">
              <label for="keywords_edit" class="form-label fw-bold">Search Keywords</label>
              <input
                type="text"
                class="form-control"
                v-model="editData.keywords"
                id="keywords_edit"
                :class="{ 'is-invalid': errors.hasOwnProperty('keywords') }"
                name="keywords_edit"
                maxlength="70"
              />
              <div class="invalid-feedback" v-if="errors.hasOwnProperty('keywords')">
                {{ errors.keywords[0] }}
              </div>
              <div class="form-text">Max 160 Characters, separated by comma</div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import FileUpload from 'primevue/fileupload';
import { swalConfig, usd_money_format } from '@/services/utils';
import { percentage_format } from '@/services/utils';
import config from '@/config';

export default {
  components: { FileUpload },
  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {
        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote']
      },
      currency: config.CURRENCY_SYMBOL,
      app_url: config.APP_URL,
      items: [],
      categories: [],
      pageOfItems: [],
      search: '',
      data: {
        name: '',
        image: '',
        data_sheet: '',
        description: '',
        price: null,
        discount: null,
        cost: null,
        in_stock: 0,
        category: null,
        sku: '',
        barcode: '',
        code: '',
        serial_number: '',
        warranty_period: '',
        track_stock: true,
        status_id: 1,
        meta_title: '',
        meta_description: '',
        keywords: '',
        pos: true,
        website: true,
        android_app: true,
        ios_app: true,
        continue_selling_when_out_of_stock: true,
        additionalImages: []
      },
      itemAdditionalImages: [],
      imageUrl: '',
      editData: {
        id: '',
        name: '',
        image: '',
        data_sheet: '',
        image_url: '',
        image_path: '',
        description: '',
        price: null,
        discount: null,
        cost: null,
        in_stock: 0,
        category: null,
        sku: '',
        barcode: '',
        code: '',
        serial_number: '',
        warranty_period: '',
        track_stock: true,
        status_id: 1,
        meta_title: '',
        meta_description: '',
        keywords: '',
        pos: true,
        website: true,
        android_app: true,
        ios_app: true,
        continue_selling_when_out_of_stock: false,
        additionalImages: []
      },
      errors: {},
      loading: false,
      loadingData: true
    };
  },
  mounted() {},
  methods: {
    helloW(a) {
      console.log(this.editData.in_stock)
    },
    exportCSV() {
      this.$refs.dt.exportCSV();
    },
    fetchItems() {
      topbar.show();
      axios
        .get('/admin/items/all')
        .then(response => (this.items = response.data.data))
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, response.statusText, 'error');
        })
        .finally(() => {
          topbar.hide();
          this.loadingData = false;
        });
    },
    fetchCategories() {
      axios
        .get('/admin/categories/all')
        .then(response => (this.categories = response.data.data))
        .catch(({ response }) => Swal.fire('Error ', 'Could not fetch categories', 'error'));
    },
    deleteItem(id) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/items/${id}`)
            .then(response => {
              if (response.status == 200) {
                //this.fetchItems();
                this.items = this.items.filter(item => item.id != id);
                this.$toast.success('Product deleted');
              }
            })
            .catch(({ response }) => Swal.fire('Error ' + response.status, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },

    storeItem() {
      this.errors = {};
      topbar.show();
      this.loading = true;
      const formData = new FormData();
      formData.append('image', this.data.image);
      formData.append('data_sheet', this.data.data_sheet);
      formData.append('name', this.data.name);
      formData.append('price', this.data.price || 0);
      formData.append('discount', this.data.discount || 0);
      formData.append('cost', this.data.cost || 0);
      formData.append('sku', this.data.sku || '');
      formData.append('barcode', this.data.barcode || '');
      formData.append('code', this.data.code || '');
      formData.append('serial_number', this.data.serial_number || '');
      formData.append('in_stock', this.data.in_stock);
      formData.append('description', this.data.description || '');
      formData.append('category', this.data.category.id);
      formData.append('status', this.data.status_id);
      formData.append('meta_title', this.data.meta_title || '');
      formData.append('meta_description', this.data.meta_description || '');
      formData.append('keywords', this.data.keywords || '');
      formData.append('warranty_period', this.data.warranty_period || '');

      if (this.data.pos) {
        formData.append('pos', this.data.pos);
      }

      if (this.data.website) {
        formData.append('website', this.data.website);
      }

      if (this.data.android_app) {
        formData.append('android_app', this.data.android_app);
      }
      if (this.data.ios_app) {
        formData.append('ios_app', this.data.ios_app);
      }

      if (this.data.track_stock) {
        formData.append('track_stock', this.data.track_stock);
      }

      if (this.data.discount) {
        formData.append('continue_selling_when_out_of_stock', this.data.continue_selling_when_out_of_stock);
      }

      if (this.data.additionalImages.length) {
        for (let index = 0; index < this.data.additionalImages.length; index++) {
          formData.append('additional_images[]', this.data.additionalImages[index]);
        }
      }
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
      axios
        .post('/admin/items', formData, config)
        .then(response => {
          this.fetchItems();
          this.restoreFormControl();
          this.$toast.success('Product has been added');
          this.$refs.inputAdditionalImage.clear();
          this.data.additionalImages = [];
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire(`Error ${response.status}`, response.statusText, 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },

    updateItem(id) {
      this.errors = {};
      topbar.show();
      this.loading = true;
      const formData = new FormData();
      
      formData.append('image', this.editData.image);
      formData.append('data_sheet', this.editData.data_sheet);
      formData.append('name', this.editData.name);
      formData.append('price', this.editData.price || 0);
      formData.append('discount', this.editData.discount || 0);
      formData.append('cost', this.editData.cost || 0);
      formData.append('sku', this.editData.sku || '');
      formData.append('barcode', this.editData.barcode || '');
      formData.append('code', this.editData.code || '');
      formData.append('serial_number', this.editData.serial_number || '');
      formData.append('in_stock', this.editData.in_stock);
      formData.append('description', this.editData.description || '');
      formData.append('category', this.editData.category.id);
      formData.append('status', this.editData.status_id);
      formData.append('meta_title', this.editData.meta_title || '');
      formData.append('meta_description', this.editData.meta_description || '');
      formData.append('keywords', this.editData.keywords || '');
      formData.append('warranty_period', this.editData.warranty_period || '');

      if (this.editData.pos) {
        formData.append('pos', this.editData.pos);
      }

      if (this.editData.website) {
        formData.append('website', this.editData.website);
      }

      if (this.editData.android_app) {
        formData.append('android_app', this.editData.android_app);
      }
      if (this.editData.ios_app) {
        formData.append('ios_app', this.editData.ios_app);
      }

      if (this.editData.track_stock) {
        formData.append('track_stock', this.editData.track_stock);
      }

      if (this.editData.continue_selling_when_out_of_stock) {
        formData.append('continue_selling_when_out_of_stock', this.editData.continue_selling_when_out_of_stock);
      }
      formData.append('_method', 'PUT');

      if (this.editData.additionalImages.length) {
        for (let index = 0; index < this.editData.additionalImages.length; index++) {
          formData.append('additional_images[]', this.editData.additionalImages[index]);
        }
      }
      console.log('updateItems::',JSON.parse(JSON.stringify(this.editData)))
      console.log('formdata: ', formData)
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
      axios
        .post(`/admin/items/${id}`, formData, config)
        .then(response => {
          this.fetchItems();
          this.$toast.success('Product updated');
          this.$refs.inputAdditionalImageEdit.clear();
          let updatedItem = response.data.data;
          this.openEditModal(updatedItem);
          this.editData.additionalImages = [];
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.errors = response.data.errors;
          } else {
            Swal.fire(`Error ${response.status}`, response.statusText, 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },
    openEditModal(item) {
      console.log('item:', item);
      this.errors = {};
      this.editData.id = item.id;
      this.editData.name = item.name;
      this.editData.image = '';
      if (item.image_path) {
        this.editData.image_url = item.image_url;
        this.editData.image_path = item.image_path;
      } else {
        this.editData.image_url = null;
        this.editData.image_path = null;
      }
      this.editData.price = item.price;
      this.editData.discount = item.discount;
      this.editData.cost = item.cost;
      this.editData.in_stock = item.in_stock;
      this.editData.sku = item.sku;
      this.editData.barcode = item.barcode;
      this.editData.code = item.code;
      this.editData.serial_number = item.serial_number;
      this.editData.warranty_period = item.warranty_period;
      this.editData.track_stock = item.track_stock;
      this.editData.continue_selling_when_out_of_stock = item.continue_selling_when_out_of_stock;
      this.editData.pos = item.pos;
      this.editData.website = item.website;
      this.editData.android_app = item.android_app;
      this.editData.ios_app = item.ios_app;
      this.editData.status_id = item.status_id;
      this.editData.description = item.description || '';
      this.editData.category = item.category;
      this.editData.meta_title = item.meta_title;
      this.editData.meta_description = item.meta_description;
      this.editData.keywords = item.keywords;
      this.itemAdditionalImages = item.additional_images;
    },
    deleteImage() {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .delete(`/admin/items/image/${this.editData.id}`)
            .then(response => {
              if (response.status == 200) {
                this.editData.image = '';
                this.editData.image_url = null;
                this.editData.image_path = null;
                var itemToUpdate = this.items.find(item => item.id == this.editData.id);
                if (itemToUpdate) {
                  itemToUpdate.image = '';
                  itemToUpdate.image_url = null;
                  itemToUpdate.image_path = null;
                }
                this.$toast.success('Image has been deleted');
              }
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .then(() => topbar.hide());
        }
      });
    },
    deleteAdditionalImage(image) {
      Swal.fire(swalConfig()).then(result => {
        if (result.value) {
          topbar.show();
          this.loading = true;
          axios
            .delete(`/admin/items/additional-image/${image.id}`)
            .then(response => {
              var newAdditionalImages = this.itemAdditionalImages.filter(i => i !== image);
              this.itemAdditionalImages = newAdditionalImages;
              this.fetchItems();
              this.$toast.success('Product additional image has been Deleted');
            })
            .catch(error => console.log(error))
            .then(() => {
              topbar.hide();
              this.loading = false;
            });
        }
      });
    },
    removeImage(event) {
      this.data.additionalImages = [];
      var files = event.files;
      for (var i = 0; i < files.length; i++) {
        this.data.additionalImages.push(files[i]);
      }
    },
    removeImageEdit(event) {
      this.editData.additionalImages = [];
      var files = event.files;
      for (var i = 0; i < files.length; i++) {
        this.editData.additionalImages.push(files[i]);
      }
    },
    openImages(event) {
      this.data.additionalImages = [];
      var files = event.files;
      if (!files.length) {
        return false;
      }
      for (var i = 0; i < files.length; i++) {
        this.data.additionalImages.push(files[i]);
      }
    },
    openImagesEdit(event) {
      this.editData.additionalImages = [];
      var files = event.files;
      if (!files.length) {
        return false;
      }
      for (var i = 0; i < files.length; i++) {
        this.editData.additionalImages.push(files[i]);
      }
    },
    restoreFormControl() {
      this.errors = {};
      this.data.name = '';
      this.data.image = '';
      this.data.data_sheet = '';
      this.data.description = '';
      this.data.price = null;
      this.data.discount = null;
      this.data.cost = null;
      this.data.in_stock = 0;
      this.data.category = null;
      this.data.sku = '';
      this.data.barcode = '';
      this.data.code = '';
      this.data.serial_number = '';
      this.data.warranty_period = '';
      this.imageUrl = '';
      this.data.track_stock = true;
      this.data.continue_selling_when_out_of_stock = true;
      this.data.pos = true;
      this.data.website = true;
      this.data.android_app = true;
      this.data.ios_app = true;
      this.data.status_id = 1;
      this.data.meta_title = '';
      this.data.meta_description = '';
      this.data.keywords = '';
    },
    openImage(event) {
      var file = event.target.files[0];
      if (file) {
        this.data.image = file;
        this.imageUrl = URL.createObjectURL(this.data.image);
      } else {
        this.data.image = this.data.image;
        this.imageUrl = this.imageUrl;
      }
    },
    openImageEdit(event) {
      var file = event.target.files[0];
      if (file) {
        this.editData.image = file;
        this.editData.image_url = URL.createObjectURL(this.editData.image);
      } else {
        this.editData.image = this.editData.image;
        this.editData.image_url = this.editData.image_url;
      }
    },

    openDataSheet(event) {
      var file = event.target.files[0];
      if (file) {
        this.data.data_sheet = file;
      } else {
        this.data.data_sheet = this.data.data_sheet;
      }
    },
    openDataSheetEdit(event) {
      var file = event.target.files[0];
      if (file) {
        this.editData.data_sheet = file;
      } else {
        this.editData.data_sheet = this.editData.data_sheet;
      }
    },

    replicate(id) {
      Swal.fire(swalConfig('Replicate this product?', '')).then(result => {
        if (result.value) {
          topbar.show();
          axios
            .post(`/admin/items/replicate/${id}`, null)
            .then(response => {
              this.fetchItems();
              this.$toast.success('Product replicated');
            })
            .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
            .finally(() => topbar.hide());
        }
      });
    },
    copyLinkToClipBoard(item) {
      var input = document.createElement('textarea');
      input.innerHTML = item.url;
      document.body.appendChild(input);
      input.select();
      var result = document.execCommand('copy');
      document.body.removeChild(input);
      this.$toast.success('Copied to clipboard');
    },
    shareToFacebook(url) {
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    },
    tweet(url) {
      window.open(`https://twitter.com/intent/tweet?text=${url}`, '_blank');
    },
    sendViaWhatsApp(url) {
      window.open(`https://wa.me/?text=${url}`, '_blank');
    },
    formatNumber(number) {
      return usd_money_format(number, this.currency);
    },
    percentageFormat(number) {
      return percentage_format(number);
    }
  },

  created: function () {
    this.fetchItems();
    this.fetchCategories();
  },
  computed: {
    priceAfterDiscount() {
      if (this.data.discount > 0) {
        return this.data.price - (this.data.discount / 100) * this.data.price;
      }
      if (this.data.discount > 100) {
        return this.data.price - (this.data.discount / 100) * this.data.price;
      }
      return this.data.price;
    },

    profit() {
      return this.priceAfterDiscount - this.data.cost;
    },
    margin() {
      return (this.profit / this.priceAfterDiscount) * 100;
    },

    priceAfterDiscountEdit() {
      if (this.editData.discount > 0) {
        return this.editData.price - (this.editData.discount / 100) * this.editData.price;
      }
      if (this.editData.discount > 100) {
        return this.editData.price - (this.editData.discount / 100) * this.editData.price;
      }
      return this.editData.price;
    },

    profitEdit() {
      return this.priceAfterDiscountEdit - this.editData.cost;
    },
    marginEdit() {
      return (this.profitEdit / this.priceAfterDiscountEdit) * 100;
    },

    itemList() {
      const search = this.search.toLowerCase();
      if (!search) return this.items;
      return this.items.filter(item => {
        return item.search_name.toLowerCase().includes(search) || item.serial_number.toLowerCase().includes(search);
      });
    }
  }
};
</script>
<style>
.p-dropdown-panel {
  z-index: 5000 !important;
}
</style>
