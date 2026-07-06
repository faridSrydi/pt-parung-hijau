/* ==========================================================================
   ARTISAN GARDEN CARE - APPLICATION LOGIC WITH DESIGNER REDESIGN
   ========================================================================== */

/// 1. PRODUCT DATABASE
const PRODUCTS = window.DB_PRODUCTS || [];


// Helper: Find product by ID supporting variants
function findProductById(productId) {
  for (const prod of PRODUCTS) {
    if (prod.id === productId) {
      return prod;
    }
    if (prod.variants) {
      const variant = prod.variants.find(v => v.id === productId);
      if (variant) {
        return {
          id: variant.id,
          name: `${prod.name} - ${variant.name}`,
          price: variant.price,
          priceStr: variant.priceStr,
          category: prod.category,
          categoryLabel: prod.categoryLabel,
          image: prod.image,
          shortDesc: prod.shortDesc,
          desc: prod.desc,
          specs: prod.specs
        };
      }
    }
  }
  return null;
}

// Helper: Format to IDR Currency
function formatIDR(number) {
  return 'Rp ' + number.toLocaleString('id-ID');
}

// Helper: Resolve asset URL with BASE_URL
function getAssetUrl(path) {
  const base = window.BASE_URL || '';
  if (!path) return '';
  if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
    return path;
  }
  // Check if it's a page link
  const pageMatches = ['login', 'dashboard', 'produk-kami', 'tentang-kami', 'kontak'];
  if (pageMatches.includes(path)) {
    return base ? base + path : path + '.html';
  }
  return base + path;
}

// Helper: Navigate to URL handling static vs CodeIgniter routing
function goToUrl(path) {
  const base = window.BASE_URL || '';
  if (!base) {
    if (path === 'logout') {
      window.location.href = 'index.html';
    } else {
      window.location.href = path;
    }
    return;
  }
  if (path === 'index.html') {
    window.location.href = base;
  } else if (path === 'login.html') {
    window.location.href = base + 'login';
  } else if (path === 'dashboard.html') {
    window.location.href = base + 'dashboard';
  } else if (path === 'index.html#/checkout') {
    window.location.href = base + 'checkout';
  } else if (path === 'logout') {
    window.location.href = base + 'logout';
  } else {
    window.location.href = base + path.replace('.html', '');
  }
}

// ==========================================================================
// AUTHENTICATION MANAGER (AuthManager)
// ==========================================================================
const AuthManager = {
  init() {
    let users = JSON.parse(localStorage.getItem('registeredUsers')) || [];
    const hasDemo = users.some(u => u.email === 'demo@parunghijau.com');
    if (!hasDemo) {
      users.push({
        name: 'Akun Demo Parung',
        email: 'demo@parunghijau.com',
        password: 'password123',
        addresses: [
          {
            id: 'addr-default-demo',
            name: 'Penerima Demo',
            phone: '08123456789',
            addressLine: 'AKR Tower Lantai 5, Jl. Panjang No.5, Kebon Jeruk, Jakarta Barat',
            isDefault: true
          }
        ]
      });
      localStorage.setItem('registeredUsers', JSON.stringify(users));
    }
  },
  getUsers() {
    return JSON.parse(localStorage.getItem('registeredUsers')) || [];
  },
  getUser() {
    if (window.USER_SESSION !== undefined) {
      if (window.USER_SESSION) {
        localStorage.setItem('activeUser', JSON.stringify(window.USER_SESSION));
      } else {
        localStorage.removeItem('activeUser');
      }
    }
    return JSON.parse(localStorage.getItem('activeUser')) || null;
  },
  isLoggedIn() {
    return this.getUser() !== null;
  },
  login(email, password) {
    this.init();
    const users = this.getUsers();
    const matched = users.find(u => u.email === email && u.password === password);
    if (matched) {
      localStorage.setItem('activeUser', JSON.stringify({ name: matched.name, email: matched.email }));
      return matched;
    }
    throw new Error('Email atau kata sandi salah.');
  },
  register(name, email, password) {
    this.init();
    const users = this.getUsers();
    const exists = users.some(u => u.email === email);
    if (exists) {
      throw new Error('Email sudah terdaftar.');
    }
    const newUser = { name, email, password, addresses: [] };
    users.push(newUser);
    localStorage.setItem('registeredUsers', JSON.stringify(users));
    localStorage.setItem('activeUser', JSON.stringify({ name: newUser.name, email: newUser.email }));
    return newUser;
  },
  logout() {
    localStorage.removeItem('activeUser');
    goToUrl('logout');
  },
  getAddresses() {
    const user = this.getUser();
    if (!user) return [];
    const users = this.getUsers();
    const matched = users.find(u => u.email === user.email);
    return matched ? (matched.addresses || []) : [];
  },
  saveAddress(addr) {
    const user = this.getUser();
    if (!user) return;
    let users = this.getUsers();
    const userIdx = users.findIndex(u => u.email === user.email);
    if (userIdx === -1) return;
    
    if (!users[userIdx].addresses) {
      users[userIdx].addresses = [];
    }
    
    // If setting as default, clear others
    if (addr.isDefault) {
      users[userIdx].addresses.forEach(a => a.isDefault = false);
    }
    
    if (addr.id) {
      // Edit existing
      const addrIdx = users[userIdx].addresses.findIndex(a => a.id === addr.id);
      if (addrIdx !== -1) {
        users[userIdx].addresses[addrIdx] = addr;
      }
    } else {
      // Create new
      addr.id = 'addr-' + Date.now();
      // If first address, make default
      if (users[userIdx].addresses.length === 0) {
        addr.isDefault = true;
      }
      users[userIdx].addresses.push(addr);
    }
    
    localStorage.setItem('registeredUsers', JSON.stringify(users));
  },
  deleteAddress(addrId) {
    const user = this.getUser();
    if (!user) return;
    let users = this.getUsers();
    const userIdx = users.findIndex(u => u.email === user.email);
    if (userIdx === -1) return;
    
    if (users[userIdx].addresses) {
      users[userIdx].addresses = users[userIdx].addresses.filter(a => a.id !== addrId);
      // If default was deleted, make first address default
      if (users[userIdx].addresses.length > 0 && !users[userIdx].addresses.some(a => a.isDefault)) {
        users[userIdx].addresses[0].isDefault = true;
      }
      localStorage.setItem('registeredUsers', JSON.stringify(users));
    }
  },
  updateProfile(newName, newPassword) {
    const user = this.getUser();
    if (!user) return;
    let users = this.getUsers();
    const userIdx = users.findIndex(u => u.email === user.email);
    if (userIdx === -1) return;
    
    users[userIdx].name = newName;
    if (newPassword) {
      users[userIdx].password = newPassword;
    }
    
    localStorage.setItem('registeredUsers', JSON.stringify(users));
    localStorage.setItem('activeUser', JSON.stringify({ name: newName, email: user.email }));
  }
};
AuthManager.init();

// ==========================================================================
// SHOPPING CART MANAGER (CartManager)
// ==========================================================================
const CartManager = {
  getCart() {
    return JSON.parse(localStorage.getItem('shoppingCart')) || [];
  },
  saveCart(cart) {
    localStorage.setItem('shoppingCart', JSON.stringify(cart));
    this.updateHeaderBadge();
  },
  addToCart(productId, qty = 1) {
    let cart = this.getCart();
    const matched = cart.find(item => item.productId === productId);
    if (matched) {
      matched.qty += qty;
    } else {
      cart.push({ productId, qty });
    }
    this.saveCart(cart);
    this.renderCartDrawer();
  },
  updateQty(productId, qty) {
    let cart = this.getCart();
    const idx = cart.findIndex(item => item.productId === productId);
    if (idx !== -1) {
      if (qty <= 0) {
        cart.splice(idx, 1);
      } else {
        cart[idx].qty = qty;
      }
    }
    this.saveCart(cart);
    this.renderCartDrawer();
  },
  removeFromCart(productId) {
    let cart = this.getCart();
    cart = cart.filter(item => item.productId !== productId);
    this.saveCart(cart);
    this.renderCartDrawer();
  },
  getCartCount() {
    return this.getCart().reduce((sum, item) => sum + item.qty, 0);
  },
  getCartTotal() {
    return this.getCart().reduce((sum, item) => {
      const prod = findProductById(item.productId);
      return sum + (prod ? prod.price * item.qty : 0);
    }, 0);
  },
  clearCart() {
    localStorage.removeItem('shoppingCart');
    this.updateHeaderBadge();
    this.renderCartDrawer();
  },
  updateHeaderBadge() {
    const badge = document.getElementById('cart-badge-count');
    if (badge) {
      const count = this.getCartCount();
      if (count > 0) {
        badge.innerText = count;
        badge.style.display = 'flex';
      } else {
        badge.style.display = 'none';
      }
    }
  },
  renderCartDrawer() {
    const container = document.getElementById('cart-drawer-items');
    if (!container) return;

    const cart = this.getCart();
    const totalEl = document.getElementById('cart-drawer-total');
    const checkoutBtn = document.getElementById('btn-cart-checkout');

    if (cart.length === 0) {
      container.innerHTML = `
        <div class="cart-empty">
          <svg viewBox="0 0 24 24">
            <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18M7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7A2,2 0 0,1 5,15C5,14.65 5.07,14.31 5.24,14L6.6,11.59L3,4H1V2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.64,11.36C17.29,11.97 16.64,12.37 15.9,12.37H8.1L7.2,14.63Z"/>
          </svg>
          <p>Keranjang belanja Anda masih kosong.</p>
        </div>
      `;
      if (totalEl) totalEl.innerText = 'Rp 0';
      if (checkoutBtn) checkoutBtn.disabled = true;
      return;
    }

    container.innerHTML = cart.map(item => {
      const prod = findProductById(item.productId);
      if (!prod) return '';
      return `
        <div class="cart-item">
          <img src="${getAssetUrl(prod.image)}" alt="${prod.name}" class="cart-item-img">
          <div class="cart-item-info">
            <div>
              <h4 class="cart-item-title">${prod.name}</h4>
              <div class="cart-item-price">${prod.priceStr}</div>
            </div>
            <div class="cart-item-qty">
              <button class="qty-btn" onclick="CartManager.updateQty('${prod.id}', ${item.qty - 1})">-</button>
              <span class="qty-val">${item.qty}</span>
              <button class="qty-btn" onclick="CartManager.updateQty('${prod.id}', ${item.qty + 1})">+</button>
            </div>
          </div>
          <button class="cart-item-remove" onclick="CartManager.removeFromCart('${prod.id}')" aria-label="Hapus Item">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor;"><path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"/></svg>
          </button>
        </div>
      `;
    }).join('');

    const total = this.getCartTotal();
    if (totalEl) totalEl.innerText = formatIDR(total);
    if (checkoutBtn) checkoutBtn.disabled = false;
  }
};

