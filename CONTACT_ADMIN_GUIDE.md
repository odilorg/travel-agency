# 📋 Contact Page Management Guide - Admin Backend

## How to Manage Contact Page Settings

### Step 1: Access Filament Admin Panel

1. Navigate to: `http://127.0.0.1:8000/admin`
2. Login with your admin credentials
3. Look for **"Site Settings"** in the left sidebar under the **"Settings"** group

**Direct URL:** `http://127.0.0.1:8000/admin/site-settings`

---

## 🎛️ Site Settings Interface

The Site Settings page uses a **tabbed interface** with 7 organized sections:

### 📑 Tab 1: General
**What you can configure:**
- ✅ **Site Name** - Your website/company name
- ✅ **Company Name** - Legal/formal company name
- ✅ **Brand Logo (Header)** - URL to your header logo
- ✅ **Brand Logo (Footer)** - URL to your footer logo
- ✅ **Default Locale** - Language code (e.g., 'en')
- ✅ **Main Language** - Primary language setting
- ✅ **Default Currency** - Currency code (e.g., 'USD', 'EUR')
- ✅ **Show Currency Selector** - Toggle currency dropdown in header
- ✅ **Show Language Selector** - Toggle language dropdown in header

---

### 📞 Tab 2: Contact
**What you can configure:**
- ✅ **Contact Email** - Primary contact email *(required)*
- ✅ **Contact Phone** - Phone number with country code
- ✅ **Address Line** - Street address
- ✅ **City** - City name
- ✅ **Country** - Country name
- ✅ **Contact Blurb** - Description text shown on contact page

**Where it appears:**
- Contact page - Company info section
- Footer (if configured)
- Email signatures

---

### 🌐 Tab 3: Social Media
**What you can configure:**
- ✅ **Facebook URL** - Full URL to your Facebook page
- ✅ **Instagram URL** - Full URL to your Instagram
- ✅ **X (Twitter) URL** - Full URL to your X/Twitter
- ✅ **YouTube URL** - Full URL to your YouTube channel
- ✅ **Show in Header** - Toggle to display social icons in header
- ✅ **Show in Footer** - Toggle to display social icons in footer

**Where it appears:**
- Contact page - Company info section (with hover effects)
- Header (if enabled)
- Footer (if enabled)

---

### 📄 Tab 4: Footer
**What you can configure:**
- ✅ **Copyright Text** - Footer copyright message
  - Example: `Copyright © 2025 Travel WP. All Rights Reserved.`
- ✅ **Payment Badge Image** - URL to payment methods image
  - Example: Credit card logos, payment provider badges

**Top Destinations** (Repeater field):
- Click **"Add Destination"** to add entries
- Each entry has:
  - **Label** - Destination name (e.g., "Tokyo")
  - **URL** - Link to destination page

**Information Links** (Repeater field):
- Click **"Add Link"** to add entries
- Each entry has:
  - **Label** - Link text (e.g., "Privacy Policy", "Terms")
  - **URL** - Link destination

**Where it appears:**
- Footer section of all pages

---

### 🗺️ Tab 5: Map
**What you can configure:**
- ✅ **Map iframe src** - Google Maps embed URL

