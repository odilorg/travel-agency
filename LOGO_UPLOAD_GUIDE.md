# 🖼️ Logo & Image Upload Guide

## ✅ Image Upload Feature Added!

The logo fields now support **direct image uploads** instead of URL inputs.

---

## 📸 Uploadable Images

### 1. **Brand Logo (Header)**
- **Location**: General Tab → Brand & Identity section
- **Field**: Brand Logo (Header)
- **Used in**: Header on all pages
- **Recommended size**: 200x60px
- **Max file size**: 2MB
- **Storage path**: `storage/app/public/logos/`
- **Fallback**: `public/assets/images/logo.png`

### 2. **Brand Logo (Footer)**
- **Location**: General Tab → Brand & Identity section  
- **Field**: Brand Logo (Footer)
- **Used in**: Footer on all pages
- **Recommended size**: 200x60px
- **Max file size**: 2MB
- **Storage path**: `storage/app/public/logos/`
- **Fallback**: `public/assets/images/logo-footer.png`

### 3. **Payment Badge Image**
- **Location**: Footer Tab → Footer Content section
- **Field**: Payment Badge Image
- **Used in**: Footer (payment methods section)
- **Recommended size**: Varies (usually 300x65px)
- **Max file size**: 2MB
- **Storage path**: `storage/app/public/badges/`
- **Fallback**: Hidden if not uploaded

---

## 🎨 Built-in Image Editor

All image upload fields include a **built-in image editor** with:
- ✅ Crop tool
- ✅ Rotate
- ✅ Flip
- ✅ Aspect ratio presets (16:9, 4:3, 1:1, free)
- ✅ Real-time preview

---

## 📤 How to Upload Images

### Method 1: Drag & Drop
1. Go to **Admin → Site Settings**
2. Navigate to **General** tab
3. **Drag and drop** your logo image onto the upload area
4. Use the image editor if needed
5. Click **Save**

### Method 2: Click to Upload
1. Go to **Admin → Site Settings**
2. Navigate to **General** tab
3. Click the **upload area**
4. Select your image file from your computer
5. Use the image editor if needed
6. Click **Save**

---

## 🔧 Image Editor Usage

When you upload an image:

1. **Crop Tool** appears automatically
2. **Choose aspect ratio**:
   - Free - No constraints
   - 16:9 - Wide banner style
   - 4:3 - Standard ratio
   - 1:1 - Square
3. **Drag to crop** the image
4. **Click Apply** when done
5. **Click Save** in the form

---

## 📂 File Storage Structure

```
storage/app/public/
├── logos/              # Brand logos
│   ├── header-logo.png
│   └── footer-logo.png
└── badges/             # Payment badges
    └── payment-methods.png
```

**Public URL structure:**
```
https://yoursite.com/storage/logos/header-logo.png
https://yoursite.com/storage/badges/payment-methods.png
```

---

## ✨ Features

### Automatic Processing
- ✅ **Optimized storage** - Images saved to public disk
- ✅ **Auto-generated URLs** - Accessible via web
- ✅ **Fallback images** - Uses default if not uploaded
- ✅ **Validation** - Only images accepted (jpg, png, gif, svg, webp)
- ✅ **Size limit** - Max 2MB per image

### Smart Display
- ✅ **Dynamic alt text** - Uses site name for accessibility
- ✅ **Responsive** - Images scale on mobile
- ✅ **Lazy loading** - Improves page speed
- ✅ **Fallback support** - Shows default if upload missing

---

## 🔍 Where Logos Are Displayed

### Header Logo (`brand_logo_path`)
- ✅ Top navigation bar (all pages)
- ✅ Mobile menu
- ✅ Height: 40px (auto-width)

### Footer Logo (`brand_logo_footer_url`)
- ✅ Footer brand section (all pages)
- ✅ Height: 50px (auto-width)

### Payment Badge (`footer_payment_badge_url`)
- ✅ Footer payment section (all pages)
- ✅ Only shows if uploaded
- ✅ Height: 65px (auto-width)

---

## 🚨 Troubleshooting

### Images not showing?

**1. Check storage link exists:**
```bash
php artisan storage:link
```

**2. Verify file permissions:**
```bash
# Windows - Run as Administrator
icacls storage /grant Users:F /T

# Linux/Mac
chmod -R 775 storage
chmod -R 775 public/storage
```

**3. Check .env configuration:**
```env
FILESYSTEM_DISK=public
```

**4. Clear cache:**
```bash
php artisan cache:clear
php artisan view:clear
```

### Upload failing?

**1. Check upload limits** in `php.ini`:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

**2. Check file size** - Max 2MB per image

**3. Check file type** - Must be image (jpg, png, gif, svg, webp)

---

## 🎯 Best Practices

### Logo Images
- ✅ **Use PNG** for transparency
- ✅ **Optimize before upload** - Use tools like TinyPNG
- ✅ **Use consistent branding** - Same colors, style
- ✅ **Test on dark backgrounds** - Especially footer logo
- ✅ **Keep file sizes small** - Under 200KB ideal

### Payment Badges
- ✅ **Show all accepted methods** - Visa, Mastercard, etc.
- ✅ **Use official logos** - Get from payment providers
- ✅ **Transparent background** - Better on dark footer
- ✅ **Horizontal layout** - Works best in footer

---

## 📝 Admin Workflow

1. **Login to Admin**: `http://127.0.0.1:8000/admin`
2. **Go to Site Settings**: Click "Site Settings" in Settings group
3. **General Tab**: Upload header & footer logos
4. **Footer Tab**: Upload payment badge (optional)
5. **Click Save**: All changes saved to database
6. **View Site**: Logos appear immediately on frontend

---

## 🔗 Related Files

**Filament Resource:**
- `app/Filament/Resources/SiteSettingResource.php`

**View Files:**
- `resources/views/partials/header.blade.php` - Header logo
- `resources/views/partials/footer.blade.php` - Footer logo & payment badge

**Model:**
- `app/Models/SiteSetting.php`

**Storage Config:**
- `config/filesystems.php` - Public disk configuration

---

## 💡 Pro Tips

1. **Test logos on both light and dark backgrounds**
2. **Use SVG for crisp scaling** (if supported)
3. **Keep originals** - Store source files separately
4. **Update seasonally** - Holiday logos, special events
5. **A/B test** - Try different logo styles

---

## ✅ Summary

**Before**: Text input for logo URLs  
**After**: Direct image upload with editor

**Benefits:**
- ✨ No need to host images elsewhere
- ✨ Built-in image editing
- ✨ Automatic optimization
- ✨ Easy to manage
- ✨ Better UX

**Storage:** `storage/app/public/logos/` and `storage/app/public/badges/`  
**Public URL:** `https://yoursite.com/storage/logos/your-logo.png`

---

**Ready to upload your logos? Go to Admin → Site Settings → General Tab!** 🚀