// Global Checkout Variables
let selectedPaymentMethod = 'auto'; // 'auto' or 'manual'

window.selectPaymentMethod = function (method) {
  selectedPaymentMethod = method;
  const autoCard = document.getElementById('pay-opt-auto');
  const manualCard = document.getElementById('pay-opt-manual');

  if (method === 'auto') {
    autoCard.classList.add('selected');
    manualCard.classList.remove('selected');
  } else {
    manualCard.classList.add('selected');
    autoCard.classList.remove('selected');
  }
};

window.handleCheckout = function () {
  const cartItems = CartManager.getCart();
  if (cartItems.length === 0) return;

  const user = AuthManager.getUser();
  if (!user) {
    goToUrl('login.html');
    return;
  }

  // Check stock availability via backend API
  fetch(window.BASE_URL + 'checkout/cek-stok', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({ items: cartItems })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'insufficient') {
      let listHtml = '';
      data.items.forEach(item => {
        listHtml += `
          <li style="margin-bottom: 10px; font-weight: 500; color: #475569; display: flex; align-items: flex-start; gap: 8px;">
            <span style="display:inline-block; width: 6px; height: 6px; border-radius: 50%; background: #ef4444; margin-top: 6px; flex-shrink: 0;"></span>
            <div>
              <span style="color: #1e293b; font-weight: 600; font-size: 0.9rem; display: block; line-height: 1.3;">${item.name}</span>
              <span style="font-size: 0.8rem; color: #ef4444; font-weight: 600;">(Hanya tersedia: ${item.available} unit)</span>
            </div>
          </li>
        `;
        
        // Update Cart: if available <= 0, remove. Otherwise, reduce quantity.
        if (item.available <= 0) {
          CartManager.removeFromCart(item.productId);
        } else {
          CartManager.updateQty(item.productId, item.available);
        }
      });
      
      const modalId = 'stock-warning-modal';
      const existing = document.getElementById(modalId);
      if (existing) existing.remove();

      const modalOverlay = document.createElement('div');
      modalOverlay.id = modalId;
      modalOverlay.style.position = 'fixed';
      modalOverlay.style.top = '0';
      modalOverlay.style.left = '0';
      modalOverlay.style.width = '100%';
      modalOverlay.style.height = '100%';
      modalOverlay.style.backgroundColor = 'rgba(15, 23, 42, 0.6)';
      modalOverlay.style.backdropFilter = 'blur(6px)';
      modalOverlay.style.display = 'flex';
      modalOverlay.style.alignItems = 'center';
      modalOverlay.style.justifyContent = 'center';
      modalOverlay.style.zIndex = '9999999';
      modalOverlay.style.opacity = '0';
      modalOverlay.style.transition = 'opacity 0.3s ease';

      modalOverlay.innerHTML = `
        <div style="background: #ffffff; border-radius: 16px; width: 90%; max-width: 440px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); overflow: hidden; transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); border: 1px solid rgba(182, 138, 88, 0.2);">
          <div style="padding: 24px 24px 20px 24px; text-align: center;">
            <div style="width: 56px; height: 56px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto;">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 28px; height: 28px; fill: #ef4444;">
                <path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M13 17H11V15H13V17M13 13H11V7H13V13Z"/>
              </svg>
            </div>
            <h3 style="font-family: var(--font-serif); font-size: 1.25rem; color: #1e293b; margin: 0 0 8px 0; font-weight: 700;">Stok Tidak Mencukupi</h3>
            <p style="color: #64748b; font-size: 0.88rem; margin: 0 0 20px 0; line-height: 1.5;">Beberapa produk di keranjang Anda habis atau melebihi kapasitas stok saat ini:</p>
            
            <ul style="list-style: none; padding: 0; margin: 0 0 20px 0; text-align: left; background: #f8fafc; border-radius: 12px; padding: 16px; border: 1px solid #f1f5f9; max-height: 180px; overflow-y: auto;">
              ${listHtml}
            </ul>
            
            <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 24px 0; font-style: italic; line-height: 1.4;">Keranjang Anda telah diperbarui secara otomatis sesuai stok yang tersedia.</p>
            
            <button id="close-stock-warn-btn" style="width: 100%; padding: 12px; background: #b68a58; color: #ffffff; border: none; border-radius: 30px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 6px -1px rgba(182, 138, 88, 0.2);">Ok, Mengerti</button>
          </div>
        </div>
      `;

      document.body.appendChild(modalOverlay);

      setTimeout(() => {
        modalOverlay.style.opacity = '1';
        modalOverlay.querySelector('div').style.transform = 'scale(1)';
      }, 10);

      const closeBtn = modalOverlay.querySelector('#close-stock-warn-btn');
      closeBtn.addEventListener('click', () => {
        modalOverlay.style.opacity = '0';
        modalOverlay.querySelector('div').style.transform = 'scale(0.9)';
        setTimeout(() => {
          modalOverlay.remove();
        }, 300);
      });
      showToast('Stok tidak mencukupi, keranjang disesuaikan!', 'error');
    } else if (data.status === 'ok') {
      // Close Cart Drawer
      const cartOverlay = document.getElementById('cart-drawer-overlay');
      if (cartOverlay) {
        cartOverlay.classList.remove('open');
      }

      // Redirect to SPA checkout route on index.html
      goToUrl('index.html#/checkout');
    } else {
      showToast('Gagal memverifikasi stok produk.', 'error');
    }
  })
  .catch(err => {
    console.error(err);
    showToast('Terjadi kesalahan saat memverifikasi stok.', 'error');
  });
};

// Global Checkout Variables for checkout page
let selectedCheckoutPaymentMethod = 'auto';

window.switchCheckoutPaymentMethod = function (method) {
  selectedCheckoutPaymentMethod = method;
  const autoCard = document.getElementById('checkout-pay-opt-auto');
  const manualCard = document.getElementById('checkout-pay-opt-manual');
  if (!autoCard || !manualCard) return;

  if (method === 'auto') {
    autoCard.classList.add('selected');
    manualCard.classList.remove('selected');
  } else {
    manualCard.classList.add('selected');
    autoCard.classList.remove('selected');
  }
};

window.populateCheckoutAddress = function (addressId) {
  if (!addressId) {
    document.getElementById('checkout-name').value = '';
    document.getElementById('checkout-phone').value = '';
    document.getElementById('checkout-address').value = '';
    return;
  }
  const addresses = AuthManager.getAddresses();
  const matched = addresses.find(a => a.id === addressId);
  if (matched) {
    document.getElementById('checkout-name').value = matched.name;
    document.getElementById('checkout-phone').value = matched.phone;
    document.getElementById('checkout-address').value = matched.addressLine;
  }
};

window.changeCheckoutQty = function (productId, delta) {
  const input = document.getElementById(`qty-input-${productId}`);
  if (input) {
    let currentVal = parseInt(input.value) || 1;
    let newVal = currentVal + delta;
    if (newVal < 1) newVal = 1;
    input.value = newVal;
    window.handleCheckoutQtyChange(productId, newVal);
  }
};

window.handleCheckoutQtyChange = function (productId, value) {
  let qty = parseInt(value);
  if (isNaN(qty) || qty < 1) qty = 1;
  CartManager.updateQty(productId, qty);
  
  // Update subtotal for this item in DOM
  const itemRow = document.querySelector(`.checkout-item[data-product-id="${productId}"]`);
  const prod = findProductById(productId);
  if (itemRow && prod) {
    const subtotalVal = prod.price * qty;
    const subtotalStr = 'Rp ' + subtotalVal.toLocaleString('id-ID');
    const subtotalEl = itemRow.querySelector('.checkout-item-subtotal');
    if (subtotalEl) {
      subtotalEl.innerText = subtotalStr;
    }
  }
  
  // Update overall totals
  window.updateCheckoutSummaryUI();
};

window.updateCheckoutSummaryUI = function () {
  const cart = CartManager.getCart();
  const totalLabel = document.getElementById('checkout-total-label');
  const qtyTotalEl = document.getElementById('checkout-qty-total');
  const submitBtn = document.querySelector('#checkout-order-form button[type="submit"]');
  
  if (!totalLabel) return;
  
  const total = CartManager.getCartTotal();
  const totalStr = 'Rp ' + total.toLocaleString('id-ID');
  
  totalLabel.innerText = totalStr;
  if (qtyTotalEl) {
    qtyTotalEl.innerText = `${cart.reduce((sum, item) => sum + item.qty, 0)} Pcs`;
  }
  if (submitBtn) {
    submitBtn.innerText = `Buat Pesanan (${totalStr})`;
  }
};

