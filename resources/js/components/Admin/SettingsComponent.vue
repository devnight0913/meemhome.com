<template>
  <div class="border rounded-3 p-3 mb-3 bg-white border-light shadow-sm">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button
          class="nav-link active"
          id="nav-general-tab"
          data-bs-toggle="tab"
          data-bs-target="#nav-general"
          type="button"
          role="tab"
          aria-controls="nav-general"
          aria-selected="true"
        >
          General
        </button>
        <button
          class="nav-link"
          id="nav-social-media-tab"
          data-bs-toggle="tab"
          data-bs-target="#nav-social-media"
          type="button"
          role="tab"
          aria-controls="nav-social-media"
          aria-selected="false"
        >
          Social Media & Links
        </button>
        <button
          class="nav-link"
          id="nav-contact-tab"
          data-bs-toggle="tab"
          data-bs-target="#nav-contact"
          type="button"
          role="tab"
          aria-controls="nav-contact"
          aria-selected="false"
        >
          Contact
        </button>
        <button
          class="nav-link"
          id="nav-information-tab"
          data-bs-toggle="tab"
          data-bs-target="#nav-information"
          type="button"
          role="tab"
          aria-controls="nav-information"
          aria-selected="false"
        >
          Information
        </button>
      </div>
    </nav>
    <div class="tab-content pt-3" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab" tabindex="0">
        <form @submit.prevent="update('ADMIN_EMAIL', adminEmailData)">
          <div class="mb-3">
            <label for="adminEmail" class="form-label mb-1 fw-bold"> Admin Email</label>
            <input type="text" class="form-control" v-model="adminEmailData.value" id="adminEmail"/>
            <div class="form-text">Primary email. Order notifications, contact and others will be send to this email. (customers won't see this)</div>
            <div class="d-flex mt-3">
              <button type="submit" class="btn btn-primary px-4 shadow-sm me-2" :disabled="loading">Save</button>
              <button type="button" v-on:click="testEmail" class="btn btn-outline-primary px-4 shadow-sm" :disabled="loading">Test Email</button>
            </div>
          </div>
        </form>
        <hr />

        <form @submit.prevent="update('META_TITLE', metaTitleData)">
          <div class="mb-3">
            <label for="metaTitle" class="form-label mb-1 fw-bold"> Meta Title</label>
            <input type="text" class="form-control mb-3" v-model="metaTitleData.value" id="metaTitle" />
            <button type="submit" class="btn btn-primary px-4 shadow-sm mt-3" :disabled="loading">Save</button>
          </div>
        </form>
        <hr />

        <form @submit.prevent="update('META_DESCRIPTION', metaDescriptionData)">
          <div class="mb-3">
            <label for="metaDescription" class="form-label mb-1 fw-bold"> Meta Description</label>
            <textarea class="form-control mb-3" v-model="metaDescriptionData.value" id="metaDescription" rows="4"></textarea>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </div>
        </form>
        <hr />
        <form @submit.prevent="update('KEYWORDS', keywordsData)">
          <div class="mb-3">
            <label for="keywords" class="form-label mb-1 fw-bold"> Search Keywords</label>
            <input type="text" class="form-control mb-3" v-model="keywordsData.value" id="keywords" />
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </div>
        </form>
      </div>

      <div class="tab-pane fade" id="nav-social-media" role="tabpanel" aria-labelledby="nav-social-media-tab" tabindex="0">
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('WHATSAPP', whatsappData)">
            <div class="mb-3">
              <label for="whatsapp" class="form-label mb-1 fw-bold"> WhatsApp </label>

              <div class="input-group">
                <span class="input-group-text" id="basic-addon1"> https://wa.me/</span>
                <input type="text" class="form-control" v-model="whatsappData.value" id="whatsapp" />
              </div>
              <div class="form-text">
                <a target="_blank" href="https://faq.whatsapp.com/452366545421244/?locale=en_US">How to use click to chat </a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('FACEBOOK_URL', facebookUrlData)">
            <div class="mb-3">
              <label for="facebookUrl" class="form-label mb-1 fw-bold"> Facebook URL</label>
              <input type="text" class="form-control" v-model="facebookUrlData.value" id="facebookUrl" />
              <div class="form-text">
                <a target="_blank" href="https://www.facebook.com/help/2053403608222571">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('FACEBOOK_MESSENGER', facebookMessengerData)">
            <div class="mb-3">
              <label for="facebookMessenger" class="form-label mb-1 fw-bold"> Facebook Messenger</label>
              <input type="text" class="form-control" v-model="facebookMessengerData.value" id="facebookMessenger" />
              <div class="form-text">
                <a target="_blank" href="https://www.facebook.com/help/2053403608222571">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('INSTAGRAM_URL', instagramUrlData)">
            <div class="mb-3">
              <label for="instagramUrl" class="form-label mb-1 fw-bold"> Instagram URL</label>
              <input type="text" class="form-control" v-model="instagramUrlData.value" id="instagramUrl" />
              <div class="form-text">
                <a target="_blank" href="https://help.instagram.com/372819389498306">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('TWITTER_URL', twitterUrlData)">
            <div class="mb-3">
              <label for="twitterUrl" class="form-label mb-1 fw-bold"> Twitter URL</label>
              <input type="text" class="form-control" v-model="twitterUrlData.value" id="twitterUrl" />
              <div class="form-text">
                <a target="_blank" href="https://linktr.ee/blog/how-to-find-your-twitter-url/">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('YOUTUBE_URL', youtubeUrlData)">
            <div class="mb-3">
              <label for="youtubeUrl" class="form-label mb-1 fw-bold"> YouTube URL</label>
              <input type="text" class="form-control" v-model="youtubeUrlData.value" id="youtubeUrl" />
              <div class="form-text">
                <a target="_blank" href="https://support.google.com/youtube/answer/6180214?hl=en">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('TIKTOK_URL', tiktokUrlData)">
            <div class="mb-3">
              <label for="tiktokUrl" class="form-label mb-1 fw-bold"> TikTok URL</label>
              <input type="text" class="form-control" v-model="tiktokUrlData.value" id="tiktokUrl" />
              <div class="form-text">
                <a target="_blank" href="https://support.voxfeed.com/hc/en-us/articles/360044569851-How-to-get-your-TikTok-account-username-and-link"
                  >More info</a
                >
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('GOOGLE_PLAY_URL', googlePlayUrlData)">
            <div class="mb-3">
              <label for="googlePlayUrl" class="form-label mb-1 fw-bold">Google Play URL</label>
              <input type="text" class="form-control" v-model="googlePlayUrlData.value" id="googlePlayUrl" />
              <div class="form-text">
                <a target="_blank" href="https://support.google.com/admob/answer/3086746?hl=en">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3 border-bottom pb-3">
          <form @submit.prevent="update('APP_STORE_URL', appStoreUrlData)">
            <div class="mb-3">
              <label for="appStoreUrl" class="form-label mb-1 fw-bold">App Store URL</label>
              <input type="text" class="form-control" v-model="appStoreUrlData.value" id="appStoreUrl" />
              <div class="form-text">
                <a target="_blank" href="https://developer.apple.com/forums/thread/68628">More info</a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
        <div class="mb-3">
          <form @submit.prevent="update('ADDRESS', addressData)">
            <div class="mb-3">
              <label for="address" class="form-label mb-1 fw-bold"> Address</label>
              <input type="text" class="form-control" v-model="addressData.value" id="address" />
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3">
          <form @submit.prevent="update('EMAIL', emailData)">
            <div class="mb-3">
              <label for="email" class="form-label mb-1 fw-bold"> Email</label>
              <input type="text" class="form-control" v-model="emailData.value" id="email" />
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3">
          <form @submit.prevent="update('PHONE', phoneData)">
            <div class="mb-3">
              <label for="phone" class="form-label mb-1 fw-bold"> phone</label>
              <input type="text" class="form-control" v-model="phoneData.value" id="phone" />
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3">
          <form @submit.prevent="update('GOOGLE_MAPS_SHARE_LINK', googleMapsShareLinkData)">
            <div class="mb-3">
              <label for="googleMapsShareLink" class="form-label mb-1 fw-bold"> Google Maps Share Link</label>
              <input type="text" class="form-control" v-model="googleMapsShareLinkData.value" id="googleMapsShareLink" />
              <div class="form-text">
                <a target="_blank" href="https://support.google.com/maps/answer/144361?hl=en">More info about Google Maps Share Link </a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <div class="mb-3">
          <form @submit.prevent="update('GOOGLE_MAPS_IFRAME', googleMapsIframeLinkData)">
            <div class="mb-3">
              <label for="googleMapsIframeLink" class="form-label mb-1 fw-bold"> Google Maps IFrame</label>
              <textarea type="text" class="form-control" v-model="googleMapsIframeLinkData.value" id="googleMapsIframeLink" rows="5"></textarea>
              <div class="form-text">
                <a target="_blank" href="https://developers.google.com/maps/documentation/embed/get-started"> More info about Google Maps IFrame </a>
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-information" role="tabpanel" aria-labelledby="nav-information-tab" tabindex="0">
        <div class="mb-3">
          <form @submit.prevent="update('ABOUT', aboutData)">
            <div class="mb-3">
              <label for="about" class="form-label mb-1 fw-bold">
                <a target="_blank" href="/about" class="link-primary"> About Us Page <MtIcon icon="open_in_new" styleName="fs-5"></MtIcon> </a>
              </label>
              <ckeditor :editor="editor" v-model="aboutData.value" :config="editorConfig"></ckeditor>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
        <hr />
        <div>
          <form @submit.prevent="update('GLOBAL_ALERT', globalAlertData)">
            <div class="mb-3">
              <label for="about" class="form-label mb-1 fw-bold">
                Global Alert
                <br />
                <small class="text-info"> This alert will be shown on the homepage </small>
              </label>
              <ckeditor :editor="editor" v-model="globalAlertData.value" :config="editorConfig"></ckeditor>
              <div class="form-text">This field is for any special notes you would like to tell the customer</div>
            </div>
            <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loading">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
      },
      loading: false,
      adminEmailData: {
        value: ''
      },
      aboutData: {
        value: ''
      },
      globalAlertData: {
        value: ''
      },
      addressData: {
        value: ''
      },
      emailData: {
        value: ''
      },
      phoneData: {
        value: ''
      },
      googleMapsShareLinkData: {
        value: ''
      },
      googleMapsIframeLinkData: {
        value: ''
      },
      facebookUrlData: {
        value: ''
      },
      instagramUrlData: {
        value: ''
      },
      twitterUrlData: {
        value: ''
      },
      youtubeUrlData: {
        value: ''
      },
      tiktokUrlData: {
        value: ''
      },
      metaTitleData: {
        value: ''
      },
      metaDescriptionData: {
        value: ''
      },
      keywordsData: {
        value: ''
      },
      whatsappData: {
        value: ''
      },
      googlePlayUrlData: {
        value: ''
      },
      appStoreUrlData: {
        value: ''
      },
      facebookMessengerData: {
        value: ''
      }
    };
  },
  created() {
    this.fetchSettings();
  },
  methods: {
    fetchSettings() {
      topbar.show();
      axios
        .get('/admin/settings/all')
        .then(response => {
          this.adminEmailData.value = response.data.admin_email;
          this.aboutData.value = response.data.about || '';
          this.globalAlertData.value = response.data.global_alert || '';
          this.addressData.value = response.data.address;
          this.emailData.value = response.data.email;
          this.phoneData.value = response.data.phone;
          this.googleMapsShareLinkData.value = response.data.gm_share_link;
          this.googleMapsIframeLinkData.value = response.data.gm_iframe;
          this.facebookUrlData.value = response.data.fb_url;
          this.instagramUrlData.value = response.data.insta_url;
          this.twitterUrlData.value = response.data.tw_url;
          this.youtubeUrlData.value = response.data.yt_url;
          this.tiktokUrlData.value = response.data.tiktok_url;
          this.whatsappData.value = response.data.whatsapp;
          this.metaTitleData.value = response.data.meta_title;
          this.metaDescriptionData.value = response.data.meta_description;
          this.keywordsData.value = response.data.keywords;
          this.googlePlayUrlData.value = response.data.google_play_url;
          this.appStoreUrlData.value = response.data.app_store_url;
          this.facebookMessengerData.value = response.data.facebook_messenger;
        })
        .catch(({ response }) => Swal.fire(`Error ${response.status}`, response.statusText, 'error'))
        .then(() => topbar.hide());
    },

    update(key, data) {
      topbar.show();
      this.loading = true;
      axios
        .put(`/admin/settings/${key}`, data)
        .then(response => {
          this.$toast.success('Settings has been updated.');
        })
        .catch(({ response }) => {
          if (response.status === 422 || response.status === 429) {
            this.$toast.error(response.data.errors);
          } else {
            Swal.fire(`Error ${response.status}`, response.statusText, 'error');
          }
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    },

    testEmail() {
      topbar.show();
      this.loading = true;
      axios
        .get(`/admin/email/primary/test`)
        .then(response => {
          this.$toast.success('Mail has been sent.');
        })
        .catch(({ response }) => {
          Swal.fire(`Error ${response.status}`, `an error occurred while sending email ${response.statusText}`, 'error');
        })
        .then(() => {
          topbar.hide();
          this.loading = false;
        });
    }
  },
  mounted() {}
};
</script>
