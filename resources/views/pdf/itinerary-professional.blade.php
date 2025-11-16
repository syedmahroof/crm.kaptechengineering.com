<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $itinerary->name }} - Good Vacations</title>
    <style>
        @font-face {
            font-family: 'Gibson Semibold';
            src: url('{{ public_path('assets/fonts/gibson_semibold-webfont.woff2') }}') format('woff2'),
                 url('{{ public_path('assets/fonts/gibson_semibold-webfont.woff') }}') format('woff');
            font-weight: 600;
            font-style: normal;
        }
        
        @font-face {
            font-family: 'Gibson Book';
            src: url('{{ public_path('assets/fonts/gibson_book-webfont.woff2') }}') format('woff2'),
                 url('{{ public_path('assets/fonts/gibson_book-webfont.woff') }}') format('woff');
            font-weight: 400;
            font-style: normal;
        }
        
        @font-face {
            font-family: 'Gibson Light';
            src: url('{{ public_path('assets/fonts/gibson_light-webfont.woff2') }}') format('woff2'),
                 url('{{ public_path('assets/fonts/gibson_light-webfont.woff') }}') format('woff');
            font-weight: 300;
            font-style: normal;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Gibson Book', 'Gibson Semibold', 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            line-height: 1.7;
            color: #2d3748;
            background: #ffffff;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }
        
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0;
            background: #ffffff;
            padding: 0;
        }
        
        /* Premium Header */
        .header {
            background: #67469C;
            color: white;
            padding: 20mm 18mm;
        }
        
        .header-accent {
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            margin-top: 2mm;
        }
        
        .header-content {
        }
        
        .company-header {
            margin-bottom: 14mm;
            padding-bottom: 10mm;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .logo-container {
        }
        
        .logo-box {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 12px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 10px;
            text-align: center;
        }
        
        .logo-container > div:last-child {
            display: inline-block;
            vertical-align: middle;
        }
        
        .logo-box img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
        
        .company-name {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 22pt;
            font-weight: 600;
            color: white;
            letter-spacing: -0.3px;
            margin: 0 0 2px 0;
        }
        
        .company-tagline {
            font-family: 'Gibson Light', 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            opacity: 0.9;
            font-weight: 300;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 0;
        }
        
        .itinerary-header {
            margin-top: 8mm;
        }
        
        .itinerary-name {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 32pt;
            font-weight: 600;
            color: white;
            margin: 0 0 6mm 0;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }
        
        .itinerary-tagline {
            font-family: 'Gibson Light', 'DejaVu Sans', sans-serif;
            font-size: 13pt;
            font-weight: 300;
            opacity: 0.95;
            margin: 0 0 8mm 0;
            letter-spacing: 0.2px;
        }
        
        .itinerary-meta {
            margin-top: 10mm;
        }
        
        .meta-item {
            display: inline-block;
            margin-right: 12mm;
            font-size: 9.5pt;
            opacity: 0.95;
        }
        
        .status-badges {
            margin-top: 10mm;
        }
        
        .status-badge {
            display: inline-block;
            margin-right: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 7.5pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Content Section */
        .content {
            padding: 18mm;
        }
        
        /* Trip Overview Cards */
        .overview-section {
            margin-bottom: 20mm;
        }
        
        .section-title {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 18pt;
            font-weight: 600;
            color: #1a202c;
            margin: 0 0 12mm 0;
            letter-spacing: -0.3px;
            position: relative;
            padding-bottom: 6mm;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #67469C;
            border-radius: 2px;
        }
        
        .overview-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 16mm;
            border-collapse: separate;
            border-spacing: 10mm;
        }
        
        .overview-grid-item {
            display: table-cell;
            width: 25%;
            vertical-align: top;
        }
        
        .overview-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 12mm 10mm;
            text-align: center;
            box-shadow: 0 2px 8px rgba(103, 70, 156, 0.08);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }
        
        .overview-icon {
            font-size: 28pt;
            margin-bottom: 8mm;
            display: block;
            opacity: 0.8;
        }
        
        .overview-label {
            font-size: 7.5pt;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6mm;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
        }
        
        .overview-value {
            font-size: 20pt;
            font-weight: 600;
            color: #1a202c;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .overview-value-small {
            font-size: 13pt;
            font-weight: 600;
            color: #1a202c;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            margin: 0;
        }
        
        /* Description Box */
        .description-box {
            background: #faf5ff;
            border-left: 4px solid #67469C;
            border-radius: 12px;
            padding: 14mm 16mm;
            margin-bottom: 18mm;
            box-shadow: 0 2px 8px rgba(103, 70, 156, 0.08);
        }
        
        .description-text {
            color: #4a5568;
            line-height: 1.85;
            font-size: 11pt;
            margin: 0;
            font-family: 'Gibson Book', 'DejaVu Sans', sans-serif;
        }
        
        /* Daily Itinerary */
        .daily-itinerary {
            margin-bottom: 20mm;
        }
        
        .day-card {
            background: #ffffff;
            border-radius: 16px;
            margin-bottom: 14mm;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(103, 70, 156, 0.1);
            border: 1px solid #f0f0f0;
            page-break-inside: avoid;
        }
        
        .day-header {
            background: linear-gradient(135deg, #67469C 0%, #7c5ba8 100%);
            color: white;
            padding: 12mm 16mm;
            position: relative;
        }
        
        .day-number {
            font-family: 'Gibson Light', 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.9;
            margin-bottom: 4mm;
        }
        
        .day-title {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 20pt;
            font-weight: 600;
            margin: 0;
            letter-spacing: -0.4px;
        }
        
        .day-body {
            padding: 16mm;
        }
        
        .day-description {
            background: #f7f7f7;
            border-left: 3px solid #67469C;
            border-radius: 8px;
            padding: 10mm 12mm;
            margin-bottom: 12mm;
            font-size: 11pt;
            color: #4a5568;
            line-height: 1.8;
            font-family: 'Gibson Book', 'DejaVu Sans', sans-serif;
        }
        
        .day-images {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 6mm;
            margin-bottom: 12mm;
        }
        
        .day-image-wrapper {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
        }
        
        .day-image {
            width: 100%;
            height: 60mm;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .meals-section {
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
            border-radius: 8px;
            padding: 8mm 10mm;
            margin-bottom: 12mm;
        }
        
        .meals-label {
            font-size: 8.5pt;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 6mm;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
        }
        
        .meals-tags {
        }
        
        .meal-tag {
            display: inline-block;
            margin-right: 6px;
            margin-bottom: 6px;
            background: white;
            padding: 4mm 8mm;
            border-radius: 20px;
            font-size: 9pt;
            color: #78350f;
            font-weight: 600;
            border: 1px solid #fde68a;
        }
        
        .activities-list {
        }
        
        .activity-card {
            background: #ffffff;
            border-left: 4px solid #67469C;
            border-radius: 12px;
            padding: 12mm;
            box-shadow: 0 2px 8px rgba(103, 70, 156, 0.08);
            border: 1px solid #f0f0f0;
            margin-bottom: 10mm;
        }
        
        .activity-card:last-child {
            margin-bottom: 0;
        }
        
        .activity-header {
            margin-bottom: 8mm;
        }
        
        .activity-header::after {
            content: '';
            display: table;
            clear: both;
        }
        
        .activity-title {
            font-size: 14pt;
            font-weight: 600;
            color: #1a202c;
            margin: 0 0 4mm 0;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            letter-spacing: -0.2px;
            line-height: 1.4;
            float: left;
            width: 70%;
        }
        
        .activity-time {
            background: #67469C;
            color: white;
            padding: 4mm 8mm;
            border-radius: 20px;
            font-size: 9pt;
            font-weight: 600;
            white-space: nowrap;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            float: right;
        }
        
        .activity-description {
            color: #4a5568;
            font-size: 11pt;
            line-height: 1.8;
            margin-bottom: 10mm;
            font-family: 'Gibson Book', 'DejaVu Sans', sans-serif;
        }
        
        .activity-meta {
            font-size: 9.5pt;
            color: #718096;
            font-family: 'Gibson Book', 'DejaVu Sans', sans-serif;
        }
        
        .activity-meta-item {
            display: inline-block;
            margin-right: 12mm;
        }
        
        .activity-type {
            background: #f7f7f7;
            color: #67469C;
            padding: 3mm 8mm;
            border-radius: 20px;
            font-size: 8.5pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
        }
        
        /* Inclusions & Exclusions */
        .inclusions-exclusions-section {
            margin-bottom: 20mm;
        }
        
        .inclusions-exclusions-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 12mm 0;
        }
        
        .inclusions-exclusions-grid-item {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .inclusions-box, .exclusions-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 16mm;
            box-shadow: 0 4px 12px rgba(103, 70, 156, 0.1);
            border: 1px solid #f0f0f0;
        }
        
        .inclusions-box {
            border-top: 4px solid #10b981;
        }
        
        .exclusions-box {
            border-top: 4px solid #ef4444;
        }
        
        .box-title {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 16pt;
            font-weight: 600;
            margin: 0 0 12mm 0;
            letter-spacing: -0.3px;
        }
        
        .inclusions-box .box-title {
            color: #059669;
        }
        
        .exclusions-box .box-title {
            color: #dc2626;
        }
        
        .inclusions-list, .exclusions-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .inclusions-list li, .exclusions-list li {
            padding: 6mm 0 6mm 28px;
            position: relative;
            font-size: 11pt;
            line-height: 1.8;
            color: #2d3748;
            border-bottom: 1px solid #f7f7f7;
            font-family: 'Gibson Book', 'DejaVu Sans', sans-serif;
        }
        
        .inclusions-list li:last-child, .exclusions-list li:last-child {
            border-bottom: none;
        }
        
        .inclusions-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 6mm;
            color: #10b981;
            font-weight: 700;
            font-size: 16pt;
        }
        
        .exclusions-list li::before {
            content: '✗';
            position: absolute;
            left: 0;
            top: 6mm;
            color: #ef4444;
            font-weight: 700;
            font-size: 16pt;
        }
        
        /* Important Notes */
        .notes-section {
            background: #fffbf0;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 14mm 16mm;
            margin-bottom: 20mm;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.1);
        }
        
        .notes-title {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 15pt;
            font-weight: 600;
            color: #92400e;
            margin: 0 0 8mm 0;
            letter-spacing: -0.3px;
        }
        
        .notes-text {
            color: #78350f;
            font-size: 11pt;
            line-height: 1.8;
            margin: 0;
            font-family: 'Gibson Book', 'DejaVu Sans', sans-serif;
        }
        
        /* Footer */
        .footer {
            background: #67469C;
            color: white;
            padding: 14mm 18mm;
            margin-top: 20mm;
        }
        
        .footer-content {
            margin-bottom: 10mm;
            padding-bottom: 10mm;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .footer-content::after {
            content: '';
            display: table;
            clear: both;
        }
        
        .footer-logo-section {
            float: left;
        }
        
        .footer-info {
            float: right;
            text-align: right;
        }
        
        .footer-logo-box {
            width: 56px;
            height: 56px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            padding: 8px;
        }
        
        .footer-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .footer-company-name {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 14pt;
            font-weight: 600;
            margin: 0;
        }
        
        .footer-info {
            text-align: right;
        }
        
        .footer-info p {
            font-size: 9pt;
            opacity: 0.9;
            margin: 2mm 0;
            line-height: 1.5;
        }
        
        .footer-info strong {
            font-weight: 600;
        }
        
        .footer-bottom {
            text-align: center;
            font-size: 9pt;
            opacity: 0.85;
            line-height: 1.6;
        }
        
        .footer-bottom p {
            margin: 2mm 0;
        }
        
        /* Print Styles */
        @media print {
            .page {
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            
            .day-card {
                page-break-inside: avoid;
            }
            
            .activity-card {
                page-break-inside: avoid;
            }
        }
        
        /* Cover Image */
        .cover-image-section {
            margin-bottom: 18mm;
        }
        
        .cover-image {
            width: 100%;
            max-height: 100mm;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Customer Details */
        .customer-details-section {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            border-radius: 12px;
            padding: 14mm 16mm;
            margin-bottom: 18mm;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.1);
        }
        
        .customer-details-title {
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
            font-size: 15pt;
            font-weight: 600;
            color: #15803d;
            margin: 0 0 10mm 0;
            letter-spacing: -0.3px;
        }
        
        .customer-details-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 8mm;
        }
        
        .customer-details-row {
            display: table-row;
        }
        
        .customer-details-cell {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .customer-detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .customer-detail-label {
            font-size: 8pt;
            font-weight: 600;
            color: #166534;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3mm;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
        }
        
        .customer-detail-value {
            font-size: 11pt;
            font-weight: 600;
            color: #1a202c;
            font-family: 'Gibson Semibold', 'DejaVu Sans', sans-serif;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Premium Header -->
        <div class="header">
            <div class="header-content">
                <div class="company-header">
                    <div class="logo-container">
                        <div class="logo-box">
                            @php
                                $coloredLogoPath = public_path('assets/images/good-vacation-logo.svg');
                                $fallbackLogoPath = public_path('assets/images/footer-logo.png');
                                $logoExists = file_exists($coloredLogoPath);
                            @endphp
                            @if($logoExists)
                                <img src="{{ $coloredLogoPath }}" alt="Good Vacations">
                            @elseif(file_exists($fallbackLogoPath))
                                <img src="{{ $fallbackLogoPath }}" alt="Good Vacations">
                            @else
                                <div style="width: 100%; height: 100%; background: #67469C; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">GV</div>
                            @endif
                        </div>
                        <div>
                            <div class="company-name">Good Vacations</div>
                            <div class="company-tagline">Premium Travel Experiences</div>
                        </div>
                    </div>
                </div>
                
                <div class="itinerary-header">
                    <h1 class="itinerary-name">{{ $itinerary->name }}</h1>
                    @if($itinerary->tagline)
                        <p class="itinerary-tagline">{{ $itinerary->tagline }}</p>
                    @endif
                    
                    <div class="itinerary-meta">
                        @if($itinerary->start_date)
                        <div class="meta-item">
                            <span>📅</span>
                            <span>{{ \Carbon\Carbon::parse($itinerary->start_date)->format('M d, Y') }}</span>
                        </div>
                        @endif
                        @if($itinerary->duration_days)
                        <div class="meta-item">
                            <span>⏱️</span>
                            <span>{{ $itinerary->duration_days }} {{ ($itinerary->duration_days == 1) ? 'Day' : 'Days' }}</span>
                        </div>
                        @endif
                        @if($itinerary->country)
                        <div class="meta-item">
                            <span>🌍</span>
                            <span>{{ $itinerary->country->name }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="status-badges">
                        @if($itinerary->is_master)
                            <span class="status-badge">Master Itinerary</span>
                        @endif
                        @if($itinerary->is_custom)
                            <span class="status-badge">Custom Itinerary</span>
                        @endif
                        @if($itinerary->status === 'published')
                            <span class="status-badge">Published</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Cover Image -->
            @if($itinerary->cover_image)
            <div class="cover-image-section">
                <img src="{{ public_path('storage/' . $itinerary->cover_image) }}" alt="Cover Image" class="cover-image" onerror="this.style.display='none'">
            </div>
            @endif
            
            <!-- Customer Details (Only if NOT master) -->
            @if(!$itinerary->is_master && $itinerary->lead)
            <div class="customer-details-section">
                <h3 class="customer-details-title">Customer Information</h3>
                <div class="customer-details-grid">
                    <div class="customer-details-row">
                        @if($itinerary->lead->name)
                        <div class="customer-details-cell">
                            <div class="customer-detail-item">
                                <div class="customer-detail-label">Name</div>
                                <div class="customer-detail-value">{{ $itinerary->lead->name }}</div>
                            </div>
                        </div>
                        @endif
                        @if($itinerary->lead->email)
                        <div class="customer-details-cell">
                            <div class="customer-detail-item">
                                <div class="customer-detail-label">Email</div>
                                <div class="customer-detail-value">{{ $itinerary->lead->email }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="customer-details-row">
                        @if($itinerary->lead->phone)
                        <div class="customer-details-cell">
                            <div class="customer-detail-item">
                                <div class="customer-detail-label">Phone</div>
                                <div class="customer-detail-value">{{ $itinerary->lead->phone_code ?? '' }}{{ $itinerary->lead->phone }}</div>
                            </div>
                        </div>
                        @endif
                        @if($itinerary->lead->address)
                        <div class="customer-details-cell">
                            <div class="customer-detail-item">
                                <div class="customer-detail-label">Address</div>
                                <div class="customer-detail-value">{{ $itinerary->lead->address }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="customer-details-row">
                        @if($itinerary->lead->city)
                        <div class="customer-details-cell">
                            <div class="customer-detail-item">
                                <div class="customer-detail-label">City</div>
                                <div class="customer-detail-value">{{ $itinerary->lead->city }}</div>
                            </div>
                        </div>
                        @endif
                        @if($itinerary->lead->country)
                        <div class="customer-details-cell">
                            <div class="customer-detail-item">
                                <div class="customer-detail-label">Country</div>
                                <div class="customer-detail-value">{{ $itinerary->lead->country }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Trip Overview -->
            <div class="overview-section">
                <h2 class="section-title">Trip Overview</h2>
                <div class="overview-grid">
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">📅</span>
                            <div class="overview-label">Duration</div>
                            <div class="overview-value">{{ $itinerary->duration_days ?? 'N/A' }}</div>
                            <div style="font-size: 8pt; color: #a0aec0; margin-top: 3mm;">{{ ($itinerary->duration_days ?? 1) == 1 ? 'Day' : 'Days' }}</div>
                        </div>
                    </div>
                    
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">🗺️</span>
                            <div class="overview-label">Destinations</div>
                            <div class="overview-value">{{ $itinerary->destinations->count() }}</div>
                        </div>
                    </div>
                    
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">🎯</span>
                            <div class="overview-label">Activities</div>
                            <div class="overview-value">{{ $itinerary->days->sum(function($day) { return $day->items->count(); }) }}</div>
                        </div>
                    </div>
                    
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">🌍</span>
                            <div class="overview-label">Country</div>
                            <div class="overview-value-small">{{ $itinerary->country->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Travel Party Info -->
            @if($itinerary->adult_count || $itinerary->child_count || $itinerary->infant_count)
            <div class="overview-section">
                <h2 class="section-title">Travel Party</h2>
                <div class="overview-grid">
                    @if($itinerary->adult_count)
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">👥</span>
                            <div class="overview-label">Adults</div>
                            <div class="overview-value">{{ $itinerary->adult_count }}</div>
                        </div>
                    </div>
                    @endif
                    @if($itinerary->child_count)
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">👶</span>
                            <div class="overview-label">Children</div>
                            <div class="overview-value">{{ $itinerary->child_count }}</div>
                        </div>
                    </div>
                    @endif
                    @if($itinerary->infant_count)
                    <div class="overview-grid-item">
                        <div class="overview-card">
                            <span class="overview-icon">🍼</span>
                            <div class="overview-label">Infants</div>
                            <div class="overview-value">{{ $itinerary->infant_count }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($itinerary->description)
            <div class="description-box">
                <p class="description-text">{{ $itinerary->description }}</p>
            </div>
            @endif

            <!-- Daily Itinerary -->
            @if($itinerary->days->count() > 0)
            <div class="daily-itinerary">
                <h2 class="section-title">Daily Itinerary</h2>
                
                @foreach($itinerary->days->sortBy('day_number') as $day)
                <div class="day-card">
                    <div class="day-header">
                        <div class="day-number">Day {{ $day->day_number }}</div>
                        <h3 class="day-title">{{ $day->title }}</h3>
                    </div>
                    <div class="day-body">
                        @if($day->images && is_array($day->images) && count($day->images) > 0)
                        <div class="day-images">
                            @foreach(array_slice($day->images, 0, 3) as $image)
                            <div class="day-image-wrapper">
                                <img src="{{ public_path('storage/' . $image) }}" alt="Day {{ $day->day_number }} Image" class="day-image" onerror="this.style.display='none'">
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                        @if($day->description)
                        <div class="day-description">{{ $day->description }}</div>
                        @endif
                        
                        @if($day->meals && is_array($day->meals) && count($day->meals) > 0)
                        <div class="meals-section">
                            <div class="meals-label">Meals Included</div>
                            <div class="meals-tags">
                                @foreach($day->meals as $meal)
                                <span class="meal-tag">{{ ucfirst($meal) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if($day->items->count() > 0)
                        <div class="activities-list">
                            @foreach($day->items->sortBy('sort_order') as $item)
                            <div class="activity-card">
                                <div class="activity-header">
                                    <div class="activity-title">{{ $item->title }}</div>
                                    @if($item->start_time || $item->end_time)
                                    <div class="activity-time">
                                        @if($item->start_time)
                                            @php
                                                try {
                                                    $startTime = is_string($item->start_time) ? \Carbon\Carbon::parse($item->start_time) : $item->start_time;
                                                    echo $startTime->format('g:i A');
                                                } catch (\Exception $e) {
                                                    echo $item->start_time;
                                                }
                                            @endphp
                                        @endif
                                        @if($item->start_time && $item->end_time) - @endif
                                        @if($item->end_time)
                                            @php
                                                try {
                                                    $endTime = is_string($item->end_time) ? \Carbon\Carbon::parse($item->end_time) : $item->end_time;
                                                    echo $endTime->format('g:i A');
                                                } catch (\Exception $e) {
                                                    echo $item->end_time;
                                                }
                                            @endphp
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                
                                @if($item->description)
                                <div class="activity-description">{{ $item->description }}</div>
                                @endif
                                
                                <div class="activity-meta">
                                    @if($item->location)
                                    <div class="activity-meta-item">
                                        <span>📍</span>
                                        <span>{{ $item->location }}</span>
                                    </div>
                                    @endif
                                    @if($item->duration_minutes)
                                    <div class="activity-meta-item">
                                        <span>⏱️</span>
                                        <span>{{ $item->duration_minutes }} min</span>
                                    </div>
                                    @endif
                                    @if($item->type)
                                    <span class="activity-type">{{ ucfirst($item->type) }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Inclusions & Exclusions -->
            @if($itinerary->inclusions || $itinerary->exclusions)
            <div class="inclusions-exclusions-section">
                <h2 class="section-title">What's Included & Not Included</h2>
                <div class="inclusions-exclusions-grid">
                    @if($itinerary->inclusions && is_array($itinerary->inclusions) && count($itinerary->inclusions) > 0)
                    <div class="inclusions-exclusions-grid-item">
                        <div class="inclusions-box">
                            <h3 class="box-title">
                                <span>✓</span>
                                <span>What's Included</span>
                            </h3>
                            <ul class="inclusions-list">
                                @foreach($itinerary->inclusions as $inclusion)
                                <li>{{ $inclusion }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    
                    @if($itinerary->exclusions && is_array($itinerary->exclusions) && count($itinerary->exclusions) > 0)
                    <div class="inclusions-exclusions-grid-item">
                        <div class="exclusions-box">
                            <h3 class="box-title">
                                <span>✗</span>
                                <span>Not Included</span>
                            </h3>
                            <ul class="exclusions-list">
                                @foreach($itinerary->exclusions as $exclusion)
                                <li>{{ $exclusion }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Terms & Conditions -->
            @if($itinerary->terms_conditions)
            <div class="notes-section">
                <h3 class="notes-title">Terms & Conditions</h3>
                <p class="notes-text">{{ $itinerary->terms_conditions }}</p>
            </div>
            @endif

            <!-- Cancellation Policy -->
            @if($itinerary->cancellation_policy)
            <div class="notes-section">
                <h3 class="notes-title">Cancellation Policy</h3>
                <p class="notes-text">{{ $itinerary->cancellation_policy }}</p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-logo-section">
                    <div class="footer-logo-box">
                        @php
                            $lightLogoPath = public_path('assets/images/footer-logo.png');
                            $coloredLogoPath = public_path('assets/images/good-vacation-logo.svg');
                            $logoExists = file_exists($lightLogoPath);
                        @endphp
                        @if($logoExists)
                            <img src="{{ $lightLogoPath }}" alt="Good Vacations">
                        @elseif(file_exists($coloredLogoPath))
                            <img src="{{ $coloredLogoPath }}" alt="Good Vacations">
                        @else
                            <div style="width: 100%; height: 100%; background: white; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #67469C; font-weight: bold; font-size: 12px;">GV</div>
                        @endif
                    </div>
                    <div>
                        <div class="footer-company-name">Good Vacations</div>
                    </div>
                </div>
                <div class="footer-info">
                    <p><strong>Generated:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
                    <p><strong>Created by:</strong> {{ $itinerary->user->name ?? 'System' }}</p>
                    @if($itinerary->lead)
                    <p><strong>For:</strong> {{ $itinerary->lead->name }}</p>
                    @endif
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} Good Vacations. All rights reserved.</p>
                <p>Your trusted partner for unforgettable travel experiences</p>
            </div>
        </div>
    </div>
</body>
</html>