window.submitCheckoutOrder = async function (e) {
  e.preventDefault();
  
  const cart = CartManager.getCart();
  if (cart.length === 0) return;

  const recipientName = document.getElementById('checkout-name').value;
  const recipientPhone = document.getElementById('checkout-phone').value;
  const shippingAddress = document.getElementById('checkout-address').value;
  const notes = document.getElementById('checkout-notes').value || '';
  const saveChecked = document.getElementById('checkout-save-address-checkbox').checked;

  if (!recipientName || !recipientPhone || !shippingAddress) {
    alert('Mohon isi seluruh data penerima dan alamat pengiriman wajib.');
    return;
  }

  // Build AJAX payload
  const payload = {
    recipient_name: recipientName,
    recipient_phone: recipientPhone,
    shipping_address: shippingAddress,
    catatan_pengiriman: notes,
    metode_pembayaran: selectedCheckoutPaymentMethod,
    save_address: saveChecked ? 1 : 0,
    items: cart
  };

  try {
    const url = window.BASE_URL ? window.BASE_URL + 'checkout/proses' : '/checkout/proses';
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(payload)
    });

    const result = await response.json();

    if (result.status === 'success') {
      if (selectedCheckoutPaymentMethod === 'auto') {
        // Show pg simulator overlay
        const pgOverlay = document.getElementById('payment-gateway-overlay');
        const procEl = document.getElementById('pg-content-processing');
        const succEl = document.getElementById('pg-content-success');
        
        if (pgOverlay && procEl && succEl) {
          procEl.style.display = 'block';
          succEl.style.display = 'none';
          pgOverlay.classList.add('open');

          setTimeout(() => {
            procEl.style.display = 'none';
            succEl.style.display = 'block';

            CartManager.clearCart();

            setTimeout(() => {
              pgOverlay.classList.remove('open');
              window.location.href = result.redirect;
            }, 1500);
          }, 2000);
        } else {
          CartManager.clearCart();
          window.location.href = result.redirect;
        }
      } else {
        CartManager.clearCart();
        window.location.href = result.redirect;
      }
    } else {
      alert('Error: ' + result.message);
    }
  } catch (err) {
    console.error(err);
    alert('Gagal memproses pesanan ke server. Hubungi admin.');
  }
};

// Active State
let currentProductFilter = 'semua';

// 5. COMPONENT RENDERERS & EVENT HANDLERS

