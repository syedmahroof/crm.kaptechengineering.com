// Mobile Menu Toggle
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('.nav-menu');

if (menuToggle) {
  menuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
  });
}

// Header Scroll Effect
const header = document.querySelector('header');
let lastScroll = 0;

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;
  
  if (currentScroll > 50) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
  
  lastScroll = currentScroll;
});

// Active Navigation Link
const currentLocation = location.pathname.split('/').pop() || 'index.html';
const menuItems = document.querySelectorAll('.nav-menu a');

menuItems.forEach(item => {
  if (item.getAttribute('href') === currentLocation) {
    item.classList.add('active');
  }
});

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Load Products (for products.html) - Organized by Category
async function loadProducts() {
  try {
    const response = await fetch('products.json');
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const products = await response.json();
    const productsGrid = document.getElementById('products-grid');
    
    if (productsGrid) {
      // Define category order and display names
      const categoryOrder = [
        { key: 'Cable Tray', display: 'Cable Trays', icon: '📊' },
        { key: 'Channels/Bracket', display: 'Channels & Brackets', icon: '⚙️' },
        { key: 'Pipe Supporting Clamps', display: 'Pipe Supporting Clamps', icon: '🔧' },
        { key: 'Clamps', display: 'Clamps & Supports', icon: '🔗' },
        { key: 'Fasteners', display: 'Fasteners & Hardware', icon: '🔩' },
        { key: 'Accessories', display: 'Accessories & Fittings', icon: '🛠️' },
        { key: 'Cable Tray Accessories', display: 'Cable Tray Accessories', icon: '📦' }
      ];
      
      // Group products by category
      const productsByCategory = {};
      products.forEach(product => {
        const category = product.category;
        if (!productsByCategory[category]) {
          productsByCategory[category] = [];
        }
        productsByCategory[category].push(product);
      });
      
      // Build HTML with categories
      let html = '';
      categoryOrder.forEach(cat => {
        const categoryProducts = productsByCategory[cat.key];
        if (categoryProducts && categoryProducts.length > 0) {
          html += `
            <div class="category-section">
              <div class="category-header">
                <span class="category-icon">${cat.icon}</span>
                <h2 class="category-title">${cat.display}</h2>
                <span class="category-count">${categoryProducts.length} Products</span>
              </div>
              <div class="products-grid">
                ${categoryProducts.map(product => `
                  <div class="product-card">
                    <img src="${product.image}" alt="${product.name}" class="product-image" onerror="this.src='assets/images/placeholder.jpg'">
                    <div class="product-info">
                      <span class="product-category">${product.category}</span>
                      <h3>${product.name}</h3>
                      <p>${product.description ? product.description.substring(0, 100) + '...' : ''}</p>
                      <a href="product_details.html?name=${encodeURIComponent(product.name)}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                `).join('')}
              </div>
            </div>
          `;
        }
      });
      
      productsGrid.innerHTML = html;
    }
  } catch (error) {
    console.error('Error loading products:', error);
    const productsGrid = document.getElementById('products-grid');
    if (productsGrid) {
      productsGrid.innerHTML = `
        <div style="text-align: center; padding: 40px; grid-column: 1/-1; color: #dc3545;">
          <h3>Error Loading Products</h3>
          <p>Unable to load products. Please refresh the page.</p>
          <p style="font-size: 14px; color: #666;">${error.message}</p>
        </div>
      `;
    }
  }
}

// Load Product Details (for product_details.html)
async function loadProductDetails() {
  const urlParams = new URLSearchParams(window.location.search);
  const productName = urlParams.get('name');
  
  if (!productName) {
    window.location.href = 'products.html';
    return;
  }
  
  try {
    const response = await fetch('products.json');
    const products = await response.json();
    const product = products.find(p => p.name === productName);
    
    if (!product) {
      window.location.href = 'products.html';
      return;
    }
    
    document.getElementById('product-name').textContent = product.name;
    document.getElementById('product-category').textContent = product.category;
    document.getElementById('product-description').textContent = product.description || 'High-quality product designed for industrial applications.';
    document.getElementById('product-image').src = product.image;
    document.getElementById('product-image').onerror = function() {
      this.src = 'assets/images/placeholder.jpg';
    };
    
    // Build specifications
    const specsContainer = document.getElementById('product-specs');
    let specsHTML = '';
    
    if (product.dimension) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Dimension:</span>
          <span class="spec-value">${product.dimension}</span>
        </div>
      `;
    }
    
    if (product.size) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Size:</span>
          <span class="spec-value">${product.size}</span>
        </div>
      `;
    }
    
    if (product.sizes) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Available Sizes:</span>
          <span class="spec-value">${product.sizes}</span>
        </div>
      `;
    }
    
    if (product.thickness) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Thickness:</span>
          <span class="spec-value">${product.thickness}</span>
        </div>
      `;
    }
    
    if (product.finishing) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Finishing:</span>
          <span class="spec-value">${product.finishing}</span>
        </div>
      `;
    }
    
    if (product.application) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Application:</span>
          <span class="spec-value">${product.application}</span>
        </div>
      `;
    }
    
    if (product.brand) {
      specsHTML += `
        <div class="spec-item">
          <span class="spec-label">Brand:</span>
          <span class="spec-value">${product.brand}</span>
        </div>
      `;
    }
    
    specsContainer.innerHTML = specsHTML;
    
  } catch (error) {
    console.error('Error loading product details:', error);
    window.location.href = 'products.html';
  }
}

// Contact Form Submission
const contactForm = document.getElementById('contact-form');
if (contactForm) {
  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Thank you for your message! We will get back to you soon.');
    contactForm.reset();
  });
}

// Initialize page-specific functions
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('products-grid')) {
    loadProducts();
  }

  if (document.getElementById('product-detail')) {
    loadProductDetails();
  }
});

// Scroll animations
document.addEventListener('DOMContentLoaded', () => {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
      }
    });
  }, observerOptions);

  // Observe initially loaded elements
  document.querySelectorAll('.feature-card, .product-card').forEach(el => {
    observer.observe(el);
  });

  // Also observe after products load (with a small delay)
  setTimeout(() => {
    document.querySelectorAll('.feature-card, .product-card').forEach(el => {
      observer.observe(el);
    });
  }, 500);
});

