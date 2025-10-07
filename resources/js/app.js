import './bootstrap';

// Import UI libraries
import Swiper from 'swiper';
import { Fancybox } from '@fancyapps/ui';
import Masonry from 'masonry-layout';
import noUiSlider from 'nouislider';

// Import CSS for libraries
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import '@fancyapps/ui/dist/fancybox/fancybox.css';
import 'nouislider/dist/nouislider.css';

// Import our UI initializer
import './init';

// Make libraries globally available
window.Swiper = Swiper;
window.Fancybox = Fancybox;
window.Masonry = Masonry;
window.noUiSlider = noUiSlider;