**How to get the iframe URL:**
1. Go to [Google Maps](https://maps.google.com)
2. Search for your location
3. Click **"Share"**
4. Select **"Embed a map"** tab
5. Copy the URL from `src="..."` attribute
6. Paste here

**Example:**
```
https://maps.google.com/maps?q=new%20york&t=m&z=10&output=embed&iwloc=near
```

**Where it appears:**
- Contact page - Map section (left side of company info)

---

### ✉️ Tab 6: Contact Form
**What you can configure:**

**Email Recipients:**
- ✅ **Send To Email** - Primary recipient for contact form submissions
  - Falls back to Contact Email if not set
- ✅ **CC Email** - Carbon copy recipient (optional)
- ✅ **BCC Email** - Blind carbon copy recipient (optional)

**Auto-Reply Settings:**
- ✅ **Enable Auto-Reply** - Toggle to send automatic reply to customers
- ✅ **Auto-Reply Subject** - Email subject line
  - Example: `Thank you for contacting us`
- ✅ **Auto-Reply Body** - Email message content
  - Example: `Thank you for reaching out to us. We have received your message and will get back to you shortly.`

**How it works:**
1. Customer fills contact form
2. Submission saved to database
3. Email sent to admin (To, CC, BCC)
4. If auto-reply enabled → customer receives confirmation email
5. All emails are queued for async sending

---

### 🔒 Tab 7: SEO & Security
**What you can configure:**

**Default Meta Tags** (Key-Value pairs):
- Add custom meta tags for SEO
- Example:
  - Key: `og:title` → Value: `Best Travel Agency`
  - Key: `description` → Value: `Your travel description`

**reCAPTCHA** (for future spam protection):
- ✅ **reCAPTCHA Site Key** - Google reCAPTCHA v2/v3 site key
- ✅ **reCAPTCHA Secret Key** - Google reCAPTCHA secret key

---

## 💾 How to Save Settings

1. Fill in the fields in each tab
2. Click **"Save"** button at the top-right
3. Settings are saved immediately
4. Cache is automatically cleared

**Note:** This is a **singleton resource** - there's only ONE settings record, not multiple.

---

## 📧 Viewing Contact Form Submissions

### Current Setup
Contact form submissions are currently:
- ✅ Saved to `contact_submissions` database table
- ✅ Sent via email to configured recipients
- ✅ Logged with metadata (IP, user agent, timestamp)

### To View Submissions in Admin (Optional Enhancement)

You can create a Filament resource to view submissions:

```bash
php artisan make:filament-resource ContactSubmission
```

This would create an admin interface to:
- View all contact form submissions
- Search and filter submissions
- Mark as read/responded
- Delete spam

**Would you like me to create this resource for you?**

---

## 🎯 Quick Setup Checklist

### Minimum Required Settings:
- [ ] **General Tab**: Set Site Name
- [ ] **Contact Tab**: Set Contact Email *(required for form to work)*
- [ ] **Contact Form Tab**: Configure "Send To Email" or leave empty to use Contact Email

### Recommended Settings:
- [ ] **General Tab**: Add Company Name and Logo URLs
- [ ] **Contact Tab**: Fill phone, address, blurb
- [ ] **Social Media Tab**: Add social media URLs
- [ ] **Map Tab**: Add Google Maps embed URL
- [ ] **Contact Form Tab**: Enable auto-reply with custom message
- [ ] **Footer Tab**: Add copyright text and links

### Optional Settings:
- [ ] **Footer Tab**: Add payment badges and destination links
- [ ] **SEO Tab**: Add custom meta tags
- [ ] **SEO Tab**: Configure reCAPTCHA (for future use)

---

## 🧪 Testing Your Contact Form

### Step 1: Configure Settings
1. Go to **Admin → Site Settings → Contact Form tab**
2. Set "Send To Email" to your test email
3. Enable "Auto-Reply" (optional)
4. Click **"Save"**

### Step 2: Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
```

### Step 3: Test the Form
1. Visit: `http://127.0.0.1:8000/contact`
2. Fill out the form:
   - Name: Test User
   - Email: your-email@example.com
   - Message: This is a test message
3. Click **"Send"**

### Step 4: Verify
- ✅ Success message appears
- ✅ Check your email (admin notification)
- ✅ Check customer email (auto-reply if enabled)
- ✅ Check database: `SELECT * FROM contact_submissions ORDER BY id DESC LIMIT 1;`

---

## 🔧 Troubleshooting

### Form not sending emails?
1. **Check mail configuration** in `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=your-smtp-host
   MAIL_PORT=587
   MAIL_USERNAME=your-email
   MAIL_PASSWORD=your-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@example.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

2. **Test email configuration**:
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('your-email@example.com')->subject('Test');
   });
   ```

3. **Check queue is running** (emails are queued):
   ```bash
   php artisan queue:work
   ```
   Or configure `QUEUE_CONNECTION=sync` in `.env` for immediate sending

### Settings not updating on frontend?
```bash
php artisan cache:clear
php artisan view:clear
```

### Auto-reply not working?
1. Check **"Enable Auto-Reply"** toggle is ON
2. Verify **"Auto-Reply Subject"** and **"Body"** are filled
3. Check queue is running: `php artisan queue:work`

---

## 📊 Database Tables

### `site_settings`
- Stores all configuration (single record, ID = 1)
- 41 columns for all settings
- Updated via Filament admin

### `contact_submissions`
- Stores all contact form submissions
- Columns: `id`, `name`, `email`, `message`, `meta`, `created_at`
- `meta` contains: IP address, user agent, timestamp

---

## 🚀 Advanced: Add Submission Viewer

Want to view submissions in admin? Run these commands:

```bash
# Create Filament Resource for Contact Submissions
php artisan make:filament-resource ContactSubmission --generate

# This will create:
# - ContactSubmissionResource.php
# - List/Create/Edit/View pages
```

Then you'll have a full admin interface to manage submissions!

---

## 📝 Summary

**To manage your contact page:**

1. **Admin Panel**: `http://127.0.0.1:8000/admin`
2. **Click**: Site Settings (in Settings group)
3. **Configure**: All 7 tabs as needed
4. **Save**: Click Save button
5. **Test**: Visit `/contact` page

**Admin URL:** `http://127.0.0.1:8000/admin/site-settings`

All contact page content is dynamically loaded from these settings - no code changes needed! 🎉

