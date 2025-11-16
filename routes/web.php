<?php

declare(strict_types=1);

use App\Http\Controllers\Leads\LeadsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Leads\LeadSourceController;
use App\Http\Controllers\Leads\LeadAgentController;
use App\Http\Controllers\Leads\LeadPriorityController;
use App\Http\Controllers\Leads\LeadTypeController;
use App\Http\Controllers\Leads\LeadAnalyticsController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\RolesController;
use App\Http\Controllers\Users\PermissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Itineraries\ItineraryController;
use App\Http\Controllers\Itineraries\DestinationController;
use App\Http\Controllers\Itineraries\AttractionController;
use App\Http\Controllers\Itineraries\ItineraryBuilderController;
use App\Http\Controllers\FlightTicketsController;
use App\Http\Controllers\LeadItinerariesController;
use App\Http\Controllers\MasterItinerariesController;
use App\Http\Controllers\ItineraryPdfController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Frontend\RhPageController;

// Public marketing pages
Route::get('/', [RhPageController::class, 'home'])->name('rh.home');
Route::get('/rh', function () {
    return redirect()->route('rh.home');
});

Route::prefix('rh')->name('rh.')->group(function () {
    Route::get('/about', [RhPageController::class, 'about'])->name('about');
    Route::get('/contact', [RhPageController::class, 'contact'])->name('contact');
    Route::get('/products', [RhPageController::class, 'products'])->name('products.index');
    Route::get('/products/{product:slug}', [RhPageController::class, 'productDetail'])->name('products.show');
});

