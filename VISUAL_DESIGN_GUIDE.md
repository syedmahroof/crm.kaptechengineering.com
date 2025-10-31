# 🎨 Visual Design Guide - Perfect Alignment & Icons

## 📐 Layout & Alignment Standards

### Page Structure
```
┌─────────────────────────────────────────────────────┐
│  Header with Title & Subtitle                      │
│  ------------------------------------------------   │
│  Filters Card (4 columns grid)                     │
│  ------------------------------------------------   │
│  DataTable Card                                     │
│    ├─ Show entries (left)                          │
│    ├─ Search box (right)                           │
│    ├─ Export buttons (center)                      │
│    ├─ Table with data                              │
│    └─ Pagination (center-right)                    │
└─────────────────────────────────────────────────────┘
```

### Grid System
- **Container**: `content-wrapper` with 32px padding
- **Cards**: 24px bottom margin
- **Card Body**: 28px padding
- **Grid Gaps**: `g-3` (1rem / 16px)
- **Button Gaps**: 8px between elements

### Spacing Scale
```
4px  - Tiny gaps (icon-text)
8px  - Small gaps (button groups)
12px - Medium gaps (form elements)
16px - Large gaps (sections)
24px - XL gaps (cards)
32px - XXL gaps (page sections)
```

## 🎯 Component Alignment

### Buttons
```html
<!-- Primary Action -->
<a href="#" class="btn btn-primary">
    <i class="bi bi-plus-circle me-2"></i>Add New Lead
</a>

<!-- Button Group (Actions) -->
<div class="d-flex justify-content-center gap-1">
    <a class="btn btn-sm btn-outline-primary">
        <i class="bi bi-eye-fill"></i>
    </a>
    <a class="btn btn-sm btn-outline-warning">
        <i class="bi bi-pencil-fill"></i>
    </a>
    <button class="btn btn-sm btn-outline-danger">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>
```

### Form Fields
```html
<!-- With Icon Label -->
<div class="col-md-3">
    <label class="form-label small fw-semibold text-muted mb-1">
        <i class="bi bi-tag-fill me-1"></i>Lead Type
    </label>
    <select class="form-select form-select-sm">
        <option value="">All Types</option>
    </select>
</div>
```

### Badges
```html
<!-- Status Badge -->
<span class="badge rounded-pill px-3 py-2" 
      style="background-color: #10b981; color: white;">
    <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>
    Qualified
</span>

<!-- Lead Type Badge -->
<span class="badge bg-gradient" 
      style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
             color: white; padding: 6px 12px;">
    <i class="bi bi-fire me-1"></i>Hot Lead
</span>
```

## 🎨 Icon Library Reference

### Action Icons
```
bi-eye-fill          - View/Show
bi-pencil-fill       - Edit
bi-trash-fill        - Delete
bi-plus-circle       - Add/Create
bi-save              - Save
bi-x-circle          - Cancel/Close
bi-arrow-left        - Back
bi-arrow-right       - Forward
bi-download          - Download
bi-upload            - Upload
```

### Data Icons
```
bi-person-fill       - User/Person
bi-envelope-fill     - Email
bi-telephone-fill    - Phone
bi-building-fill     - Building/Branch
bi-box-seam-fill     - Product
bi-calendar-fill     - Date
bi-flag-fill         - Status
bi-tag-fill          - Category/Type
bi-funnel-fill       - Filter/Source
bi-hash              - ID/Number
```

### Status Icons
```
bi-check-circle-fill - Success/Qualified
bi-x-circle-fill     - Error/Unqualified
bi-exclamation-circle - Warning
bi-info-circle       - Information
bi-fire              - Hot
bi-sun-fill          - Warm
bi-snow              - Cold
bi-star-fill         - New/Featured
bi-person-check      - Referral
bi-arrow-repeat      - Returning
```

### Navigation Icons
```
bi-grid-fill         - Dashboard
bi-graph-up          - Analytics
bi-people-fill       - Leads
bi-calendar-check    - Follow-ups
bi-calendar-event    - Calendar
bi-box-seam          - Products
bi-building          - Branches
bi-gear-fill         - Settings
bi-shield-fill       - Security
```

## 🎨 Color Coding System

### Lead Type Colors
```css
/* Hot Lead */
background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);

/* Warm Lead */
background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);

/* Cold Lead */
background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);

/* Qualified */
background: linear-gradient(135deg, #10b981 0%, #059669 100%);

/* Unqualified */
background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);

/* Default/Other */
background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
```

### Status Colors
```css
New:            #17a2b8  (Cyan)
Contacted:      #007bff  (Blue)
Qualified:      #6f42c1  (Purple)
Follow-Up:      #ffc107  (Yellow)
Proposal Sent:  #fd7e14  (Orange)
Negotiation:    #e83e8c  (Pink)
Won:            #28a745  (Green)
Lost:           #dc3545  (Red)
On Hold:        #6c757d  (Gray)
```