// HOME: Render Top Featured Products
function renderHomeFeaturedProducts() {
  const container = document.getElementById('home-featured-products');
  if (!container) return;

  // Showcase top 3 products
  const featured = PRODUCTS.slice(0, 3);
  container.innerHTML = featured.map((prod, index) => `
    <div class="product-card reveal reveal-slide-up delay-${index + 1}">
      <div class="product-image-container">
        <span class="product-tag">${prod.categoryLabel}</span>
        <img src="${getAssetUrl(prod.image)}" alt="${prod.name}">
      </div>
      <div class="product-info">
        <div>
          <h3 class="product-title">${prod.name}</h3>
          <p style="font-size: 0.95rem; margin-bottom: 12px; line-height: 1.4;">${prod.shortDesc}</p>
        </div>
        <div>
          <div class="product-price">${prod.variants ? 'Mulai dari ' + prod.variants.find(v => v.id.endsWith('-b')).priceStr : prod.priceStr}</div>
          <div class="product-actions">
            <button class="product-btn-view" onclick="openProductQuickview('${prod.id}')">Lihat Detail</button>
            <button class="btn btn-terracotta" style="padding: 10px 18px; font-size: 0.85rem; border-radius: 30px;" onclick="handleInstantBuy('${prod.name}')">Beli</button>
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

function animateHeroDescWordByWord() {
  const text = "Temukan solusi inovatif kami untuk peternakan unggul dan pengelolaan limbah yang berkelanjutan";
  const el = document.getElementById('hero-animated-desc');
  if (!el) return;

  const words = text.split(' ');
  el.innerHTML = words.map((word, idx) => `
    <span class="word-span" style="animation-delay: ${0.8 + idx * 0.1}s;">${word}</span>
  `).join('');
}

// CATALOG: Render product list by filter
function renderCatalogProducts() {
  const container = document.getElementById('products-catalog-grid');
  if (!container) return;

  const categoryAttr = container.getAttribute('data-category');

  // Filter list
  const filtered = categoryAttr
    ? PRODUCTS.filter(p => p.category === categoryAttr)
    : (currentProductFilter === 'semua'
        ? PRODUCTS
        : PRODUCTS.filter(p => p.category === currentProductFilter));

  if (filtered.length === 0) {
    container.innerHTML = `<p style="grid-column: 1/-1; text-align: center; padding: 40px; font-family: var(--font-serif); font-size: 1.2rem;">Produk tidak ditemukan.</p>`;
    return;
  }

  container.innerHTML = filtered.map((prod, idx) => `
    <div class="product-card reveal reveal-slide-up delay-${(idx % 4) + 1}">
      <div class="product-image-container">
        <span class="product-tag">${prod.categoryLabel}</span>
        <img src="${getAssetUrl(prod.image)}" alt="${prod.name}">
      </div>
      <div class="product-info">
        <div>
          <h3 class="product-title">${prod.name}</h3>
          <p class="product-desc-short">${prod.shortDesc}</p>
        </div>
        <div>
          <div class="product-price">${prod.variants ? 'Mulai dari ' + prod.variants.find(v => v.id.endsWith('-b')).priceStr : prod.priceStr}</div>
          <div class="product-actions">
            <button class="product-btn-view" onclick="openProductQuickview('${prod.id}')">Detail</button>
            <button class="btn btn-terracotta btn-buy" onclick="handleInstantBuy('${prod.name}')">Beli</button>
          </div>
        </div>
      </div>
    </div>
  `).join('');

  // Re-initialize Scroll Reveal observer for newly generated cards
  initScrollReveal();
}
window.renderCatalogProducts = renderCatalogProducts;

// CATALOG: Initialize Filter buttons listener
function initCatalogFilters() {
  const tabsContainer = document.querySelector('.filter-tabs');
  if (!tabsContainer) return;

  tabsContainer.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      // Remove active states
      tabsContainer.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));

      // Set active selection
      const filter = e.target.getAttribute('data-filter');
      currentProductFilter = filter;
      e.target.classList.add('active');

      // Re-render
      renderCatalogProducts();
    });
  });
}

// GLOBAL: Quickview Modal popups handler
window.productSliderInterval = null;

window.openProductQuickview = function (productId) {
  const product = PRODUCTS.find(p => p.id === productId);
  if (!product) return;

  // Clear existing slider interval
  if (window.productSliderInterval) {
    clearInterval(window.productSliderInterval);
    window.productSliderInterval = null;
  }

  const modal = document.getElementById('product-modal');
  const gridContent = document.getElementById('modal-grid-content');
  if (!modal || !gridContent) return;

  // Generate specification metadata list
  const specList = Object.entries(product.specs).map(([key, val]) => `
    <li class="product-meta-item">
      <span class="product-meta-label">${key}</span>
      <span class="product-meta-val">: ${val}</span>
    </li>
  `).join('');

  // Handle variants rendering
  let priceDisplay = product.priceStr;
  let variantHtml = '';
  if (product.variants) {
    priceDisplay = product.variants[0].priceStr;
    variantHtml = `
      <h3 class="modal-desc-heading">Pilih Kualitas / Grade</h3>
      <div class="variant-selector" style="display: flex; gap: 15px; margin-bottom: 25px; flex-wrap: wrap;">
        ${product.variants.map((v, idx) => `
          <label style="border: 2px solid ${idx === 0 ? 'var(--accent)' : 'rgba(182, 138, 88, 0.25)'}; padding: 8px 16px; border-radius: 30px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.9rem; font-weight: 600; color: var(--primary); background: ${idx === 0 ? 'rgba(182, 138, 88, 0.05)' : 'transparent'}; transition: all 0.2s;" class="variant-label ${idx === 0 ? 'active-variant' : ''}">
            <input type="radio" name="product-variant" value="${v.id}" data-price="${v.priceStr}" ${idx === 0 ? 'checked' : ''} onchange="updateQuickviewPrice(this)" style="accent-color: var(--accent); cursor: pointer;">
            ${v.name}
          </label>
        `).join('')}
      </div>
    `;
  }

  let imagePanelContent = '';
  
  if (product.gallery && product.gallery.length > 0) {
    const allImages = [product.image, ...product.gallery];
    const sliderImagesHtml = allImages.map((img, idx) => `
      <img src="${getAssetUrl(img)}" alt="${product.name}" class="product-slider-img" style="display: ${idx === 0 ? 'block' : 'none'}; width: 100%; height: 100%; object-fit: cover;" data-idx="${idx}">
    `).join('');
    
    const thumbnailsHtml = allImages.map((img, idx) => `
      <div class="product-thumb" data-idx="${idx}" style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; cursor: pointer; border: 2px solid ${idx === 0 ? 'var(--accent)' : 'transparent'}; flex-shrink: 0;" onclick="changeProductModalImage(this, ${idx})">
        <img src="${getAssetUrl(img)}" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
    `).join('');
    
    imagePanelContent = `
      <div class="modal-image-wrapper-inner" id="modal-product-slider" style="position: relative; height: 350px; overflow: hidden; border-radius: 20px;">
        ${sliderImagesHtml}
      </div>
      <div class="modal-gallery-thumbs" style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap; justify-content: center; width: 100%;">
        ${thumbnailsHtml}
      </div>
    `;
  } else {
    imagePanelContent = `
      <div class="modal-image-wrapper-inner">
        <img src="${getAssetUrl(product.image)}" alt="${product.name}">
      </div>
    `;
  }

  gridContent.innerHTML = `
    <div class="modal-image-panel">
      ${imagePanelContent}
    </div>
    <div class="modal-details-panel">
      <span class="designer-badge">${product.categoryLabel}</span>
      <h2 class="modal-title">${product.name}</h2>
      <div class="modal-price">${priceDisplay}</div>
      
      ${variantHtml}
      
      <h3 class="modal-desc-heading">Deskripsi Produk</h3>
      <p class="modal-desc">${product.desc}</p>
      
      <h3 class="modal-desc-heading">Spesifikasi Detail</h3>
      <ul class="product-meta-list">
        ${specList}
      </ul>
      
      <button onclick="handleModalAddToCart('${product.id}')" 
         class="btn btn-terracotta" 
         style="width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; font-size: 1rem; cursor: pointer; padding: 12px 18px;">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: white;"><path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18M7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7A2,2 0 0,1 5,15C5,14.65 5.07,14.31 5.24,14L6.6,11.59L3,4H1V2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.64,11.36C17.29,11.97 16.64,12.37 15.9,12.37H8.1L7.2,14.63Z"/></svg>
         Tambahkan ke Keranjang
      </button>
    </div>
  `;

  // Open modal animation
  modal.classList.add('open');

  // Start auto-slider if gallery exists
  if (product.gallery && product.gallery.length > 0) {
    const totalImages = product.gallery.length + 1;
    let currentIdx = 0;
    window.productSliderInterval = setInterval(() => {
      currentIdx = (currentIdx + 1) % totalImages;
      const thumb = document.querySelector(`.modal-gallery-thumbs .product-thumb[data-idx="${currentIdx}"]`);
      if (thumb) {
        window.changeProductModalImage(thumb, currentIdx, true);
      }
    }, 3000); // 3 seconds interval
  }
};

// Helper to update dynamic price in Quickview modal
window.updateQuickviewPrice = function (radio) {
  const priceEl = document.querySelector('.modal-price');
  if (priceEl) {
    priceEl.textContent = radio.getAttribute('data-price');
  }
  // Reset and highlight active variant label style
  document.querySelectorAll('.variant-label').forEach(label => {
    label.style.borderColor = 'rgba(182, 138, 88, 0.25)';
    label.style.backgroundColor = 'transparent';
    label.classList.remove('active-variant');
  });
  const activeLabel = radio.closest('.variant-label');
  if (activeLabel) {
    activeLabel.style.borderColor = 'var(--accent)';
    activeLabel.style.backgroundColor = 'rgba(182, 138, 88, 0.05)';
    activeLabel.classList.add('active-variant');
  }
};

// GLOBAL: Quickview close handler
function closeQuickviewModal() {
  const modal = document.getElementById('product-modal');
  if (modal) modal.classList.remove('open');
  if (window.productSliderInterval) {
    clearInterval(window.productSliderInterval);
    window.productSliderInterval = null;
  }
}

window.changeProductModalImage = function(thumbElement, idx, isAuto = false) {
  // Update main images
  const sliderImages = document.querySelectorAll('#modal-product-slider .product-slider-img');
  sliderImages.forEach(img => {
    img.style.display = parseInt(img.dataset.idx) === idx ? 'block' : 'none';
  });
  
  // Update thumb borders
  const thumbs = document.querySelectorAll('.modal-gallery-thumbs .product-thumb');
  thumbs.forEach(th => {
    th.style.borderColor = 'transparent';
  });
  thumbElement.style.borderColor = 'var(--accent)';

  // Reset auto-slide timer if clicked manually
  if (!isAuto && window.productSliderInterval) {
    clearInterval(window.productSliderInterval);
    const totalImages = sliderImages.length;
    let currentIdx = idx;
    window.productSliderInterval = setInterval(() => {
      currentIdx = (currentIdx + 1) % totalImages;
      const thumb = document.querySelector(`.modal-gallery-thumbs .product-thumb[data-idx="${currentIdx}"]`);
      if (thumb) {
        window.changeProductModalImage(thumb, currentIdx, true);
      }
    }, 3000);
  }
};

window.handleModalAddToCart = function (productId) {
  closeQuickviewModal();
  
  let finalProductId = productId;
  const selectedVariantInput = document.querySelector('input[name="product-variant"]:checked');
  if (selectedVariantInput) {
    finalProductId = selectedVariantInput.value;
  }

  if (!AuthManager.isLoggedIn()) {
    goToUrl('login.html');
    return;
  }
  CartManager.addToCart(finalProductId, 1);
  document.getElementById('cart-drawer-overlay').classList.add('open');
};

// Beli Button Instant
window.handleInstantBuy = function (productName) {
  const prod = PRODUCTS.find(p => p.name === productName);
  if (prod) {
    if (prod.variants) {
      openProductQuickview(prod.id);
      return;
    }
    
    if (!AuthManager.isLoggedIn()) {
      goToUrl('login.html');
      return;
    }
    CartManager.addToCart(prod.id, 1);
    document.getElementById('cart-drawer-overlay').classList.add('open');
  }
};

// CONTACT: Handle mock form message submit
function initContactForm() {
  const form = document.getElementById('contact-form');
  const alertContainer = document.getElementById('contact-alert');
  if (!form || !alertContainer) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    // Extract info
    const name = document.getElementById('contact-name').value;
    const email = document.getElementById('contact-email').value;

    // Simulate submission loading
    const submitBtn = document.getElementById('btn-submit-message');
    if (submitBtn) {
      submitBtn.innerText = 'Mengirim Pesan...';
      submitBtn.disabled = true;
    }

    setTimeout(() => {
      // Re-enable
      if (submitBtn) {
        submitBtn.innerText = 'Kirim Pesan Sekarang';
        submitBtn.disabled = false;
      }

      // Show alert box
      alertContainer.innerHTML = `Terima kasih <strong>${name}</strong>! Pesan Anda telah berhasil terkirim. Tim PT Parung Hijau Perkasa akan membalas ke email <strong>${email}</strong> dalam waktu maksimal 24 jam.`;
      alertContainer.classList.add('alert-success');
      alertContainer.style.display = 'block';

      // Clear fields
      form.reset();

      // Scroll to alert container
      alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 1500);
  });
}

// 6. HEADER ANIMATION ON SCROLL
function initScrollEffect() {
  const header = document.getElementById('site-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
}

// 7. RESPONSIVE MOBILE NAVIGATION DRAWER
function initMobileNavigation() {
  const toggleBtn = document.getElementById('mobile-nav-toggle');
  const navMenu = document.getElementById('nav-menu');
  if (!toggleBtn || !navMenu) return;

  toggleBtn.addEventListener('click', (e) => {
    e.stopPropagation();

    // Toggle active state
    navMenu.classList.toggle('open');

    // Toggle class inside hamburger lines
    const lines = toggleBtn.querySelectorAll('.hamburger-line');
    lines.forEach(line => line.classList.toggle('open'));
  });

  // Close when click nav links
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      navMenu.classList.remove('open');
      const lines = toggleBtn.querySelectorAll('.hamburger-line');
      lines.forEach(line => line.classList.remove('open'));
    });
  });

  // Close when click anywhere else
  document.addEventListener('click', (e) => {
    if (!toggleBtn.contains(e.target) && !navMenu.contains(e.target)) {
      navMenu.classList.remove('open');
      const lines = toggleBtn.querySelectorAll('.hamburger-line');
      lines.forEach(line => line.classList.remove('open'));
    }
  });
}

function initUserNavigationDropdown(headerEl, currentPath) {
  const dropdown = headerEl.querySelector('#user-nav-dropdown');
  const trigger = headerEl.querySelector('#user-profile-trigger');
  const menu = headerEl.querySelector('#user-dropdown-menu');
  if (!dropdown || !trigger || !menu) return;

  const setOpen = (isOpen) => {
    dropdown.classList.toggle('open', isOpen);
    trigger.setAttribute('aria-expanded', String(isOpen));
  };

  if (currentPath === 'dashboard.html') {
    trigger.classList.add('active');
  }

  trigger.addEventListener('click', (event) => {
    event.preventDefault();
    event.stopPropagation();
    setOpen(!dropdown.classList.contains('open'));
  });

  menu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      setOpen(false);
      const navMenu = headerEl.querySelector('#nav-menu');
      const toggleBtn = headerEl.querySelector('#mobile-nav-toggle');
      navMenu?.classList.remove('open');
      toggleBtn?.querySelectorAll('.hamburger-line').forEach(line => line.classList.remove('open'));
    });
  });

  document.addEventListener('click', (event) => {
    if (!dropdown.contains(event.target)) {
      setOpen(false);
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      setOpen(false);
    }
  });
}

async function loadHeaderAndFooter() {
  const headerEl = document.getElementById('site-header');
  const footerEl = document.querySelector('.site-footer');

  if (headerEl) {
    try {
      // Dynamically render user authentication menu
      const userMenu = headerEl.querySelector('#header-user-menu');
      if (userMenu) {
        if (AuthManager.isLoggedIn()) {
          const user = AuthManager.getUser();
          const displayName = user?.name || 'Pengguna';
          const avatarInitial = displayName.charAt(0).toUpperCase();
          userMenu.innerHTML = `
            <div class="user-nav-dropdown" id="user-nav-dropdown">
              <button class="user-profile-trigger" id="user-profile-trigger" type="button" aria-haspopup="true" aria-expanded="false">
                <span class="user-profile-avatar">${avatarInitial}</span>
                <span class="user-profile-name">${displayName}</span>
                <svg class="user-profile-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                </svg>
              </button>
              <div class="user-dropdown-menu" id="user-dropdown-menu">
                <a href="${user?.dashboardUrl || getAssetUrl('dashboard')}" class="user-dropdown-link">Dashboard</a>
                <a href="#" class="user-dropdown-link user-dropdown-logout" onclick="handleLogout(event)">Keluar</a>
              </div>
            </div>
          `;
        } else {
          userMenu.innerHTML = `
            <a href="${getAssetUrl('login')}" class="nav-link" id="nav-login">Masuk</a>
          `;
        }
      }

      // Set active nav link based on current file path or full URL
      let currentPath = window.location.pathname.split('/').pop() || '';
      const pathname = window.location.pathname;

      const navLinks = headerEl.querySelectorAll('.nav-link');
      navLinks.forEach(link => {
        const hrefAttr = link.getAttribute('href');
        if (hrefAttr) {
          try {
            // Resolve the href to a absolute URL to easily check pathname
            const hrefUrl = new URL(hrefAttr, window.location.origin);
            const hrefPath = hrefUrl.pathname;
            
            // Check if it matches home or specific path
            const isHomeMatch = (pathname === '/' || pathname.endsWith('/index.html')) && (hrefPath === '/' || hrefPath.endsWith('/index.html'));
            const isPathMatch = !isHomeMatch && (pathname === hrefPath || pathname.endsWith(hrefPath) || (currentPath && hrefPath.endsWith('/' + currentPath)));
            
            if (isHomeMatch || isPathMatch) {
              link.classList.add('active');
            } else {
              link.classList.remove('active');
            }
          } catch (e) {
            // Fallback to basic match
            if (hrefAttr === currentPath) {
              link.classList.add('active');
            } else {
              link.classList.remove('active');
            }
          }
        }
      });

        initUserNavigationDropdown(headerEl, currentPath);

        // Inject Cart Drawer container if not present
        if (!document.getElementById('cart-drawer-overlay')) {
          const drawerOverlay = document.createElement('div');
          drawerOverlay.className = 'cart-drawer-overlay';
          drawerOverlay.id = 'cart-drawer-overlay';
          drawerOverlay.innerHTML = `
            <div class="cart-drawer">
              <div class="cart-drawer-header">
                <h3>Keranjang Belanja</h3>
                <button class="cart-drawer-close" id="cart-drawer-close" aria-label="Tutup Keranjang">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: currentColor;"><path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/></svg>
                </button>
              </div>
              
              <div class="cart-items-container" id="cart-drawer-items">
                <!-- Injected dynamically -->
              </div>
              
              <div class="cart-drawer-footer">
                
                <div class="cart-total-row">
                  <span>Total Belanja:</span>
                  <span id="cart-drawer-total">Rp 0</span>
                </div>
                
                <button class="btn btn-terracotta" id="btn-cart-checkout" style="width: 100%; border-radius: 30px;" onclick="handleCheckout()">Proses Checkout</button>
              </div>
            </div>
          `;
          document.body.appendChild(drawerOverlay);

          // Inject Mock Payment Gateway Modal
          const pgOverlay = document.createElement('div');
          pgOverlay.className = 'payment-gateway-overlay';
          pgOverlay.id = 'payment-gateway-overlay';
          pgOverlay.innerHTML = `
            <div class="payment-gateway-modal" id="payment-gateway-modal-box">
              <div id="pg-content-processing">
                <div class="pg-loading-spinner"></div>
                <h3 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 8px;">Memproses Pembayaran Otomatis</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Menghubungkan ke secure payment gateway virtual account. Mohon tidak menutup halaman...</p>
              </div>
              <div id="pg-content-success" style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 60px; height: 60px; fill: #27ae60; margin: 0 auto 20px auto;"><path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"/></svg>
                <h3 style="font-family: var(--font-serif); color: #27ae60; margin-bottom: 8px;">Pembayaran Berhasil!</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Transaksi Anda telah berhasil diproses secara otomatis. Pesanan Anda kini berstatus Lunas.</p>
              </div>
            </div>
          `;
          document.body.appendChild(pgOverlay);
        }

        // Bind cart toggle click
        const cartToggle = headerEl.querySelector('#cart-toggle-btn');
        if (cartToggle) {
          cartToggle.addEventListener('click', () => {
            document.getElementById('cart-drawer-overlay').classList.add('open');
            CartManager.renderCartDrawer();
          });
        }

        // Bind close button
        const cartClose = document.getElementById('cart-drawer-close');
        const cartOverlay = document.getElementById('cart-drawer-overlay');
        if (cartClose) {
          cartClose.addEventListener('click', () => {
            cartOverlay.classList.remove('open');
          });
        }
        if (cartOverlay) {
          cartOverlay.addEventListener('click', (e) => {
            if (e.target === cartOverlay) {
              cartOverlay.classList.remove('open');
            }
          });
        }

        // Set badge count on load
        CartManager.updateHeaderBadge();
        
        // Re-initialize nav events
        initMobileNavigation();
        initScrollEffect();
    } catch (err) {
      console.error('Error loading header:', err);
    }
  }
}

// Helper: Initialize Checkout Page
window.initCheckoutPage = function() {
  if (!AuthManager.isLoggedIn()) {
    goToUrl('login.html');
    return;
  }

  const addresses = AuthManager.getAddresses();
  const cart = CartManager.getCart();

  if (cart.length === 0) {
    const pageContainer = document.getElementById('page-container');
    if (pageContainer) {
      pageContainer.innerHTML = `
        <section class="section" style="padding: 100px 0; text-align: center;">
          <div class="container">
            <h2 style="font-family: var(--font-serif); color: var(--primary); margin-bottom: 16px;">Keranjang Belanja Kosong</h2>
            <p style="color: var(--text-muted); margin-bottom: 30px;">Anda belum menambahkan produk apapun ke keranjang.</p>
            <a href="${getAssetUrl('produk-kami')}" class="btn btn-terracotta" style="border-radius: 30px; padding: 12px 30px;">Jelajahi Produk</a>
          </div>
        </section>
      `;
    }
    return;
  }

  // Populate addresses select
  const selectContainer = document.getElementById('checkout-address-select-container');
  if (selectContainer && addresses.length > 0) {
    const addressOptions = addresses.map(addr => `
      <option value="${addr.id}" ${addr.isDefault ? 'selected' : ''}>
        ${addr.name} (${addr.phone}) - ${addr.addressLine.substring(0, 35)}${addr.addressLine.length > 35 ? '...' : ''}
      </option>
    `).join('');
    
    selectContainer.innerHTML = `
      <div class="form-group" style="margin-bottom: 24px;">
        <label class="auth-label" style="color: var(--primary); font-weight: 600; margin-bottom: 8px; display: block;">Alamat Tersimpan</label>
        <select id="checkout-address-select" onchange="populateCheckoutAddress(this.value)" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid rgba(182, 138, 88, 0.35); font-family: var(--font-sans); background: var(--white); cursor: pointer;">
          <option value="">-- Pilih Alamat Tersimpan --</option>
          ${addressOptions}
        </select>
      </div>
    `;
    
    // Autofill with default address
    const defaultAddr = addresses.find(a => a.isDefault);
    if (defaultAddr) {
      window.populateCheckoutAddress(defaultAddr.id);
    }
  }

  // Populate cart items
  window.renderCheckoutItems();
};

window.renderCheckoutItems = function() {
  const container = document.getElementById('checkout-items-list-container');
  if (!container) return;

  const cart = CartManager.getCart();
  const total = CartManager.getCartTotal();
  const totalStr = formatIDR(total);

  container.innerHTML = cart.map(item => {
    const prod = findProductById(item.productId) || { name: 'Produk', price: 0, priceStr: 'Rp 0', image: 'assets/images/logo.png' };
    const subtotal = prod.price * item.qty;
    const subtotalStr = formatIDR(subtotal);
    
    return `
      <div class="checkout-item" data-product-id="${item.productId}" style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid rgba(182, 138, 88, 0.15); padding-bottom: 15px;">
        <img src="${getAssetUrl(prod.image)}" alt="${prod.name}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(182, 138, 88, 0.2);">
        <div style="flex: 1;">
          <h4 style="font-size: 1rem; color: var(--primary); font-weight: 600; margin-bottom: 4px;">${prod.name}</h4>
          <div style="color: var(--accent); font-weight: 600; font-size: 0.9rem; margin-bottom: 8px;">${prod.priceStr}</div>
          
            <div style="display: flex; align-items: center; gap: 8px;">
              <label style="font-size: 0.8rem; color: var(--text-muted); margin-right: 4px;">Qty:</label>
              <div style="display: flex; align-items: center; border: 1px solid rgba(182, 138, 88, 0.35); border-radius: 20px; overflow: hidden; background: var(--bg-cream);">
                <button type="button" onclick="changeCheckoutQty('${item.productId}', -1)" style="width: 28px; height: 28px; border: none; background: transparent; color: var(--primary); font-size: 1.1rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0;">-</button>
                <input type="text" inputmode="numeric" pattern="[0-9]*" value="${item.qty}" id="qty-input-${item.productId}" class="checkout-qty-input"
                       style="width: 35px; border: none; background: transparent; text-align: center; font-size: 0.85rem; font-weight: 600; color: var(--primary); padding: 0; margin: 0; outline: none;" 
                       oninput="this.value = this.value.replace(/[^0-9]/g, ''); handleCheckoutQtyChange('${item.productId}', this.value)"
                       onblur="if(this.value === '' || this.value === '0') { this.value = '1'; handleCheckoutQtyChange('${item.productId}', 1); }">
                <button type="button" onclick="changeCheckoutQty('${item.productId}', 1)" style="width: 28px; height: 28px; border: none; background: transparent; color: var(--primary); font-size: 1.1rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0;">+</button>
              </div>
            </div>
            <div class="checkout-item-subtotal" style="font-weight: 700; color: var(--primary); font-size: 0.95rem;">${subtotalStr}</div>
          </div>
        </div>
      </div>
    `;
  }).join('');

  document.getElementById('checkout-qty-total').innerText = cart.reduce((sum, item) => sum + item.qty, 0) + ' Pcs';
  document.getElementById('checkout-total-label').innerText = totalStr;
  
  const submitBtn = document.getElementById('checkout-submit-btn');
  if (submitBtn) {
    submitBtn.innerText = `Buat Pesanan (${totalStr})`;
  }
};

// 8. ON DOM CONTENT LOAD INITIALIZATION
document.addEventListener('DOMContentLoaded', async () => {
  // Dynamically load header & footer
  await loadHeaderAndFooter();

  // Run page-specific initializations
  renderCatalogProducts();
  initCatalogFilters();
  initContactForm();
  
  // If we are on CodeIgniter home page, run home-specific initializations
  const pathname = window.location.pathname;
  const isCiHome = window.BASE_URL && (
    pathname === '/'
    || pathname.endsWith('/index.php')
    || pathname.endsWith('/index.php/')
  );
  if (isCiHome) {
    renderHomeFeaturedProducts();
    animateHeroDescWordByWord();
  }
  
  // Page-specific initialization for login and dashboard pages
  const currentPath = window.location.pathname.split('/').pop();
  if (currentPath === 'login.html' || (window.BASE_URL && currentPath === 'login')) {
    if (AuthManager.isLoggedIn()) {
      goToUrl('dashboard.html');
    }
  } else if (currentPath === 'dashboard.html' || (window.BASE_URL && currentPath === 'dashboard')) {
    if (!AuthManager.isLoggedIn()) {
      goToUrl('login.html');
    } else {
      initDashboard();
    }
  } else if (currentPath === 'checkout' || (window.BASE_URL && currentPath === 'checkout')) {
    initCheckoutPage();
  }

  // For pelanggan dashboard hash settings tab check
  if (window.location.hash === '#settings') {
    if (typeof window.switchDashboardTab === 'function') {
      window.switchDashboardTab('settings');
    }
  }

  // Address confirm delete button event listener
  const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener('click', async function() {
      if (typeof addressToDelete === 'undefined' || !addressToDelete) return;
      const id = addressToDelete;
      if (typeof window.closeCustomDeleteModal === 'function') {
        window.closeCustomDeleteModal();
      }
      
      try {
        const response = await fetch(`${window.BASE_URL}pelanggan/alamat/hapus/${id}`, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        const result = await response.json();
        if (result.status === 'success') {
          if (typeof window.showToast === 'function') {
            window.showToast(result.message, 'success');
          } else {
            alert(result.message);
          }
          setTimeout(() => { window.location.hash = 'settings'; location.reload(); }, 1500);
        } else {
          const errMsg = 'Gagal menghapus alamat: ' + (result.message || 'Unknown error');
          if (typeof window.showToast === 'function') {
            window.showToast(errMsg, 'error');
          } else {
            alert(errMsg);
          }
        }
      } catch (err) {
        console.error(err);
        if (typeof window.showToast === 'function') {
          window.showToast('Terjadi kesalahan saat menghapus alamat.', 'error');
        } else {
          alert('Terjadi kesalahan saat menghapus alamat.');
        }
      }
    });
  }

  // Initialize Scroll Reveal observer
  initScrollReveal();

  // Modal event close buttons binding
  const modalClose = document.getElementById('modal-close');
  const modalOverlay = document.getElementById('product-modal');
  if (modalClose) {
    modalClose.addEventListener('click', closeQuickviewModal);
  }
  if (modalOverlay) {
    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) closeQuickviewModal();
    });
  }

  // Close modal on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeQuickviewModal();
  });

  // Back to Top Button scroll handler
  const backToTopBtn = document.getElementById('back-to-top');
  if (backToTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    });

    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});

// ==========================================================================
// 10. AUTHENTICATION PAGE ACTIONS
// ==========================================================================
window.switchAuthTab = function (tab) {
  const loginForm = document.getElementById('login-form');
  const registerForm = document.getElementById('register-form');
  const tabLogin = document.getElementById('tab-login');
  const tabRegister = document.getElementById('tab-register');

  if (tab === 'login') {
    loginForm.style.display = 'flex';
    registerForm.style.display = 'none';
    tabLogin.classList.add('active');
    tabRegister.classList.remove('active');
  } else {
    loginForm.style.display = 'none';
    registerForm.style.display = 'flex';
    tabLogin.classList.remove('active');
    tabRegister.classList.add('active');
  }
};

window.autofillDemoCredentials = function () {
  const emailInput = document.getElementById('login-email');
  const passwordInput = document.getElementById('login-password');
  if (emailInput && passwordInput) {
    emailInput.value = 'demo@parunghijau.com';
    passwordInput.value = 'password123';
  }
};

window.handleAuthSubmit = function (event, type) {
  event.preventDefault();
  if (type === 'login') {
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    try {
      AuthManager.login(email, password);
      alert('Login berhasil! Mengarahkan Anda ke dashboard...');
      goToUrl('dashboard.html');
    } catch (err) {
      alert(err.message);
    }
  } else {
    const name = document.getElementById('register-name').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;
    try {
      AuthManager.register(name, email, password);
      alert('Registrasi berhasil! Mengarahkan Anda ke dashboard...');
      goToUrl('dashboard.html');
    } catch (err) {
      alert(err.message);
    }
  }
};

window.handleLogout = function (event) {
  if (event) event.preventDefault();
  AuthManager.logout();
};

// ==========================================================================
// 11. USER DASHBOARD MANAGER
// ==========================================================================
function initDashboard() {
  const user = AuthManager.getUser();
  if (!user) return;

  // Set Profile UI
  const avatarEl = document.getElementById('user-avatar');
  const nameEl = document.getElementById('user-display-name');
  const emailEl = document.getElementById('user-display-email');
  const welcomeName = document.getElementById('welcome-name');

  if (avatarEl) avatarEl.innerText = user.name.charAt(0).toUpperCase();
  if (nameEl) nameEl.innerText = user.name;
  if (emailEl) emailEl.innerText = user.email;
  if (welcomeName) welcomeName.innerText = user.name;

  // Populate settings form inputs
  const settingsNameInput = document.getElementById('settings-name');
  const settingsEmailInput = document.getElementById('settings-email');
  if (settingsNameInput) settingsNameInput.value = user.name;
  if (settingsEmailInput) settingsEmailInput.value = user.email;

  renderDashboardStats();
  renderOrdersTable();
  renderDashboardAddresses();
}

window.switchDashboardTab = function (tab, e) {
  if (e) e.preventDefault();
  
  const summaryPanel = document.getElementById('dashboard-summary-panel');
  const settingsPanel = document.getElementById('dashboard-settings-panel');
  const summaryMenu = document.getElementById('menu-summary');
  const settingsMenu = document.getElementById('menu-settings');

  if (!summaryPanel || !settingsPanel) return;

  if (tab === 'summary') {
    summaryPanel.style.display = 'block';
    settingsPanel.style.display = 'none';
    if (summaryMenu) summaryMenu.classList.add('active');
    if (settingsMenu) settingsMenu.classList.remove('active');
  } else {
    summaryPanel.style.display = 'none';
    settingsPanel.style.display = 'block';
    if (summaryMenu) summaryMenu.classList.remove('active');
    if (settingsMenu) settingsMenu.classList.add('active');
    window.closeAddAddressForm();
    window.renderDashboardAddresses();
  }
};

window.handleUpdateProfile = function (e) {
  e.preventDefault();
  const name = document.getElementById('settings-name').value;
  const pass = document.getElementById('settings-password').value;
  const passConfirm = document.getElementById('settings-password-confirm').value;

  if (!name) {
    alert('Nama tidak boleh kosong.');
    return;
  }

  if (pass) {
    if (pass !== passConfirm) {
      alert('Konfirmasi kata sandi tidak cocok.');
      return;
    }
    if (pass.length < 6) {
      alert('Kata sandi minimal 6 karakter.');
      return;
    }
  }

  AuthManager.updateProfile(name, pass || null);
  alert('Profil berhasil diperbarui!');
  
  document.getElementById('settings-password').value = '';
  document.getElementById('settings-password-confirm').value = '';
  
  initDashboard();
};

window.renderDashboardAddresses = function () {
  const container = document.getElementById('address-cards-container');
  if (!container) return;

  const addresses = AuthManager.getAddresses();
  if (addresses.length === 0) {
    container.innerHTML = `
      <div style="grid-column: 1/-1; text-align: center; padding: 30px; background: rgba(182, 138, 88, 0.04); border: 1px dashed rgba(182, 138, 88, 0.2); border-radius: 12px; color: var(--text-muted); font-size: 0.9rem;">
        Belum ada alamat pengiriman tersimpan. Silakan tambah alamat baru.
      </div>
    `;
    return;
  }

  container.innerHTML = addresses.map(addr => `
    <div class="address-card ${addr.isDefault ? 'default' : ''}" style="background: var(--white); border: 1px solid ${addr.isDefault ? 'var(--accent)' : 'rgba(182, 138, 88, 0.25)'}; border-radius: 16px; padding: 20px; box-shadow: var(--shadow-soft); position: relative; display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; gap: 10px;">
          <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--primary); margin: 0;">${addr.name}</h4>
          ${addr.isDefault ? `<span class="designer-badge" style="background: rgba(182, 138, 88, 0.15); color: var(--accent); border: 1px solid rgba(182, 138, 88, 0.3); font-size: 0.72rem; padding: 2px 8px; margin: 0; white-space: nowrap;">Penerima Utama</span>` : ''}
        </div>
        <p style="font-size: 0.85rem; color: var(--accent); font-weight: 600; margin-bottom: 8px;">${addr.phone}</p>
        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.4; margin-bottom: 20px;">${addr.addressLine}</p>
      </div>
      <div style="display: flex; gap: 10px; justify-content: flex-end; border-top: 1px solid rgba(182, 138, 88, 0.1); padding-top: 12px;">
        ${!addr.isDefault ? `
          <button type="button" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.78rem; border-radius: 20px; border-color: rgba(182, 138, 88, 0.3);" onclick="setDashboardAddressDefault('${addr.id}')">Set Utama</button>
        ` : ''}
        <button type="button" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.78rem; border-radius: 20px; border-color: rgba(182, 138, 88, 0.3);" onclick="openAddAddressForm('${addr.id}')">Edit</button>
        <button type="button" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.78rem; border-radius: 20px; background: #e57373; border-color: #e57373;" onclick="deleteDashboardAddress('${addr.id}')">Hapus</button>
      </div>
    </div>
  `).join('');
};

window.openAddAddressForm = function (addrId) {
  const wrapper = document.getElementById('add-address-form-wrapper');
  const title = document.getElementById('address-form-title');
  const idInput = document.getElementById('address-id');
  const nameInput = document.getElementById('address-recipient-name');
  const phoneInput = document.getElementById('address-recipient-phone');
  const lineInput = document.getElementById('address-line');
  const defaultInput = document.getElementById('address-is-default');

  if (!wrapper) return;

  wrapper.style.display = 'block';

  if (addrId) {
    const addresses = AuthManager.getAddresses();
    const matched = addresses.find(a => a.id === addrId);
    if (matched) {
      title.innerText = 'Ubah Alamat Pengiriman';
      idInput.value = matched.id;
      nameInput.value = matched.name;
      phoneInput.value = matched.phone;
      lineInput.value = matched.addressLine;
      defaultInput.checked = matched.isDefault;
      if (matched.isDefault) {
        defaultInput.disabled = true;
      } else {
        defaultInput.disabled = false;
      }
    }
  } else {
    title.innerText = 'Tambah Alamat Baru';
    idInput.value = '';
    nameInput.value = '';
    phoneInput.value = '';
    lineInput.value = '';
    defaultInput.checked = false;
    defaultInput.disabled = false;
  }
};

window.closeAddAddressForm = function () {
  const wrapper = document.getElementById('add-address-form-wrapper');
  if (wrapper) wrapper.style.display = 'none';
};

window.handleSaveAddress = function (e) {
  e.preventDefault();
  const id = document.getElementById('address-id').value;
  const name = document.getElementById('address-recipient-name').value;
  const phone = document.getElementById('address-recipient-phone').value;
  const line = document.getElementById('address-line').value;
  const isDefault = document.getElementById('address-is-default').checked;

  if (!name || !phone || !line) {
    alert('Mohon lengkapi kolom wajib.');
    return;
  }

  AuthManager.saveAddress({
    id: id || null,
    name: name,
    phone: phone,
    addressLine: line,
    isDefault: isDefault
  });

  alert(id ? 'Alamat berhasil diubah!' : 'Alamat baru berhasil ditambahkan!');
  window.closeAddAddressForm();
  window.renderDashboardAddresses();
};

window.setDashboardAddressDefault = function (addrId) {
  const addresses = AuthManager.getAddresses();
  const matched = addresses.find(a => a.id === addrId);
  if (matched) {
    matched.isDefault = true;
    AuthManager.saveAddress(matched);
    window.renderDashboardAddresses();
  }
};

window.deleteDashboardAddress = function (addrId) {
  if (confirm('Apakah Anda yakin ingin menghapus alamat ini?')) {
    AuthManager.deleteAddress(addrId);
    window.renderDashboardAddresses();
  }
};

function getOrders() {
  return JSON.parse(localStorage.getItem('orderHistory')) || [];
}

function renderDashboardStats() {
  const orders = getOrders();
  
  const totalOrdersEl = document.getElementById('stat-total-orders');
  const pendingEl = document.getElementById('stat-pending-payments');
  const completedEl = document.getElementById('stat-completed-payments');

  if (totalOrdersEl) totalOrdersEl.innerText = orders.length;
  if (pendingEl) pendingEl.innerText = orders.filter(o => o.status === 'Menunggu Pembayaran').length;
  if (completedEl) completedEl.innerText = orders.filter(o => o.status === 'Lunas').length;
}

function renderOrdersTable() {
  const tbody = document.getElementById('orders-list-body');
  if (!tbody) return;

  const orders = getOrders();
  if (orders.length === 0) {
    tbody.innerHTML = `
      <tr class="order-empty-row">
        <td class="order-empty-cell" colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
          Anda belum memiliki riwayat pesanan.
        </td>
      </tr>
    `;
    return;
  }

  tbody.innerHTML = orders.map(order => {
    let itemsStr = order.items.map(item => `${item.name} (${item.qty}x)`).join(', ');
    
    let statusClass = 'status-pending';
    if (order.status === 'Menunggu Verifikasi') statusClass = 'status-verifying';
    else if (order.status === 'Lunas') statusClass = 'status-success';

    let actionBtnHtml = '';
    if (order.status === 'Menunggu Pembayaran') {
      actionBtnHtml = `
        <button class="btn btn-terracotta" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 4px;" 
                onclick="openUploadModal('${order.id}', ${order.total})">
          Bayar / Konfirmasi
        </button>
      `;
    } else if (order.status === 'Menunggu Verifikasi') {
      actionBtnHtml = `
        <span style="font-size: 0.8rem; color: var(--text-muted); font-style: italic;">Memverifikasi bukti</span>
      `;
    } else {
      actionBtnHtml = `
        <span style="font-size: 0.85rem; color: #27ae60; font-weight: 600;">Selesai (Lunas)</span>
      `;
    }

    return `
      <tr>
        <td data-label="ID Pesanan" style="font-weight: bold; color: var(--primary);">${order.id}</td>
        <td data-label="Tanggal">${order.date}</td>
        <td data-label="Detail Produk" class="order-items-cell" title="${itemsStr}">${itemsStr}</td>
        <td data-label="Total Harga" style="font-weight: 700; color: var(--primary);">${formatIDR(order.total)}</td>
        <td data-label="Metode">${order.method}</td>
        <td data-label="Status"><span class="status-badge ${statusClass}">${order.status}</span></td>
        <td data-label="Aksi">${actionBtnHtml}</td>
      </tr>
    `;
  }).join('');
}

// Payment Proof Upload Modal Action
window.openUploadModal = function (orderId, amount) {
  const modal = document.getElementById('upload-modal');
  const amountLabel = document.getElementById('upload-amount-label');
  const orderIdInput = document.getElementById('upload-order-id');

  if (modal && amountLabel && orderIdInput) {
    orderIdInput.value = orderId;
    amountLabel.innerText = formatIDR(amount);
    
    // Reset form state
    document.getElementById('upload-proof-form').reset();
    const previewImg = document.getElementById('proof-preview-img');
    if (previewImg) previewImg.style.display = 'none';

    modal.classList.add('open');
  }
};

window.closeUploadModal = function () {
  const modal = document.getElementById('upload-modal');
  if (modal) modal.classList.remove('open');
};

window.triggerFileInput = function () {
  const fileInput = document.getElementById('proof-file-input');
  if (fileInput) fileInput.click();
};

window.previewProofImage = function (event) {
  const file = event.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function (e) {
    const previewImg = document.getElementById('proof-preview-img');
    if (previewImg) {
      previewImg.src = e.target.result;
      previewImg.style.display = 'block';
    }
  };
  reader.readAsDataURL(file);
};

window.handleUploadProofSubmit = function (event) {
  event.preventDefault();
  const orderId = document.getElementById('upload-order-id').value;
  const fileInput = document.getElementById('proof-file-input');

  if (!fileInput.files || fileInput.files.length === 0) {
    alert('Silakan pilih berkas screenshot/gambar bukti transfer Anda terlebih dahulu.');
    return;
  }

  // Update order status in localStorage
  let orders = getOrders();
  const order = orders.find(o => o.id === orderId);
  if (order) {
    order.status = 'Menunggu Verifikasi';
    // Mock save payment proof (using name of file or simulated string)
    order.paymentProof = fileInput.files[0].name;
    localStorage.setItem('orderHistory', JSON.stringify(orders));
    
    alert('Bukti transfer telah dikirim! Status pesanan Anda kini "Menunggu Verifikasi". Tim admin kami akan segera memeriksa.');
    closeUploadModal();
    initDashboard(); // Re-render table and stats
  }
};

// 9. SCROLL REVEAL (INTERSECTION OBSERVER)
function initScrollReveal() {
  const reveals = document.querySelectorAll('.reveal');
  if (reveals.length === 0) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
        observer.unobserve(entry.target);
      }
    });
  }, {
    root: null,
    threshold: 0.08,
    rootMargin: '0px 0px -40px 0px'
  });

  reveals.forEach(reveal => {
    const rect = reveal.getBoundingClientRect();
    const isAboveOrInViewport = rect.top < window.innerHeight;
    if (isAboveOrInViewport) {
      reveal.classList.add('active');
    } else {
      observer.observe(reveal);
    }
  });
}

// ==========================================================================
// 12. CUSTOMER DASHBOARD (REAL DYNAMIC DATABASE OPERATIONS)
// ==========================================================================
window.switchDashboardTab = function (tab, event) {
  if (event) event.preventDefault();
  
  // Update menu active class
  document.querySelectorAll('.dashboard-menu-link').forEach(link => {
    link.classList.remove('active');
  });
  
  const activeLink = event ? event.currentTarget : document.getElementById('menu-' + tab);
  if (activeLink) activeLink.classList.add('active');
  
  // Show / Hide panels
  const summaryPanel = document.getElementById('dashboard-summary-panel');
  const settingsPanel = document.getElementById('dashboard-settings-panel');
  
  if (tab === 'summary') {
    if (summaryPanel) summaryPanel.style.display = 'block';
    if (settingsPanel) settingsPanel.style.display = 'none';
  } else if (tab === 'settings') {
    if (summaryPanel) summaryPanel.style.display = 'none';
    if (settingsPanel) settingsPanel.style.display = 'block';
  }
};

window.openPaymentProofModal = function (orderId, amount) {
  const orderIdInput = document.getElementById('upload-order-id');
  const amountLabel = document.getElementById('upload-amount-label');
  const modal = document.getElementById('upload-modal');
  
  if (orderIdInput) orderIdInput.value = orderId;
  if (amountLabel) amountLabel.textContent = 'Rp ' + amount.toLocaleString('id-ID');
  if (modal) modal.classList.add('open');
};

window.closeUploadModal = function () {
  const modal = document.getElementById('upload-modal');
  if (modal) modal.classList.remove('open');
};

window.triggerFileInput = function () {
  const fileInput = document.getElementById('proof-file-input');
  if (fileInput) fileInput.click();
};

window.previewProofImage = function (event) {
  const input = event.target;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview = document.getElementById('proof-preview-img');
      if (preview) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
    }
    reader.readAsDataURL(input.files[0]);
  }
};

window.showToast = function (message, type = 'success') {
  const toast = document.createElement('div');
  toast.style.position = 'fixed';
  toast.style.bottom = '30px';
  toast.style.right = '30px';
  toast.style.padding = '16px 24px';
  toast.style.borderRadius = '12px';
  toast.style.color = '#fff';
  toast.style.background = type === 'success' ? '#22c55e' : '#ef4444';
  toast.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
  toast.style.zIndex = '999999';
  toast.style.fontFamily = 'var(--font-sans)';
  toast.style.fontWeight = '600';
  toast.style.fontSize = '0.9rem';
  toast.style.transform = 'translateY(100px)';
  toast.style.opacity = '0';
  toast.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
  toast.innerHTML = `<span style="margin-right: 8px; font-size: 1.1em;">${type === 'success' ? '✓' : '⚠'}</span> ${message}`;
  
  document.body.appendChild(toast);
  
  // Trigger reflow
  toast.offsetHeight;
  
  toast.style.transform = 'translateY(0)';
  toast.style.opacity = '1';
  
  setTimeout(() => {
    toast.style.transform = 'translateY(100px)';
    toast.style.opacity = '0';
    setTimeout(() => {
      if (document.body.contains(toast)) document.body.removeChild(toast);
    }, 400);
  }, 3000);
};

window.handleUploadProofSubmit = function (event) {
  event.preventDefault();
  const orderId = document.getElementById('upload-order-id').value;
  const fileInput = document.getElementById('proof-file-input');
  
  if (!fileInput.files || fileInput.files.length === 0) {
    window.showToast('Silakan pilih berkas gambar bukti transfer terlebih dahulu.', 'error');
    return;
  }

  const formData = new FormData();
  formData.append('bukti_transfer', fileInput.files[0]);

  fetch('transaksi/bukti/' + orderId, {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      window.showToast(data.message || 'Bukti pembayaran berhasil dikirim! Pembayaran Anda akan segera diverifikasi.', 'success');
      window.closeUploadModal();
      setTimeout(() => location.reload(), 1500);
    } else {
      window.showToast(data.message || 'Gagal mengirim bukti pembayaran.', 'error');
    }
  })
  .catch(err => {
    console.error(err);
    window.showToast('Terjadi kesalahan koneksi atau upload.', 'error');
  });
};

window.handleUpdateProfile = function (event) {
  event.preventDefault();
  window.showToast('Profil Anda berhasil diperbarui!', 'success');
};

window.openAddAddressForm = function () {
  const formTitle = document.getElementById('address-form-title');
  const idInput = document.getElementById('address-id');
  const recipientInput = document.getElementById('address-recipient-name');
  const phoneInput = document.getElementById('address-recipient-phone');
  const lineInput = document.getElementById('address-line');
  const defaultInput = document.getElementById('address-is-default');
  const wrapper = document.getElementById('add-address-form-wrapper');

  if (formTitle) formTitle.innerText = 'Tambah Alamat Baru';
  if (idInput) idInput.value = '';
  if (recipientInput) recipientInput.value = '';
  if (phoneInput) phoneInput.value = '';
  if (lineInput) lineInput.value = '';
  if (defaultInput) {
    defaultInput.checked = false;
    defaultInput.disabled = false;
  }
  if (wrapper) {
    wrapper.style.display = 'block';
    wrapper.scrollIntoView({ behavior: 'smooth' });
  }
};

window.openEditAddressForm = function (btn) {
  let data = {};
  try {
    data = JSON.parse(btn.getAttribute('data-info') || '{}');
  } catch(e){}
  
  const formTitle = document.getElementById('address-form-title');
  const idInput = document.getElementById('address-id');
  const recipientInput = document.getElementById('address-recipient-name');
  const phoneInput = document.getElementById('address-recipient-phone');
  const lineInput = document.getElementById('address-line');
  const defaultInput = document.getElementById('address-is-default');
  const wrapper = document.getElementById('add-address-form-wrapper');

  if (formTitle) formTitle.innerText = 'Edit Alamat';
  if (idInput) idInput.value = data.id || '';
  if (recipientInput) recipientInput.value = data.recipient_name || '';
  if (phoneInput) phoneInput.value = data.phone || '';
  if (lineInput) lineInput.value = data.address_line || '';
  if (defaultInput) {
    defaultInput.checked = data.is_default == 1;
    defaultInput.disabled = false;
  }
  if (wrapper) {
    wrapper.style.display = 'block';
    wrapper.scrollIntoView({ behavior: 'smooth' });
  }
};

window.closeAddAddressForm = function () {
  const wrapper = document.getElementById('add-address-form-wrapper');
  if (wrapper) wrapper.style.display = 'none';
};

window.submitCustomerAddress = async function (event) {
  event.preventDefault();
  
  const addressId = document.getElementById('address-id').value;
  const recipientName = document.getElementById('address-recipient-name').value;
  const phone = document.getElementById('address-recipient-phone').value;
  const addressLine = document.getElementById('address-line').value;
  const isDefault = document.getElementById('address-is-default').checked ? 1 : 0;
  
  try {
    const formData = new FormData();
    formData.append('recipient_name', recipientName);
    formData.append('phone', phone);
    formData.append('address_line', addressLine);
    formData.append('is_default', isDefault);

    const url = addressId 
      ? `\${window.BASE_URL}pelanggan/alamat/update/\${addressId}` 
      : `\${window.BASE_URL}pelanggan/alamat/simpan`;

    const response = await fetch(url, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    const result = await response.json();
    if (result.status === 'success') {
      window.showToast(result.message, 'success');
      window.closeAddAddressForm();
      setTimeout(() => { window.location.hash = 'settings'; location.reload(); }, 600);
    } else {
      window.showToast('Gagal menyimpan alamat: ' + (result.message || 'Unknown error'), 'error');
    }
  } catch (err) {
    console.error(err);
    window.showToast('Terjadi kesalahan saat menyimpan alamat.', 'error');
  }
};

let addressToDelete = null;

window.closeCustomDeleteModal = function () {
  const modal = document.getElementById('custom-delete-modal');
  const box = document.getElementById('custom-delete-modal-box');
  if (box) box.style.transform = 'scale(0.9)';
  if (modal) modal.style.opacity = '0';
  setTimeout(() => { if (modal) modal.style.display = 'none'; }, 300);
  addressToDelete = null;
};

window.hapusAlamat = async function (id) {
  addressToDelete = id;
  const modal = document.getElementById('custom-delete-modal');
  const box = document.getElementById('custom-delete-modal-box');
  if (modal && box) {
    modal.style.display = 'flex';
    // Trigger reflow
    void modal.offsetWidth;
    modal.style.opacity = '1';
    box.style.transform = 'scale(1)';
  }
};

window.openOrderDetailModal = function (btn) {
  const modal = document.getElementById('order-detail-modal');
  let data = {};
  try {
    data = JSON.parse(btn.getAttribute('data-info') || '{}');
  } catch (e) {
    console.error('Failed to parse transaction data', e);
  }

  const title = document.getElementById('detail-modal-title');
  const date = document.getElementById('detail-order-date');
  const badge = document.getElementById('detail-order-status-badge');
  const addr = document.getElementById('detail-order-address');

  if (title) title.textContent = 'Detail Pesanan #' + (data.id || '');
  if (date) date.textContent = data.tanggal || '';
  if (badge) badge.innerHTML = data.statusBadge || '';
  if (addr) addr.textContent = data.alamat || '';
  
  const productsList = document.getElementById('detail-products-list');
  if (productsList) {
    let productsHtml = '';
    let subtotal = 0;
    
    if (data.details && data.details.length > 0) {
      data.details.forEach(item => {
        let harga = parseInt(item.harga_satuan) || 0;
        let qty = parseInt(item.qty) || 0;
        let total = harga * qty;
        subtotal += total;
        
        let imgPath = item.image_path ? (window.BASE_URL + item.image_path) : (window.BASE_URL + 'assets/images/produk/default.png');
        
        productsHtml += `
          <div style="display: flex; align-items: center; gap: 15px; padding: 12px; border: 1px solid rgba(182, 138, 88, 0.15); border-radius: 12px; background: rgba(182, 138, 88, 0.02);">
            <img src="${imgPath}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(182, 138, 88, 0.2);" onerror="this.src='${window.BASE_URL}assets/images/produk/default.png'">
            <div style="flex-grow: 1;">
              <h5 style="font-family: var(--font-serif); color: var(--primary); font-size: 0.95rem; margin: 0 0 4px 0; font-weight: 600;">${item.produk_nama}</h5>
              <span style="color: var(--text-muted); font-size: 0.8rem;">Harga: Rp ${harga.toLocaleString('id-ID')}</span>
            </div>
            <div style="text-align: right;">
              <span style="font-weight: 600; color: var(--primary); display: block; font-size: 0.85rem;">x${qty}</span>
              <strong style="color: var(--accent); font-size: 0.95rem;">Rp ${total.toLocaleString('id-ID')}</strong>
            </div>
          </div>
        `;
      });
    } else {
      productsHtml = '<p class="text-muted small">Tidak ada detail produk.</p>';
    }
    
    productsList.innerHTML = productsHtml;
    const subtotalEl = document.getElementById('detail-summary-subtotal');
    const totalEl = document.getElementById('detail-summary-total');
    if (subtotalEl) subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    if (totalEl) totalEl.textContent = 'Rp ' + (parseInt(data.total_harga) || subtotal).toLocaleString('id-ID');
  }
  
  if (modal) modal.classList.add('open');
};

window.closeOrderDetailModal = function () {
  const modal = document.getElementById('order-detail-modal');
  if (modal) modal.classList.remove('open');
};

