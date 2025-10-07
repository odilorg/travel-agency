# Tour Detail Page - Responsive Layout Complete ✅

## Breakpoint Strategy

Using Tailwind's `lg:` breakpoint (1024px) to match the original template.

## Layout Behavior

### Mobile (< 1024px width)
- **Gallery**: All images stacked vertically (full width)
  - Large image: full width
  - Side images: 2 columns side by side (grid-cols-2)
- **Content**: Full width, stacked
- **Booking Form**: Full width at bottom

### Desktop (≥ 1024px width)
- **Gallery**: 8/4 split
  - Large image: LEFT (8 columns)
  - Side images: RIGHT (4 columns, stacked vertically)
- **Content**: 8/4 split
  - Main content: LEFT (8 columns)
  - Booking form: RIGHT (4 columns, sticky sidebar)

## Classes Used

### Header
```html
<div class="col-span-12 lg:col-span-8">...</div>  <!-- Title -->
<div class="col-span-12 lg:col-span-4">...</div>  <!-- Share -->
```

### Gallery
```html
<div class="col-span-12 lg:col-span-8">...</div>  <!-- Large image -->
<div class="col-span-12 grid grid-cols-2 lg:col-span-4 lg:flex lg:flex-col gap-4">
  <!-- Side images: 2 cols on mobile, stacked on desktop -->
</div>
```

### Main Content
```html
<div class="col-span-12 lg:col-span-8">...</div>  <!-- Main content -->
<div class="col-span-12 lg:col-span-4">...</div>  <!-- Booking sidebar -->
```

## Tailwind Breakpoints Reference

| Breakpoint | Min Width | Usage |
|------------|-----------|-------|
| `sm:` | 640px | Small devices |
| `md:` | 768px | Tablets |
| `lg:` | **1024px** | **← WE USE THIS** |
| `xl:` | 1280px | Large desktops |
| `2xl:` | 1536px | Extra large |

## Testing

**Mobile View** (< 1024px):
- Resize browser to less than 1024px width
- All content stacks vertically
- Gallery shows 1 large + 2 small side-by-side
- Booking form at bottom

**Desktop View** (≥ 1024px):
- Widen browser to 1024px or more
- Gallery: 1 large (left) + 2 small (right, stacked)
- Booking form: Right sidebar
- Content: Left main area

## URL
http://127.0.0.1:8000/tours/reprehenderit-tempor
