# Template Assets Mapping & CDN Dependencies

## 🌐 **External CDN Assets** (Located in template root)

Based on the directory structure, the template uses these external CDN services:

### **1. `cdn.jsdelivr.net`** - Modern JavaScript Libraries
```
├── @fancyapps/ui@5.0/dist/fancybox/
│   ├── fancybox.css
│   └── fancybox.umd.js
├── daterangepicker/
│   ├── daterangepicker.css
│   └── daterangepicker.min.js
├── masonry-layout@4/dist/
│   └── masonry.pkgd.min.js
├── swiper@11/
│   ├── swiper-bundle.min.css
│   └── swiper-bundle.min.js
└── momentjs/latest/
    └── moment.min.js
```

### **2. `cdnjs.cloudflare.com`** - Additional Libraries
```
└── ajax/libs/noUiSlider/15.8.1/
    ├── nouislider.min.css
    └── nouislider.min.js
```

### **3. `code.iconify.design`** - Icon System
```
└── 3/3.1.1/
    └── iconify.min.js
```

### **4. `code.jquery.com`** - jQuery Library
```
└── jquery-3.6.0.min.js
```

---

## 📦 **Laravel Implementation Strategy**

### **Option 1: NPM Installation (Recommended)**
Install these libraries via NPM for better control and bundling:

```bash
# Install via NPM
npm install swiper fancybox masonry-layout moment daterangepicker nouislider iconify

# Or install specific versions
npm install swiper@11 @fancyapps/ui@5.0 masonry-layout@4 moment daterangepicker nouislider@15.8.1
```

### **Option 2: CDN Integration**
Use Laravel's asset management to include CDN links:

```php
// In your Blade layout
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- External CDN Assets -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<!-- ... other CDN assets -->
```

### **Option 3: Hybrid Approach**
- **Critical libraries** (jQuery, Swiper, Fancybox) → NPM for bundling
- **Optional libraries** (Masonry, NoUiSlider) → CDN for faster loading

---

## 🎯 **Asset Migration Plan**

### **Step 1: Copy Local Assets**
```bash
# Copy images to Laravel public directory
cp -r template/html.physcode.com/travel/demo-main/assets/images/* public/assets/images/

# Copy CSS files for reference
cp template/html.physcode.com/travel/demo-main/assets/css/* resources/css/template/
```

### **Step 2: Install NPM Dependencies**
```bash
npm install swiper@11 @fancyapps/ui@5.0 masonry-layout@4 moment daterangepicker nouislider@15.8.1
```

### **Step 3: Update Vite Configuration**
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'swiper': 'swiper/bundle',
            'fancybox': '@fancyapps/ui/dist/fancybox',
        }
    }
});
```

### **Step 4: Import Libraries in JavaScript**
```javascript
// resources/js/app.js
import Swiper from 'swiper/bundle';
import { Fancybox } from '@fancyapps/ui';
import Masonry from 'masonry-layout';
import moment from 'moment';
import noUiSlider from 'nouislider';

// Initialize components
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    new Swiper('.swiper', {
        // Swiper options
    });
    
    // Initialize Fancybox
    Fancybox.bind('[data-fancybox]');
    
    // Initialize Masonry
    new Masonry('.grid', {
        // Masonry options
    });
});
```

---

## 🏗️ **Template Integration Steps**

### **1. Asset Structure Setup**
```
public/
├── assets/
│   ├── images/
│   │   ├── tours/           # Tour images
│   │   ├── blogs/           # Blog images  
│   │   ├── destinations/    # Destination images
│   │   ├── gallery/         # Gallery images
│   │   └── ui/              # UI elements (logos, icons)
│   ├── css/
│   │   ├── template/        # Template CSS files
│   │   └── custom/          # Custom overrides
│   └── js/
│       └── template/        # Template JS files
```

### **2. Blade Layout Integration**
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaData['title'] ?? config('app.name') }}</title>
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet">
    
    {{-- Iconify --}}
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
</head>
<body class="antialiased font-urbanist">
    {{-- Header --}}
    @include('partials.header')
    
    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('partials.footer')
    
    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>
```

### **3. Component Creation**
```blade
{{-- resources/views/components/tour-gallery.blade.php --}}
<div class="tour-gallery">
    @foreach($tour->getMedia('gallery') as $image)
        <a data-fancybox="gallery" href="{{ $image->getUrl() }}">
            <img src="{{ $image->getUrl('thumb') }}" alt="{{ $image->alt }}" loading="lazy">
        </a>
    @endforeach
</div>
```

---

## 🔧 **Laravel-Specific Optimizations**

### **1. Spatie Media Integration**
```php
// Tour model
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tour extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile(false);
            
        $this->addMediaCollection('featured')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile(true);
    }
}
```

### **2. Dynamic Asset URLs**
```blade
{{-- Use Laravel's asset() helper for CDN assets --}}
<script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
<link href="{{ asset('vendor/fancybox/fancybox.css') }}" rel="stylesheet">

{{-- Or use Laravel's mix() for versioned assets --}}
<script src="{{ mix('js/app.js') }}"></script>
<link href="{{ mix('css/app.css') }}" rel="stylesheet">
```

### **3. Environment-Based Asset Loading**
```blade
{{-- Use different assets for development vs production --}}
@if(app()->environment('local'))
    {{-- Development: Use local CDN copies --}}
    <script src="{{ asset('js/swiper.min.js') }}"></script>
@else
    {{-- Production: Use actual CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endif
```

---

## 📋 **Implementation Checklist**

### **Phase 1: Asset Setup**
- [ ] Copy template images to `public/assets/images/`
- [ ] Install NPM dependencies for JavaScript libraries
- [ ] Configure Vite for asset bundling
- [ ] Set up Spatie Media Library for image management

### **Phase 2: Layout Conversion**
- [ ] Create main Blade layout (`layouts/app.blade.php`)
- [ ] Convert header to Blade partial (`partials/header.blade.php`)
- [ ] Convert footer to Blade partial (`partials/footer.blade.php`)
- [ ] Create navigation component (`components/navigation.blade.php`)

### **Phase 3: Component Creation**
- [ ] Tour gallery component with Fancybox
- [ ] Image slider component with Swiper
- [ ] Filter components with NoUiSlider
- [ ] Masonry grid component for galleries
- [ ] Date picker component with Daterangepicker

### **Phase 4: Page Implementation**
- [ ] Tour detail page with all sections
- [ ] Blog detail page layout
- [ ] Homepage with hero slider
- [ ] Listing pages with filters and pagination

---

## 🚀 **Ready to Implement!**

The template analysis is complete. We now have:

1. ✅ **Complete asset mapping** - All images, CSS, and JS identified
2. ✅ **CDN dependencies** - External libraries mapped and integration strategy
3. ✅ **Dynamic data points** - All content areas identified for Laravel integration
4. ✅ **Implementation plan** - Step-by-step conversion strategy

**Next step**: Choose whether to start with asset migration or page implementation!
