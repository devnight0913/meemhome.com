topbar.config({
  barThickness: 6,
  barColors: {
    0: 'rgba(255, 0, 0)',
    '.25': 'rgba(255, 0, 0)',
    '.50': 'rgba(255, 0, 0)',
    '.75': 'rgba(255, 0, 0)',
    '1.0': 'rgba(255, 0, 0)'
  }
});

// const favicon32x32 = document.getElementById("favicon32x32");
// const favicon16x16 = document.getElementById("favicon16x16");
// const isDark = window.matchMedia("(prefers-color-scheme: dark)");

// const changeFavicon = () => {
//     favicon32x32.href = isDark.matches
//         ? "/favicon-32x32-light.png"
//         : "/favicon-32x32.png";
//     favicon16x16.href = isDark.matches
//         ? "/favicon-16x16-light.png"
//         : "/favicon-16x16.png";
// };
// changeFavicon();
// setInterval(changeFavicon, 1000);

document.addEventListener('DOMContentLoaded', function () {
  var isBigScreen = window.innerWidth > 768;
  var infoNavbar = document.getElementById('infoNavbar');
  var mainNavbar = document.getElementById('mainNavbar');
  var navbarBrandImage = document.getElementById('navbarBrandImage');
  // if (navbarBrandImage) {
  //   navbarBrandImage.addEventListener('mouseover', function (e) {
  //     navbarBrandImage.src = '/images/webp/logo.webp';
  //   });
  //   navbarBrandImage.addEventListener('mouseout', function (e) {
  //     navbarBrandImage.src = '/images/webp/logo.webp';
  //   });
  // }

  document.addEventListener('scroll', function (e) {
    var isScrolled = window.scrollY >= 50;
    if (mainNavbar) {
      if (isScrolled) {
        mainNavbar.classList.add('sticky-top');
      } else {
        mainNavbar.classList.remove('sticky-top');
      }
    }
  });

  if (!isBigScreen) {
    infoNavbar.remove();
  }
  var formControlList = [].slice.call(document.querySelectorAll('.form-control'));
  formControlList.map(function (formControlElement) {
    formControlElement.addEventListener('input', function (event) {
      this.classList.remove('is-invalid');
    });
  });

  var forms = document.getElementsByTagName('form');
  for (const form of forms) {
    form.addEventListener('submit', function (event) {
      var formBtn = this.querySelector('button[type="submit"]');
      formBtn.disabled = true;
      topbar.show();
    });
  }

  var searchModal = document.getElementById('searchModal');
  if (searchModal) {
    var searchInput = document.getElementById('search_query');
    searchModal.addEventListener('shown.bs.modal', function (event) {
      searchInput.focus();
    });
  }

  var formSelectList = [].slice.call(document.querySelectorAll('.form-select'));
  formSelectList.map(function (formSelectElement) {
    formSelectElement.addEventListener('change', function (event) {
      this.classList.remove('is-invalid');
    });
  });

  var lazyLoadInstance = new LazyLoad({
    elements_selector: '.lazy'
  });
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  //phone number input
  var keys = '0123456789+ ';
  var checkInputTel = function (e) {
    var key = typeof e.which == 'number' ? e.which : e.keyCode;
    var start = this.selectionStart,
      end = this.selectionEnd;
    var filtered = this.value.split('').filter(filterInput);
    this.value = filtered.join('');
    var move = filterInput(String.fromCharCode(key)) || key == 0 || key == 8 ? 0 : 1;
    this.setSelectionRange(start - move, end - move);
  };
  var filterInput = function (val) {
    return keys.indexOf(val) > -1;
  };

  // var phoneInputList = [].slice.call(document.querySelectorAll('.input-phone'));
  // phoneInputList.map(function (phoneInputElement) {
  //   // phoneInputElement.addEventListener('input', checkInputTel);
  //   var iti = intlTelInput(phoneInputElement, {
  //     initialCountry: 'lb',
  //     preferredCountries: ['lb', 'fr', 'us', 'gb'],
  //     separateDialCode: true
  //   });
  // });

  // var inputUserContactPhone = document.querySelector('.input-contact-phone');
  // if (inputUserContactPhone) {
  //   window.intlTelInput(inputUserContactPhone, {
  //     initialCountry: 'lb',
  //     preferredCountries: ['lb', 'fr', 'us', 'gb'],
  //     separateDialCode: true,
  //     hiddenInput: 'full_contact_phone',
  //     utilsScript: "/js/util-script.js"
  //   });
  // }

  const pDatatableWrapper = document.querySelector('.p-datatable-wrapper');
  if (pDatatableWrapper) {
    pDatatableWrapper.addEventListener('show.bs.dropdown', event => {
      pDatatableWrapper.style.overflowX = 'inherit';
    });
    pDatatableWrapper.addEventListener('hide.bs.dropdown', event => {
      pDatatableWrapper.style.overflowX = 'auto';
    });
  }
});
