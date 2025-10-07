/**
 * UI Initializer - Centralized component initialization
 * Handles Swiper, Fancybox, Masonry, and other UI components
 */
class UIInitializer {
  static init() {
    try {
      this.initSwiper();
      this.initFancybox();
      this.initMasonry();
      this.initSliders();
      console.log('UI Initialization completed successfully');
    } catch (error) {
      console.warn('UI Initialization error:', error);
    }
  }

  static initSwiper() {
    if (window.Swiper && document.querySelector('.swiper')) {
      try {
        new Swiper('.swiper', {
          // Basic Swiper configuration
          loop: true,
          autoplay: {
            delay: 5000,
            disableOnInteraction: false,
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
          on: {
            init: function() {
              console.log('Swiper initialized successfully');
            }
          }
        });
      } catch (error) {
        console.warn('Swiper initialization failed:', error);
      }
    }
  }

  static initFancybox() {
    if (window.Fancybox) {
      try {
        Fancybox.bind('[data-fancybox]', {
          // Fancybox configuration
          Toolbar: {
            display: {
              left: ["infobar"],
              middle: [],
              right: ["slideshow", "download", "thumbs", "close"],
            },
          },
          Thumbs: {
            autoStart: false,
          },
        });
        console.log('Fancybox initialized successfully');
      } catch (error) {
        console.warn('Fancybox initialization failed:', error);
      }
    }
  }

  static initMasonry() {
    if (window.Masonry && document.querySelector('.masonry')) {
      try {
        new Masonry('.masonry', {
          itemSelector: '.masonry-item',
          columnWidth: '.masonry-sizer',
          percentPosition: true,
          gutter: 20
        });
        console.log('Masonry initialized successfully');
      } catch (error) {
        console.warn('Masonry initialization failed:', error);
      }
    }
  }

  static initSliders() {
    if (window.noUiSlider) {
      try {
        // Initialize price range slider if present
        const priceSlider = document.getElementById('price-range');
        if (priceSlider) {
          noUiSlider.create(priceSlider, {
            start: [20, 80],
            connect: true,
            range: {
              'min': 0,
              'max': 100
            }
          });
        }

        // Initialize duration slider if present
        const durationSlider = document.getElementById('duration-range');
        if (durationSlider) {
          noUiSlider.create(durationSlider, {
            start: [1, 14],
            connect: true,
            range: {
              'min': 1,
              'max': 30
            }
          });
        }
        console.log('Sliders initialized successfully');
      } catch (error) {
        console.warn('Slider initialization failed:', error);
      }
    }
  }

  /**
   * Re-initialize components in a specific root element
   * Useful for AJAX/HTMX content updates
   */
  static reinit(root = document) {
    try {
      // Re-initialize components within the root
      if (root.querySelector('.swiper')) {
        this.initSwiper();
      }
      if (root.querySelector('[data-fancybox]')) {
        this.initFancybox();
      }
      if (root.querySelector('.masonry')) {
        this.initMasonry();
      }
      console.log('UI Re-initialization completed for root:', root);
    } catch (error) {
      console.warn('UI Re-initialization error:', error);
    }
  }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  UIInitializer.init();
});

// Re-initialize on HTMX content swap (if using HTMX)
document.addEventListener('htmx:afterSwap', (e) => {
  UIInitializer.reinit(e.target);
});

// Export for use in other modules
window.UIInitializer = UIInitializer;
