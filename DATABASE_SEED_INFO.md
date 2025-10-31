# Database Seed Information

This document contains information about all the seeded data in your LeadFlow CRM application.

## 📊 Seeded Data Summary

### 👥 Users (11 Total)

#### Default Users (From RolePermissionSeeder)
1. **Super Admin**
   - Email: `admin@example.com`
   - Password: `password`
   - Role: Super Admin
   - Permissions: All

2. **Sales Manager** 
   - Email: `manager@example.com`
   - Password: `password`
   - Role: Sales Manager
   - Permissions: Leads, Products, Users (view/create/edit)

3. **Sales Executive**
   - Email: `sales@example.com`
   - Password: `password`
   - Role: Sales Executive
   - Permissions: Leads (view/create/edit), Products (view)

#### Additional Users (From UserSeeder)
4. **John Anderson** - `john@example.com` - Sales Executive
5. **Sarah Johnson** - `sarah@example.com` - Sales Executive
6. **Michael Brown** - `michael@example.com` - Sales Executive
7. **Emily Davis** - `emily@example.com` - Sales Manager
8. **David Wilson** - `david@example.com` - Sales Executive
9. **Jessica Martinez** - `jessica@example.com` - Admin
10. **Robert Taylor** - `robert@example.com` - Sales Executive
11. **Lisa Anderson** - `lisa@example.com` - Sales Manager

> 🔑 **All users have password:** `password`

---

### 🏷️ Categories (5 Total)
1. **Electronics** - Electronic devices and gadgets
2. **Software** - Software products and licenses
3. **Services** - Professional services
4. **Hardware** - Computer hardware and accessories
5. **Consulting** - Business consulting services

---

### 🏢 Brands (5 Total)
1. **TechCorp** - Leading technology brand
2. **InnovateSoft** - Innovative software solutions
3. **ProServices** - Professional service provider
4. **GlobalTech** - Global technology company
5. **SmartSolutions** - Smart business solutions

---

### 🏪 Branches (3 Total)
1. **Main Office** - New York, NY
   - Contact: John Doe
   - Phone: +1-555-0100
   - Email: newyork@example.com

2. **West Coast Branch** - Los Angeles, CA
   - Contact: Jane Smith
   - Phone: +1-555-0200
   - Email: losangeles@example.com

3. **Central Branch** - Chicago, IL
   - Contact: Mike Johnson
   - Phone: +1-555-0300
   - Email: chicago@example.com

---

### 📦 Products (25 Total)

#### From CategoryBrandSeeder (5 products):
1. **Enterprise Software License** - $999.99 (Software)
2. **Cloud Storage Pro** - $49.99 (Software)
3. **Business Laptop** - $1,299.99 (Electronics)
4. **Consulting Package** - $5,000.00 (Consulting)
5. **Network Security Suite** - $799.99 (Software)

#### From ProductSeeder (20 additional products):

**Electronics:**
- Professional Workstation - $2,499.99
- Wireless Presentation System - $899.99
- 4K Conference Camera - $699.99

**Software:**
- CRM Software Pro - $1,499.99
- Project Management Suite - $799.99
- Data Analytics Platform - $2,999.99
- Email Marketing Pro - $399.99
- Mobile Device Management - $599.99
- Video Conferencing License - $199.99

**Services:**
- IT Support Package - $299.99/month
- Digital Marketing Service - $1,999.99
- Cloud Migration Service - $4,999.99

**Hardware:**
- Enterprise Server Rack - $8,999.99
- Network Switch 48-Port - $1,299.99
- Wireless Access Point - $399.99
- UPS Battery Backup - $599.99

**Consulting:**
- Business Strategy Session - $2,500.00
- Digital Transformation Package - $15,000.00
- Security Audit Service - $3,500.00
- Training Workshop Package - $1,500.00

---

### 📊 Lead Statuses
- New
- Contacted
- Qualified
- Proposal
- Negotiation
- Won
- Lost
- (and more...)

---

### 🔔 Notifications
Sample notifications have been created for demonstration purposes.

---

## 🚀 Quick Start

### Login Options

You can login with any of these credentials:

**For Full Access:**
```
Email: admin@example.com
Password: password
```

**For Management:**
```
Email: manager@example.com or emily@example.com
Password: password
```

**For Sales:**
```
Email: sales@example.com or john@example.com
Password: password
```

---

## 📝 Notes

- All passwords are set to `password` for development purposes
- Change passwords immediately in production
- The database includes roles and permissions managed by Spatie Laravel Permission
- Products are distributed across all categories and brands
- Users are assigned to different roles for testing purposes

---

## 🔄 Re-seeding

To re-seed the database:

```bash
# Fresh migration and seed
php artisan migrate:fresh --seed

# Or just seed again (if data exists, you may get errors)
php artisan db:seed
```

---

**Generated:** 2025-10-30
**Application:** LeadFlow CRM

