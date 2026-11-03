// Helper functions
const $ = (selector) => document.querySelector(selector);
const show = (el) => el && (el.style.display = 'block');
const hide = (el) => el && (el.style.display = 'none');

// ===== MOBILE MENU =====
const mobileMenu = $('.mobile-header-wrap');
const mobileHeaderBtn = $('.header-mobile-bar');
const mobileHeaderClose = $('.mobile-nav-close');
const mobileNav = $('.mobile-header-nav');
const mobileChangeInfo = $('.mobile-nav-account-info');
const mobileCart = $('.mobile-header-nav-item.mobile-nav-cart')

mobileHeaderBtn?.addEventListener('click', () => mobileMenu?.classList.add('active'));
mobileHeaderClose?.addEventListener('click', (e) => {
  e.preventDefault();
  mobileMenu?.classList.remove('active');
});
mobileMenu?.addEventListener('click', () => mobileMenu?.classList.remove('active'));
mobileNav?.addEventListener('click', (e) => e.stopPropagation());

// ===== MOBILE ACCOUNT DROPDOWN =====
const accountToggle = $('.mobile-nav-account-toggle');
const accountDropdown = $('.mobile-nav-account-dropdown');
accountToggle?.addEventListener('click', () => {
  accountDropdown?.classList.toggle('open');
});

// ===== MODALS =====
const loginModal = $('#loginModal');
const registerModal = $('#registerModal');
const infoModal = $('#infoModal');

const openLoginBtn = $('#main-header .header-account-login');
const openLoginMobile = $('.mobile-nav-signin');
const openRegisterBtn = $('#loginModal .register-link');
const closeLoginBtn = $('#closeLoginModalBtn');
const closeRegisterBtn = $('#closeRegisterModalBtn');
const openInfoBtn = $('#main-header .acc-opt-item-info');
const closeInfoBtn = $('#closeInfoModalBtn');

mobileChangeInfo?.addEventListener('click', () => {
  show(infoModal);
  mobileMenu?.classList.remove('active');
});

openLoginBtn?.addEventListener('click', () => show(loginModal));
openRegisterBtn?.addEventListener('click', () => {
  hide(loginModal);
  show(registerModal);
});

openLoginMobile?.addEventListener('click', () => {
    show(loginModal);
    mobileMenu?.classList.remove('active');
});

openInfoBtn?.addEventListener('click', () => {
  show(infoModal);
});

closeInfoBtn?.addEventListener('click', () => {
  hide(infoModal);
});

const cartModal = document.getElementById('cartModal');
const cartIcon = document.querySelector('#main-header .header-cart-icon');
const closeCartModalBtn = document.getElementById('closeCartModalBtn');
const cartItemsContainer = document.getElementById('cartItemsContainer');
const cartTotal = document.getElementById('cartTotal');

// Mở modal
cartIcon?.addEventListener('click', () => {
  show(cartModal);
  loadCartItems();
});

mobileCart?.addEventListener('click', () => {
  show(cartModal);
  loadCartItems();
  mobileMenu?.classList.remove('active');
});

// Đóng modal
closeCartModalBtn?.addEventListener('click', () => hide(cartModal));


closeLoginBtn?.addEventListener('click', () => hide(loginModal));
closeRegisterBtn?.addEventListener('click', () => hide(registerModal));

// Close modals when clicking outside
window.addEventListener('click', (e) => {
  if (e.target === loginModal) hide(loginModal);
  if (e.target === registerModal) hide(registerModal);
  if (e.target === infoModal) hide(infoModal);
  if (e.target === cartModal) hide(cartModal);
});

const backToLoginBtn = $('#registerModal .login-link');
backToLoginBtn?.addEventListener('click', () => {
  hide(registerModal);
  show(loginModal);
});
