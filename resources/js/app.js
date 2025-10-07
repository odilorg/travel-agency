import './bootstrap';

// Note: All vendor libraries (Swiper, Fancybox, Masonry, NoUiSlider, jQuery, Moment, Daterangepicker)
// are now loaded via CDN in app.blade.php HEAD section to match the original template exactly.
// This ensures proper initialization order and compatibility with template's main.min83a7.js

// Template's main.min83a7.js handles all initialization of:
// - Swiper sliders
// - Fancybox galleries
// - Masonry layouts
// - Daterangepicker
// - Accordions
// - Mobile menu
// - Copy buttons
// - And other UI interactions

// init.js is disabled as template's main.min83a7.js handles all UI initialization
// If you need custom initializations, add them here after template init completes

// This file is now reserved for custom application code that extends the template functionality
// Add any custom JavaScript below:

// Example: Custom app initialization (if needed)
document.addEventListener('DOMContentLoaded', () => {
  console.log('Travel app loaded successfully');
  
  // Add any custom initializations here that don't conflict with template
  // Example:
  // initCustomFeature();
});
