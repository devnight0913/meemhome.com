require('./bootstrap');
import { createApp } from 'vue';
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';
import AdminLoginComponent from './components/Admin/Auth/AdminLoginComponent.vue';
import CategoryComponent from './components/Admin/CategoryComponent.vue';
import PaymentMethodComponent from './components/Admin/PaymentMethodComponent.vue';
import ItemComponent from './components/Admin/ItemComponent.vue';
import ServiceComponent from './components/Admin/ServiceComponent.vue';
import BannerComponent from './components/Admin/BannerComponent.vue';
import AreaComponent from './components/Admin/AreaComponent.vue';
import CouponComponent from './components/Admin/CouponComponent.vue';
import NotificationComponent from './components/Admin/NotificationComponent.vue';
import SettingsComponent from './components/Admin/SettingsComponent.vue';
import CartComponent from './components/CartComponent.vue';
import BackToTopComponent from './components/Shared/BackToTopComponent.vue';
import AdminBackToTopComponent from './components/Shared/AdminBackToTopComponent.vue';
import DiscountBadgeComponent from './components/Shared/DiscountBadgeComponent.vue';
import ContactFormComponent from './components/ContactFormComponent.vue';
import IssueBookingFormComponent from './components/IssueBookingFormComponent.vue';
import SubmitOrderComponent from './components/SubmitOrderComponent.vue';
import ItemCartComponent from './components/ItemCartComponent.vue';
import PrimeVue from 'primevue/config';
import DataTable from 'primevue/datatable';
import Rating from 'primevue/rating';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';
import Toaster from '@meforma/vue-toaster';
import store from './store/store';
import CKEditor from '@ckeditor/ckeditor5-vue';
import MtIconComponent from './components/Shared/MtIconComponent.vue';
import SearchIconComponent from './components/Shared/SearchIconComponent.vue';
import ModalBackButtonComponent from './components/Shared/ModalBackButtonComponent.vue';
import NoContentComponent from './components/Shared/NoContentComponent.vue';
import CartBadgeComponent from './components/CartBadgeComponent.vue';
import CategoryRowComponent from './components/Admin/CategoryRowComponent.vue';
import ReviewFormComponent from './components/ReviewFormComponent.vue';
import ReviewFormEditComponent from './components/ReviewFormEditComponent.vue';
import WarrantyCheckFormComponent from './components/WarrantyCheckFormComponent.vue';

const app = createApp({
  components: {
    AdminLoginComponent,
    CategoryComponent,
    BannerComponent,
    ServiceComponent,
    ItemComponent,
    PaymentMethodComponent,
    CouponComponent,
    NotificationComponent,
    AreaComponent,
    SettingsComponent,
    CartBadgeComponent,

    CartComponent,
    ContactFormComponent,
    IssueBookingFormComponent,
    SubmitOrderComponent,
    ItemCartComponent,

    BackToTopComponent,
    NoContentComponent,
    SearchIconComponent,
    ReviewFormComponent,
    ReviewFormEditComponent,
    WarrantyCheckFormComponent,
    AdminBackToTopComponent
  }
});
app.use(VueTelInput);
app.use(store);
app.use(CKEditor);
app.use(PrimeVue);
app.use(Toaster, {
  position: 'bottom',
  duration: 2000
});
app.component('CategoryRow', CategoryRowComponent);
app.component('DataTable', DataTable);
app.component('Rating', Rating);
app.component('Column', Column);
app.component('Dropdown', Dropdown);
app.component('MtIcon', MtIconComponent);
app.component('SearchIcon', SearchIconComponent);
app.component('ReviewForm', ReviewFormComponent);
app.component('ReviewFormEdit', ReviewFormEditComponent);
app.component('WarrantyCheckForm', WarrantyCheckFormComponent);
app.component('NoContent', NoContentComponent);
app.component('BackBtn', ModalBackButtonComponent);
app.component('DiscountBadge', DiscountBadgeComponent);
app.mount('#app');