// Leads analytics route
Route::get('/leads/analytics', [LeadAnalyticsController::class, 'analytics'])
    ->middleware(['auth'])
    ->name('leads.analytics');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/todos', function () {
        return Inertia::render('todos/Index');
    })->name('todos.index');
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin redirect route
    Route::get('admin', function () {
        return redirect()->route('dashboard');
    })->name('admin');



    // Customer Routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');

    // Task Management Routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        // Main task pages
        Route::get('/', [\App\Http\Controllers\Web\TaskController::class, 'index'])->name('index');
        Route::get('/dashboard', [\App\Http\Controllers\Web\TaskController::class, 'dashboard'])->name('dashboard');
        Route::get('/kanban', [\App\Http\Controllers\Web\TaskController::class, 'kanban'])->name('kanban');
        Route::get('/my-tasks', [\App\Http\Controllers\Web\TaskController::class, 'myTasks'])->name('my-tasks');
        
        // Task CRUD
        Route::get('/create', [\App\Http\Controllers\Web\TaskController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Web\TaskController::class, 'store'])->name('store');
        Route::post('/{task}/toggle-complete', [\App\Http\Controllers\Web\TaskController::class, 'toggleComplete'])->name('toggle-complete');
        Route::get('/{task}', [\App\Http\Controllers\Web\TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [\App\Http\Controllers\Web\TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [\App\Http\Controllers\Web\TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [\App\Http\Controllers\Web\TaskController::class, 'destroy'])->name('destroy');
    });

    

    // Calendar Route
    Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');

    // Lead Management Routes
    Route::resource('leads', LeadsController::class);
    Route::get('leads/export', [LeadsController::class, 'export'])->name('leads.export');
    Route::post('leads/{lead}/send-itinerary', [LeadsController::class, 'sendItinerary'])->name('leads.send-itinerary');
    Route::post('leads/{lead}/import-master-itinerary', [LeadsController::class, 'importMasterItinerary'])->name('leads.import-master-itinerary');
    Route::post('leads/{lead}/mark-itinerary-sent', [LeadsController::class, 'markItinerarySent'])->name('leads.mark-itinerary-sent');
    Route::post('leads/{lead}/mark-flight-details-sent', [LeadsController::class, 'markFlightDetailsSent'])->name('leads.mark-flight-details-sent');
    Route::post('leads/{lead}/mark-as-lost', [LeadsController::class, 'markAsLost'])->name('leads.mark-as-lost');
    Route::post('leads/{lead}/status', [LeadsController::class, 'updateStatus'])->name('leads.update-status');
    Route::post('api/leads/{lead}/follow-ups', [LeadsController::class, 'storeFollowUp'])->name('leads.follow-ups.store');
    Route::post('api/leads/{lead}/notes', [LeadsController::class, 'storeNote'])->name('leads.notes.store');
    Route::post('api/leads/{lead}/files', [LeadsController::class, 'storeFile'])->name('leads.files.store');
    Route::delete('api/leads/{lead}/files/{file}', [LeadsController::class, 'deleteFile'])->name('leads.files.delete');
    
    // Flight Tickets Routes
    Route::get('flight-tickets/create', [FlightTicketsController::class, 'create'])->name('flight-tickets.create');
    Route::post('flight-tickets', [FlightTicketsController::class, 'store'])->name('flight-tickets.store');
    Route::get('flight-tickets/{flightTicket}', [FlightTicketsController::class, 'show'])->name('flight-tickets.show');
    Route::get('flight-tickets/{flightTicket}/edit', [FlightTicketsController::class, 'edit'])->name('flight-tickets.edit');
    Route::put('flight-tickets/{flightTicket}', [FlightTicketsController::class, 'update'])->name('flight-tickets.update');
    Route::delete('flight-tickets/{flightTicket}', [FlightTicketsController::class, 'destroy'])->name('flight-tickets.destroy');
    
    // Flight Ticket File Routes
    Route::post('flight-tickets/{flightTicket}/files', [FlightTicketsController::class, 'storeFiles'])->name('flight-tickets.files.store');
    Route::delete('flight-tickets/{flightTicket}/files/{file}', [FlightTicketsController::class, 'deleteFile'])->name('flight-tickets.files.delete');
    Route::get('flight-tickets/{flightTicket}/files/{file}/download', [FlightTicketsController::class, 'downloadFile'])->name('flight-tickets.files.download');
    
    // Lead Itineraries Routes
    Route::get('lead-itineraries/create', [LeadItinerariesController::class, 'create'])->name('lead-itineraries.create');
    Route::post('lead-itineraries', [LeadItinerariesController::class, 'store'])->name('lead-itineraries.store');
    Route::get('lead-itineraries/{itinerary}', [LeadItinerariesController::class, 'show'])->name('lead-itineraries.show');
    
    // Master Itineraries Routes
    Route::get('master-itineraries', [MasterItinerariesController::class, 'index'])->name('master-itineraries.index');
    Route::get('master-itineraries/{itinerary}', [MasterItinerariesController::class, 'show'])->name('master-itineraries.show');
    Route::post('master-itineraries/{itinerary}/create-custom', [MasterItinerariesController::class, 'createCustom'])->name('master-itineraries.create-custom');
    Route::post('itineraries/{itinerary}/mark-master', [MasterItinerariesController::class, 'markAsMaster'])->name('itineraries.mark-master');
    Route::post('itineraries/{itinerary}/unmark-master', [MasterItinerariesController::class, 'unmarkAsMaster'])->name('itineraries.unmark-master');
    
    // Itinerary Routes
    Route::resource('itineraries', \App\Http\Controllers\Itineraries\ItineraryController::class);
    
    // AI Routes
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('itinerary-builder', [\App\Http\Controllers\AI\AIItineraryController::class, 'index'])->name('itinerary-builder');
        Route::post('generate-itinerary', [\App\Http\Controllers\AI\AIItineraryController::class, 'generateItinerary'])->name('generate-itinerary');
        Route::post('save-itinerary', [\App\Http\Controllers\AI\AIItineraryController::class, 'saveItinerary'])->name('save-itinerary');
    });
    
    // PDF Routes
    Route::get('itineraries/{itinerary}/pdf', [ItineraryPdfController::class, 'generate'])->name('itineraries.pdf');
    Route::get('itineraries/{itinerary}/pdf/view', [ItineraryPdfController::class, 'view'])->name('itineraries.pdf.view');
    
    // Itinerary Builder
    Route::get('/itinerary-builder', function () {
        return Inertia::render('ItineraryBuilder');
    })->name('itinerary-builder');
    
    // Lead Sources
    Route::resource('lead-sources', LeadSourceController::class)->except(['show']);
    Route::resource('lead-types', LeadTypeController::class)->except(['show']);
    
    // Lead Agents
    Route::resource('lead-agents', LeadAgentController::class)->except(['show', 'edit', 'update']);
    Route::get('lead-agents/{agent}', [LeadAgentController::class, 'show'])->name('lead-agents.show');
    Route::post('lead-agents/{agent}/toggle-status', [LeadAgentController::class, 'toggleStatus'])->name('lead-agents.toggle-status');

    // Lead Priorities
    Route::resource('lead-priorities', LeadPriorityController::class)->except(['show']);
    Route::post('lead-priorities/reorder', [LeadPriorityController::class, 'reorder'])->name('lead-priorities.reorder');
    Route::post('lead-priorities/{priority}/move-up', [LeadPriorityController::class, 'moveUp'])->name('lead-priorities.move-up');
    Route::post('lead-priorities/{priority}/move-down', [LeadPriorityController::class, 'moveDown'])->name('lead-priorities.move-down');

    // Itinerary Builder Routes
    Route::prefix('itineraries')->name('itineraries.')->group(function () {
        // Regular Itinerary Routes
        Route::get('/', [ItineraryController::class, 'index'])->name('index');
        Route::get('/create', [ItineraryController::class, 'create'])->name('create');
        
        Route::get('/{itinerary}', [ItineraryController::class, 'show'])->name('show');
        
        // Itinerary Builder Wizard
        Route::prefix('builder')->name('builder.')->group(function () {
            Route::get('/create', [ItineraryBuilderController::class, 'create'])->name('create');
            Route::post('/', [ItineraryBuilderController::class, 'store'])->name('store');
            
            // Edit wizard routes
            Route::get('/{itinerary}/edit', [ItineraryBuilderController::class, 'edit'])
                ->name('edit')
                ->middleware('can:update,itinerary');
                
            Route::put('/{itinerary}', [ItineraryBuilderController::class, 'update'])
                ->name('update')
                ->middleware('can:update,itinerary');
                
            Route::post('/{itinerary}/publish', [ItineraryBuilderController::class, 'publish'])
                ->name('publish')
                ->middleware('can:update,itinerary');
        });
        
        // Export routes
        Route::prefix('export')->group(function () {
            Route::get('/', [ItineraryController::class, 'export'])->name('export');
        });
        
        // Other itinerary routes (if any)
        Route::delete('/{itinerary}', [ItineraryController::class, 'destroy'])->name('destroy');

        
        
    });
    

    
    // Reminder Routes
    Route::resource('reminders', ReminderController::class);
    Route::post('/reminders/{reminder}/complete', [ReminderController::class, 'complete'])
        ->name('reminders.complete');
    
    // Notification Routes
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'list'])->name('notifications.index');
    Route::get('/api/notifications/recent', [\App\Http\Controllers\NotificationController::class, 'recent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    // User Management Routes
    Route::middleware(['can:view users'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        // Staff Performance Routes
        Route::get('/staff-performance', [\App\Http\Controllers\StaffPerformanceController::class, 'index'])->name('staff-performance.index');
        Route::get('/staff-performance/{user}', [\App\Http\Controllers\StaffPerformanceController::class, 'show'])->name('staff-performance.show');
        
        // Roles and Permissions
        // Controllers handle authorization checks internally
        Route::resource('roles', RolesController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
    });

    // Campaign Routes
    Route::resource('campaigns', \App\Http\Controllers\Web\CampaignController::class);
    Route::delete('/campaigns/{campaign}/contacts/{contact}', [\App\Http\Controllers\Web\CampaignController::class, 'deleteContact'])->name('campaigns.contacts.delete');
    Route::post('/campaigns/{campaign}/contacts/{contact}/select-winner', [\App\Http\Controllers\Web\CampaignController::class, 'selectWinner'])->name('campaigns.contacts.select-winner');


    // Master Data Routes
    Route::resource('countries', \App\Http\Controllers\CountryController::class);
    Route::post('/countries/{country}/toggle-active', [\App\Http\Controllers\CountryController::class, 'toggleActive'])->name('countries.toggle-active');
    
    Route::resource('states', \App\Http\Controllers\StateController::class);
    Route::post('/states/{state}/toggle-active', [\App\Http\Controllers\StateController::class, 'toggleActive'])->name('states.toggle-active');
    
    Route::resource('districts', \App\Http\Controllers\DistrictController::class);
    Route::post('/districts/{district}/toggle-active', [\App\Http\Controllers\DistrictController::class, 'toggleActive'])->name('districts.toggle-active');
    
    // Projects Routes
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::get('/projects/export', [\App\Http\Controllers\ProjectController::class, 'export'])->name('projects.export');

    // Project Contacts Routes
    Route::resource('project-contacts', \App\Http\Controllers\ProjectContactController::class)->only(['store', 'edit', 'update', 'destroy']);

    // Visit Reports Routes
    Route::get('/visit-reports/analytics', [\App\Http\Controllers\VisitReportController::class, 'analytics'])->name('visit-reports.analytics');
    Route::resource('visit-reports', \App\Http\Controllers\VisitReportController::class);
    
    // Products Routes
    Route::get('/products/analytics', [\App\Http\Controllers\ProductController::class, 'analytics'])->name('products.analytics');
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    
    // Quotations Routes
    Route::resource('quotations', \App\Http\Controllers\QuotationController::class);
    
    // Notes Routes
    Route::resource('notes', \App\Http\Controllers\NoteController::class);
    Route::post('/notes/{note}/toggle-pin', [\App\Http\Controllers\NoteController::class, 'togglePin'])->name('notes.toggle-pin');
    
    // Enquiries Routes
    Route::resource('enquiries', \App\Http\Controllers\EnquiryController::class);
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('destinations', \App\Http\Controllers\Admin\DestinationController::class);
        Route::post('/destinations/{destination}/toggle-active', [\App\Http\Controllers\Admin\DestinationController::class, 'toggleActive'])->name('destinations.toggle-active');
        Route::post('/destinations/{destination}/toggle-featured', [\App\Http\Controllers\Admin\DestinationController::class, 'toggleFeatured'])->name('destinations.toggle-featured');
    });
    
    Route::resource('attractions', \App\Http\Controllers\AttractionController::class);
    Route::post('/attractions/{attraction}/toggle-active', [\App\Http\Controllers\AttractionController::class, 'toggleActive'])->name('attractions.toggle-active');
    Route::post('/attractions/{attraction}/toggle-featured', [\App\Http\Controllers\AttractionController::class, 'toggleFeatured'])->name('attractions.toggle-featured');
    
    Route::resource('hotels', \App\Http\Controllers\HotelController::class);
    Route::post('/hotels/{hotel}/toggle-active', [\App\Http\Controllers\HotelController::class, 'toggleActive'])->name('hotels.toggle-active');
    Route::post('/hotels/{hotel}/toggle-featured', [\App\Http\Controllers\HotelController::class, 'toggleFeatured'])->name('hotels.toggle-featured');
    
    // Branch Routes
    Route::resource('branches', \App\Http\Controllers\BranchController::class);
    Route::post('/branches/{branch}/toggle-status', [\App\Http\Controllers\BranchController::class, 'toggleStatus'])->name('branches.toggle-status');
    
    // Team Routes
    Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class);
    Route::post('/teams/{team}/toggle-status', [\App\Http\Controllers\Admin\TeamController::class, 'toggleStatus'])->name('teams.toggle-status');
    
    // Admin Banner Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Define banners resource with custom update route using POST
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class, [
            'except' => ['update']
        ]);
        
        // Add custom update route using POST (primary)
        Route::post('/banners/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'updatePost'])
            ->name('banners.update');
        
        // Accept PUT/PATCH as well to avoid 405s from clients that still send them
        Route::match(['put', 'patch'], '/banners/{banner}', [\App\Http\Controllers\Admin\BannerController::class, 'updatePost']);
            
        Route::post('/banners/{banner}/toggle-active', [\App\Http\Controllers\Admin\BannerController::class, 'toggleActive'])
            ->name('banners.toggle-active');
        
        // Admin Blog Routes
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
        Route::post('/blogs/{blog}/toggle-featured', [\App\Http\Controllers\Admin\BlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');
        Route::post('/blogs/{blog}/update-status', [\App\Http\Controllers\Admin\BlogController::class, 'updateStatus'])->name('blogs.update-status');
        
        // Admin Testimonial Routes
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        Route::post('/testimonials/{testimonial}/toggle-active', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleActive'])->name('testimonials.toggle-active');
        Route::post('/testimonials/{testimonial}/toggle-featured', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
        Route::post('/testimonials/{testimonial}/toggle-verified', [\App\Http\Controllers\Admin\TestimonialController::class, 'toggleVerified'])->name('testimonials.toggle-verified');
        
        // Admin FAQ Routes
        Route::resource('faqs', \App\Http\Controllers\Admin\FAQController::class);
        Route::post('/faqs/{faq}/toggle-active', [\App\Http\Controllers\Admin\FAQController::class, 'toggleActive'])->name('faqs.toggle-active');
        
        // Admin Contact Routes
        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class);
        Route::post('/contacts/{contact}/update-status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('contacts.update-status');
        Route::post('/contacts/{contact}/update-priority', [\App\Http\Controllers\Admin\ContactController::class, 'updatePriority'])->name('contacts.update-priority');
        Route::post('/contacts/bulk-update', [\App\Http\Controllers\Admin\ContactController::class, 'bulkUpdate'])->name('contacts.bulk-update');
        Route::get('/contacts/export', [\App\Http\Controllers\Admin\ContactController::class, 'export'])->name('contacts.export');
        
        // Admin Newsletter Routes
        Route::resource('newsletters', \App\Http\Controllers\Admin\NewsletterController::class);
        Route::post('/newsletters/{newsletter}/toggle-subscription', [\App\Http\Controllers\Admin\NewsletterController::class, 'toggleSubscription'])->name('newsletters.toggle-subscription');
        Route::post('/newsletters/bulk-update', [\App\Http\Controllers\Admin\NewsletterController::class, 'bulkUpdate'])->name('newsletters.bulk-update');
        Route::get('/newsletters/export', [\App\Http\Controllers\Admin\NewsletterController::class, 'export'])->name('newsletters.export');
    });

});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
