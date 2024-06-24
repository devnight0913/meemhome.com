window._ = require("lodash");
import * as bootstrap from 'bootstrap';
import intlTelInput from 'intl-tel-input';
import SlimSelect from 'slim-select'

try {
    window.Popper = require('@popperjs/core').default;
    window.bootstrap = bootstrap;
    window.LazyLoad = require("vanilla-lazyload");
    window.Swal = require("sweetalert2");
    window.topbar = require("topbar");
    window.intlTelInput = intlTelInput;
    window.SlimSelect = SlimSelect;

    //require("@fortawesome/fontawesome-free/js/all");
    require("./main");
} catch (e) {}
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';