### Button States
```css
/* Primary */
.btn-primary {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
}

/* Outline */
.btn-outline-primary {
    border: 2px solid #6366f1;
    color: #6366f1;
}

.btn-outline-primary:hover {
    background: #6366f1;
    color: white;
}
```

## 📊 Table Design Standards

### Header Styling
```css
thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.8px;
    padding: 16px 20px;
    white-space: nowrap;
}
```

### Row Styling
```css
tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

tbody tr:hover {
    background: #f8fafc;
}
```

### Cell Content Alignment
- **Text**: Left-aligned
- **Numbers**: Right-aligned
- **Dates**: Left-aligned
- **Actions**: Center-aligned
- **Icons**: Centered in cell
- **Badges**: Inline with text

## 🎯 Form Design Standards

### Input Fields
```css
.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 500;
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}
```

### Labels
```css
.form-label {
    font-weight: 600;
    font-size: 14px;
    color: #334155;
    margin-bottom: 8px;
}
```

### Validation States
```html
<!-- Success -->
<input class="form-control is-valid">
<div class="valid-feedback">Looks good!</div>

<!-- Error -->
<input class="form-control is-invalid">
<div class="invalid-feedback">Please provide a valid value.</div>
```

## 📐 Card Design Standards

### Standard Card
```html
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0 fw-bold">Card Title</h5>
    </div>
    <div class="card-body">
        <!-- Content -->
    </div>
</div>
```

### Stat Card
```html
<div class="stat-card">
    <div class="stat-card-inline">
        <div class="stat-icon" style="background: linear-gradient(...);">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Leads</div>
            <div class="stat-value">100</div>
        </div>
    </div>
</div>
```

## 🎨 Typography Scale

### Headings
```css
.page-title {
    font-size: 26px;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.5px;
}

.page-subtitle {
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
}

.card-header h5 {
    font-size: 18px;
    font-weight: 700;
}
```

### Body Text
```css
body {
    font-size: 14px;
    font-weight: 400;
    line-height: 1.5;
    color: #334155;
}

small {
    font-size: 12px;
}

.text-muted {
    color: #64748b;
}
```

## 🎨 Shadow System

### Elevation Levels
```css
/* Level 1 - Subtle */
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);

/* Level 2 - Cards */
box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);

/* Level 3 - Hover */
box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);

/* Level 4 - Dropdown */
box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);

/* Button Shadow */
box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
```

## 🎯 Border Radius System

```css
/* Small - Badges */
border-radius: 6px;

/* Medium - Buttons */
border-radius: 8px;

/* Large - Inputs */
border-radius: 10px;

/* XL - Cards */
border-radius: 14px;

/* Circle - Icons/Avatars */
border-radius: 50%;

/* Pills - Status Badges */
border-radius: 50px;
```

## 🎨 Hover Effects

### Buttons
```css
transition: all 0.2s;

/* On Hover */
transform: translateY(-2px);
box-shadow: 0 8px 20px rgba(...);
```

### Table Rows
```css
tbody tr {
    transition: all 0.2s;
}

tbody tr:hover {
    background: #f8fafc;
}
```

### Cards
```css
.card {
    transition: all 0.2s;
}

.card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
}
```

## 📱 Responsive Breakpoints

```css
/* Mobile First */
@media (min-width: 576px) {  /* sm */ }
@media (min-width: 768px) {  /* md */ }
@media (min-width: 992px) {  /* lg */ }
@media (min-width: 1200px) { /* xl */ }
@media (min-width: 1400px) { /* xxl */ }
```

## ✨ Animation Timing

```css
/* Fast - Button hover */
transition: all 0.2s;

/* Medium - Card hover */
transition: all 0.3s;

/* Smooth - Dropdown open */
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
```

## 🎯 Z-Index Scale

```css
Sidebar:      1000
Dropdown:     1050
Modal:        1060
Tooltip:      1070
Toast:        1080
```

## 📝 Best Practices Checklist

### Alignment
- [ ] All elements aligned to grid
- [ ] Consistent spacing between elements
- [ ] Buttons centered in groups
- [ ] Icons aligned with text baseline
- [ ] Proper vertical rhythm

### Icons
- [ ] Consistent icon set (Bootstrap Icons)
- [ ] Appropriate size (16-18px for text, 20-24px for buttons)
- [ ] Proper spacing from text (me-1, me-2)
- [ ] Semantic icon choice
- [ ] Color matches context

### Colors
- [ ] High contrast for readability
- [ ] Consistent color usage
- [ ] Proper hover states
- [ ] Accessible combinations
- [ ] Brand consistency

### Typography
- [ ] Clear hierarchy
- [ ] Readable sizes
- [ ] Proper weights
- [ ] Consistent line heights
- [ ] Appropriate letter spacing

### Spacing
- [ ] Consistent padding
- [ ] Proper margins
- [ ] Grid-based layout
- [ ] Breathing room
- [ ] No cramped elements

---

**This guide ensures perfect alignment and beautiful design across all pages!** 🎨✨

