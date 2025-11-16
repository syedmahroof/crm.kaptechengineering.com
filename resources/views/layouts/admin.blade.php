<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Preconnect to asset domain for faster loading on mobile -->
    @if(config('app.url'))
        @php
            $urlParts = parse_url(config('app.url'));
            $scheme = $urlParts['scheme'] ?? 'https';
            $host = $urlParts['host'] ?? '';
        @endphp
        @if($host)
            <link rel="preconnect" href="{{ $scheme }}://{{ $host }}">
        @endif
    @endif
    
    <!-- Tailwind CSS (Static) -->
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}" media="all">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link.active {
            background-color: rgba(99, 102, 241, 0.1);
            color: rgb(99, 102, 241);
        }
        .sidebar-link:hover {
            background-color: rgba(99, 102, 241, 0.05);
        }
        [x-collapse] {
            overflow: hidden;
        }
        /* Tooltip for collapsed sidebar */
        aside[class*="w-16"] .sidebar-link {
            position: relative;
        }
        aside[class*="w-16"] .sidebar-link:hover::after {
            content: attr(title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 8px;
            padding: 4px 8px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:flex-shrink-0 transition-all duration-300" :class="{ 'md:w-16': sidebarCollapsed, 'md:w-64': !sidebarCollapsed }">
            <div class="flex flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 w-full">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4 mb-8" :class="{ 'justify-center': sidebarCollapsed }">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white" x-show="!sidebarCollapsed">
                            <img src="{{ asset('lansoa_light.png') }}" alt="Lansoa" style="width: 50px; height:auto"> 
                        </h2>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white" x-show="sidebarCollapsed" x-cloak>
                            <img src="{{ asset('lansoa_light.png') }}" alt="Lansoa" style="width: 30px; height:auto"> 
                        </h2>
                    </div>
                    <nav class="mt-5 flex-1 space-y-1" :class="{ 'px-2': !sidebarCollapsed, 'px-1': sidebarCollapsed }" x-data="{ openMenus: {} }">
                        <a href="{{ route('dashboard') }}" class="sidebar-link group flex items-center text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center px-2 py-2': sidebarCollapsed, 'px-3 py-2': !sidebarCollapsed }" title="Dashboard">
                            <i class="fas fa-home" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Dashboard</span>
                        </a>
                        
                        <!-- Enquiries Section - Collapsible -->
                        @canany(['view leads', 'view lead sources', 'view lead priorities', 'view lead types', 'view campaigns'])
                        <div x-data="{ open: {{ request()->routeIs('leads.*') || request()->routeIs('lead-sources.*') || request()->routeIs('lead-priorities.*') || request()->routeIs('lead-types.*') || request()->routeIs('campaigns.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full sidebar-link group flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" :class="{ 'justify-center': sidebarCollapsed }" title="Enquiries">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="fas fa-users" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                                    <span x-show="!sidebarCollapsed">Enquiries</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open, 'hidden': sidebarCollapsed }"></i>
                            </button>
                            <div x-show="open && !sidebarCollapsed" x-collapse class="ml-4 mt-1 space-y-1">
                                @can('view leads')
                                <a href="{{ route('leads.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('leads.index') || request()->routeIs('leads.show') || request()->routeIs('leads.create') || request()->routeIs('leads.edit') ? 'active' : 'text-gray-600 dark:text-gray-400' }}" title="All Enquiries">
                                    <i class="fas fa-list text-xs mr-3"></i>All Enquiries
                        </a>
                                @endcan
                                @can('view lead analytics')
                                <a href="{{ route('leads.analytics') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('leads.analytics') ? 'active' : 'text-gray-600 dark:text-gray-400' }}" title="Analytics">
                                    <i class="fas fa-chart-line text-xs mr-3"></i>Analytics
                        </a>
                                @endcan
                                @can('view lead sources')
                                <a href="{{ route('lead-sources.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lead-sources.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}" title="Enquiry Sources">
                                    <i class="fas fa-funnel-dollar text-xs mr-3"></i>Enquiry Sources
                        </a>
                                @endcan
                                @can('view lead priorities')
                                <a href="{{ route('lead-priorities.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lead-priorities.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}" title="Enquiry Priorities">
                                    <i class="fas fa-star text-xs mr-3"></i>Enquiry Priorities
                        </a>
                                @endcan
                                @can('view lead types')
                                <a href="{{ route('lead-types.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lead-types.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}" title="Enquiry Types">
                                    <i class="fas fa-tags text-xs mr-3"></i>Enquiry Types
                        </a>
                                @endcan
                                @can('view campaigns')
                                <a href="{{ route('campaigns.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('campaigns.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}" title="Campaigns">
                                    <i class="fas fa-bullhorn text-xs mr-3"></i>Campaigns
                        </a>
                                @endcan
                            </div>
                        </div>
                        @endcanany
                        
                        <!-- Operations -->
                        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700" x-show="!sidebarCollapsed">
                            <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Operations</p>
                        </div>
                        
                        @can('view tasks')
                        <a href="{{ route('tasks.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('tasks.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Tasks">
                            <i class="fas fa-tasks" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Tasks</span>
                        </a>
                        @endcan
                        
                        @can('view customers')
                        <a href="{{ route('customers.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('customers.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Customers">
                            <i class="fas fa-user-friends" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Customers</span>
                        </a>
                        @endcan
                        
                        @can('view contacts')
                        <a href="{{ route('admin.contacts.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contacts.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Contacts">
                            <i class="fas fa-envelope" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Contacts</span>
                        </a>
                        @endcan
                        
                        <a href="{{ route('projects.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('projects.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Projects">
                            <i class="fas fa-project-diagram" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Projects</span>
                        </a>
                        
                        <a href="{{ route('visit-reports.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('visit-reports.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Visit Reports">
                            <i class="fas fa-clipboard-list" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Visit Reports</span>
                        </a>
                        
                        <a href="{{ route('products.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('products.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Products">
                            <i class="fas fa-box" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Products</span>
                        </a>
                        
                        <a href="{{ route('quotations.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('quotations.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Quotations">
                            <i class="fas fa-file-invoice-dollar" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Quotations</span>
                        </a>
                        
                        <a href="{{ route('notes.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('notes.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Notes">
                            <i class="fas fa-sticky-note" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Notes</span>
                        </a>
                        
                        <!-- Content - Collapsible -->
                        @canany(['view blogs', 'view testimonials', 'view faqs', 'view banners', 'view newsletters'])
                        <div x-data="{ open: {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.faqs.*') || request()->routeIs('admin.testimonials.*') || request()->routeIs('admin.banners.*') || request()->routeIs('admin.newsletters.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full sidebar-link group flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" :class="{ 'justify-center': sidebarCollapsed }" title="Content">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="fas fa-file-alt" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                                    <span x-show="!sidebarCollapsed">Content</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open, 'hidden': sidebarCollapsed }"></i>
                            </button>
                            <div x-show="open && !sidebarCollapsed" x-collapse class="ml-4 mt-1 space-y-1">
                                @can('view blogs')
                                <a href="{{ route('admin.blogs.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.blogs.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-blog text-xs mr-3"></i>Blogs
                        </a>
                                @endcan
                                @can('view testimonials')
                                <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.testimonials.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-quote-left text-xs mr-3"></i>Testimonials
                        </a>
                                @endcan
                                @can('view faqs')
                                <a href="{{ route('admin.faqs.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.faqs.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-question-circle text-xs mr-3"></i>FAQs
                        </a>
                                @endcan
                                @can('view banners')
                                <a href="{{ route('admin.banners.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.banners.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-image text-xs mr-3"></i>Banners
                        </a>
                                @endcan
                                @can('view newsletters')
                                <a href="{{ route('admin.newsletters.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.newsletters.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-newspaper text-xs mr-3"></i>Newsletters
                        </a>
                                @endcan
                            </div>
                        </div>
                        @endcanany
                        
                        <!-- Settings - Collapsible -->
                        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700" x-show="!sidebarCollapsed">
                            <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Settings</p>
                        </div>
                        
                        @canany(['view users', 'view roles', 'view permissions', 'view branches'])
                        <div x-data="{ open: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') || request()->routeIs('profile.*') || request()->routeIs('password.*') || request()->routeIs('settings.branches.*') || request()->routeIs('teams.*') || request()->routeIs('countries.*') || request()->routeIs('states.*') || request()->routeIs('districts.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full sidebar-link group flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" :class="{ 'justify-center': sidebarCollapsed }" title="System Settings">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="fas fa-cog" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                                    <span x-show="!sidebarCollapsed">System Settings</span>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open, 'hidden': sidebarCollapsed }"></i>
                            </button>
                            <div x-show="open && !sidebarCollapsed" x-collapse class="ml-4 mt-1 space-y-1">
                                @can('view users')
                                <a href="{{ route('users.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('users.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-users text-xs mr-3"></i>Users
                        </a>
                                @endcan
                                @can('view users')
                                <a href="{{ route('staff-performance.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('staff-performance.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-chart-line text-xs mr-3"></i>Staff Performance
                        </a>
                                @endcan
                                @can('view roles')
                                <a href="{{ route('roles.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('roles.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-user-shield text-xs mr-3"></i>Roles
                        </a>
                                @endcan
                                @can('view permissions')
                                <a href="{{ route('permissions.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('permissions.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-key text-xs mr-3"></i>Permissions
                        </a>
                                @endcan
                                @can('view branches')
                                <a href="{{ route('settings.branches.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.branches.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-building text-xs mr-3"></i>Branches
                        </a>
                                @endcan
                                <a href="{{ route('teams.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('teams.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-users-cog text-xs mr-3"></i>Teams
                                </a>
                                <a href="{{ route('countries.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('countries.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-globe text-xs mr-3"></i>Countries
                                </a>
                                <a href="{{ route('states.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('states.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-map-marked-alt text-xs mr-3"></i>States/Provinces
                                </a>
                                <a href="{{ route('districts.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('districts.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-city text-xs mr-3"></i>Districts/Cities
                                </a>
                                <a href="{{ route('profile.edit') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profile.*') || request()->routeIs('password.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-user-circle text-xs mr-3"></i>Profile
                                </a>
                            </div>
                        </div>
                        @endcanany
                        
                        @can('view reminders')
                        <a href="{{ route('reminders.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('reminders.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}" :class="{ 'justify-center': sidebarCollapsed }" title="Reminders">
                            <i class="fas fa-bell" :class="{ 'mr-3': !sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed">Reminders</span>
                        </a>
                        @endcan
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <!-- Mobile hamburger -->
                            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <!-- Desktop hamburger for sidebar collapse -->
                            <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden md:flex text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Toggle Sidebar">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                        <div class="flex items-center space-x-4 ml-auto">
                            <!-- Reminders Icon -->
                            <a href="{{ route('reminders.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 relative" title="Reminders">
                                <i class="fas fa-clock text-xl"></i>
                            </a>
                            
                            <!-- Notifications Dropdown -->
                            <div class="relative notification-dropdown" x-data="{ open: false, notifications: [], unreadCount: 0, loading: false }" 
                                 @mouseenter="if (!open) { loading = true; fetch('{{ route('notifications.recent') }}').then(r => r.json()).then(data => { notifications = data.notifications; unreadCount = data.unreadCount; loading = false; open = true; }); }" 
                                 @mouseleave="open = false">
                                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 relative" title="Notifications">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span x-show="unreadCount > 0" class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                                </button>
                                
                                <!-- Dropdown Panel -->
                                <div x-show="open" 
                                     x-cloak
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 max-h-96 overflow-hidden flex flex-col">
                                    <!-- Header -->
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                        <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400">View All</a>
                                    </div>
                                    
                                    <!-- Loading State -->
                                    <div x-show="loading" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-spinner fa-spin"></i> Loading...
                                    </div>
                                    
                                    <!-- Notifications List -->
                                    <div x-show="!loading && notifications.length > 0" class="overflow-y-auto flex-1">
                                        <template x-for="notification in notifications" :key="notification.id">
                                            <div class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700 cursor-pointer"
                                                 @click="
                                                     if (!notification.read_at) {
                                                         fetch(`/notifications/${notification.id}/read`, {
                                                             method: 'POST',
                                                             headers: {
                                                                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                 'Content-Type': 'application/json',
                                                                 'Accept': 'application/json'
                                                             }
                                                         }).then(() => {
                                                             notification.read_at = new Date().toISOString();
                                                             unreadCount = Math.max(0, unreadCount - 1);
                                                         });
                                                     }
                                                     if (notification.data?.url) {
                                                         window.location.href = notification.data.url;
                                                     }
                                                 ">
                                                <div class="flex items-start space-x-3">
                                                    <div x-show="!notification.read_at" class="mt-1.5 h-2 w-2 rounded-full bg-blue-600 flex-shrink-0"></div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.data?.title || 'Notification'"></p>
                                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-text="notification.time_ago"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <!-- Empty State -->
                                    <div x-show="!loading && notifications.length === 0" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        <p class="text-sm">No notifications</p>
                                    </div>
                                    
                                    <!-- Footer -->
                                    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('notifications.index') }}" class="block text-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
                                            View More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Calendar Icon -->
                            @can('view calendar')
                            <a href="{{ route('calendar') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" title="Calendar">
                                <i class="fas fa-calendar-alt text-xl"></i>
                            </a>
                            @endcan
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Mobile Sidebar -->
            <div x-show="sidebarOpen" @click.away="sidebarOpen = false" x-cloak class="md:hidden fixed inset-0 z-50 flex">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none">
                            <i class="fas fa-times text-white"></i>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <nav class="mt-5 px-2 space-y-1">
                            <a href="{{ route('dashboard') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-home mr-3"></i>Dashboard
                            </a>
                            
                            <!-- Enquiries Section - Collapsible -->
                            @canany(['view leads', 'view lead sources', 'view lead priorities', 'view lead types', 'view campaigns'])
                            <div x-data="{ open: {{ request()->routeIs('leads.*') || request()->routeIs('lead-sources.*') || request()->routeIs('lead-priorities.*') || request()->routeIs('lead-types.*') || request()->routeIs('campaigns.*') ? 'true' : 'false' }} }">
                                <button @click="open = !open" class="w-full sidebar-link group flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                <i class="fas fa-users mr-3"></i>Enquiries
                                    </div>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                                    @can('view leads')
                                    <a href="{{ route('leads.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('leads.index') || request()->routeIs('leads.show') || request()->routeIs('leads.create') || request()->routeIs('leads.edit') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-list text-xs mr-3"></i>All Enquiries
                                    </a>
                                    @endcan
                                    @can('view lead analytics')
                                    <a href="{{ route('leads.analytics') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('leads.analytics') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-chart-line text-xs mr-3"></i>Analytics
                            </a>
                                    @endcan
                                    @can('view lead sources')
                                    <a href="{{ route('lead-sources.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lead-sources.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-funnel-dollar text-xs mr-3"></i>Enquiry Sources
                            </a>
                                    @endcan
                                    @can('view lead priorities')
                                    <a href="{{ route('lead-priorities.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lead-priorities.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-star text-xs mr-3"></i>Enquiry Priorities
                            </a>
                                    @endcan
                                    @can('view lead types')
                                    <a href="{{ route('lead-types.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lead-types.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-tags text-xs mr-3"></i>Enquiry Types
                            </a>
                                    @endcan
                                    @can('view campaigns')
                                    <a href="{{ route('campaigns.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('campaigns.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-bullhorn text-xs mr-3"></i>Campaigns
                            </a>
                                    @endcan
                                </div>
                            </div>
                            @endcanany
                            
                            @can('view tasks')
                            <a href="{{ route('tasks.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('tasks.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-tasks mr-3"></i>Tasks
                            </a>
                            @endcan
                            
                            @can('view customers')
                            <a href="{{ route('customers.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('customers.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-user-friends mr-3"></i>Customers
                            </a>
                            @endcan
                            
                            @can('view contacts')
                            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.contacts.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-envelope mr-3"></i>Contacts
                            </a>
                            @endcan
                            
                            <a href="{{ route('projects.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('projects.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-project-diagram mr-3"></i>Projects
                            </a>
                            
                            <a href="{{ route('visit-reports.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('visit-reports.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-clipboard-list mr-3"></i>Visit Reports
                            </a>
                            
                            <a href="{{ route('products.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('products.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-box mr-3"></i>Products
                            </a>
                            
                            <a href="{{ route('quotations.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('quotations.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-file-invoice-dollar mr-3"></i>Quotations
                            </a>
                            
                            <a href="{{ route('notes.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('notes.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-sticky-note mr-3"></i>Notes
                            </a>
                            
                            <!-- Content - Collapsible -->
                            @canany(['view blogs', 'view testimonials', 'view faqs', 'view banners', 'view newsletters'])
                            <div x-data="{ open: {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.faqs.*') || request()->routeIs('admin.testimonials.*') || request()->routeIs('admin.banners.*') || request()->routeIs('admin.newsletters.*') ? 'true' : 'false' }} }">
                                <button @click="open = !open" class="w-full sidebar-link group flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt mr-3"></i>Content
                                    </div>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                                    @can('view blogs')
                                    <a href="{{ route('admin.blogs.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.blogs.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-blog text-xs mr-3"></i>Blogs
                            </a>
                                    @endcan
                                    @can('view testimonials')
                                    <a href="{{ route('admin.testimonials.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.testimonials.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-quote-left text-xs mr-3"></i>Testimonials
                            </a>
                                    @endcan
                                    @can('view faqs')
                                    <a href="{{ route('admin.faqs.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.faqs.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-question-circle text-xs mr-3"></i>FAQs
                            </a>
                                    @endcan
                                    @can('view banners')
                                    <a href="{{ route('admin.banners.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.banners.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-image text-xs mr-3"></i>Banners
                            </a>
                                    @endcan
                                    @can('view newsletters')
                                    <a href="{{ route('admin.newsletters.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.newsletters.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-newspaper text-xs mr-3"></i>Newsletters
                                    </a>
                                    @endcan
                                </div>
                            </div>
                            @endcanany
                            
                            <!-- Settings - Collapsible -->
                            @canany(['view users', 'view roles', 'view permissions', 'view branches'])
                            <div x-data="{ open: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') || request()->routeIs('profile.*') || request()->routeIs('password.*') || request()->routeIs('settings.branches.*') || request()->routeIs('teams.*') || request()->routeIs('countries.*') || request()->routeIs('states.*') || request()->routeIs('districts.*') ? 'true' : 'false' }} }">
                                <button @click="open = !open" class="w-full sidebar-link group flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-cog mr-3"></i>System Settings
                                    </div>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                                @can('view users')
                                <a href="{{ route('users.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('users.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-users text-xs mr-3"></i>Users
                        </a>
                                @endcan
                                @can('view users')
                                <a href="{{ route('staff-performance.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('staff-performance.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                    <i class="fas fa-chart-line text-xs mr-3"></i>Staff Performance
                        </a>
                                @endcan
                                @can('view roles')
                                    <a href="{{ route('roles.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('roles.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-user-shield text-xs mr-3"></i>Roles
                            </a>
                                    @endcan
                                    @can('view permissions')
                                    <a href="{{ route('permissions.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('permissions.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-key text-xs mr-3"></i>Permissions
                            </a>
                                    @endcan
                                    @can('view branches')
                                    <a href="{{ route('settings.branches.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.branches.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-building text-xs mr-3"></i>Branches
                            </a>
                                    @endcan
                                    <a href="{{ route('teams.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('teams.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-users-cog text-xs mr-3"></i>Teams
                                    </a>
                                    <a href="{{ route('countries.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('countries.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-globe text-xs mr-3"></i>Countries
                                    </a>
                                    <a href="{{ route('states.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('states.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-map-marked-alt text-xs mr-3"></i>States/Provinces
                                    </a>
                                    <a href="{{ route('districts.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('districts.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-city text-xs mr-3"></i>Districts/Cities
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profile.*') || request()->routeIs('password.*') ? 'active' : 'text-gray-600 dark:text-gray-400' }}">
                                        <i class="fas fa-user-circle text-xs mr-3"></i>Profile
                                    </a>
                                </div>
                            </div>
                            @endcanany
                            
                            @can('view reminders')
                            <a href="{{ route('reminders.index') }}" class="sidebar-link group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('reminders.*') ? 'active' : 'text-gray-700 dark:text-gray-300' }}">
                                <i class="fas fa-bell mr-3"></i>Reminders
                            </a>
                            @endcan
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="py-2">
                    @if(session('success'))
                        <div class="mx-auto px-2 sm:px-4 mb-4">
                            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg flex items-center" role="alert">
                                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                                <button type="button" class="ml-auto text-green-800 dark:text-green-200 hover:text-green-600 dark:hover:text-green-400" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mx-auto px-2 sm:px-4 mb-4">
                            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg flex items-center" role="alert">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                                <button type="button" class="ml-auto text-red-800 dark:text-red-200 hover:text-red-600 dark:hover:text-red-400" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="w-full px-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js for interactive components -->
    <script type="module">
        import Alpine from 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/module.esm.js';
        import collapse from 'https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/module.esm.js';
        
        Alpine.plugin(collapse);
        window.Alpine = Alpine;
        Alpine.start();
    </script>
    <script>
        // Initialize notifications dropdown data on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Alpine !== 'undefined') {
                // Fetch notification count on load
                fetch('{{ route('notifications.recent') }}')
                    .then(r => r.json())
                    .then(data => {
                        const dropdown = document.querySelector('.notification-dropdown');
                        if (dropdown && dropdown._x_dataStack) {
                            const component = dropdown._x_dataStack[0];
                            component.unreadCount = data.unreadCount;
                        }
                    })
                    .catch(err => console.error('Failed to load notifications:', err));
            }
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Global Delete Confirmation Script -->
    <script>
        $(document).ready(function() {
            // Handle all forms with data-confirm attribute
            $('form[data-confirm]').on('submit', function(e) {
                e.preventDefault();
                var message = $(this).data('confirm');
                var form = this;
                
                // Use jQuery to create a custom confirm dialog
                if (confirm(message)) {
                    // Remove the event handler temporarily and submit
                    $(form).off('submit');
                    form.submit();
                }
            });
            
            // Handle forms with onsubmit that use confirm - replace with data-confirm
            $('form[onsubmit*="confirm"]').each(function() {
                var onsubmit = $(this).attr('onsubmit');
                var match = onsubmit.match(/confirm\('([^']+)'\)/);
                if (match && match[1]) {
                    $(this).attr('data-confirm', match[1]);
                    $(this).removeAttr('onsubmit');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
