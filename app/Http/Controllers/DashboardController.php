<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Reminder;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Contact;
use App\Models\VisitReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = now();
        $startOfDay = $now->copy()->startOfDay();
        $endOfDay = $now->copy()->endOfDay();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Get leads statistics with visibility rules
        $leadsQuery = Lead::query();
        $this->applyLeadVisibility($leadsQuery, $user);
        
        $totalLeads = (clone $leadsQuery)->count();
        $newLeads = (clone $leadsQuery)
            ->whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->count();
        
        // Get "Convert this week" count (leads with convert_this_week status)
        $convertThisWeekCount = (clone $leadsQuery)
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'convert_this_week');
            })
            ->count();
        
        // Get converted count
        $convertedCount = (clone $leadsQuery)
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'converted');
            })
            ->count();

        // Get tasks statistics
        $pendingTasks = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->count();

        $completedTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->whereDate('completed_at', '>=', $startOfDay)
            ->count();

        // Get reminders (actual reminder records)
        $reminders = Reminder::where('user_id', $user->id)
            ->where('is_completed', false)
            ->where('reminder_at', '>=', $startOfDay)
            ->where('reminder_at', '<=', $endOfDay->copy()->addDay())
            ->orderBy('reminder_at')
            ->limit(5)
            ->get()
            ->map(function ($reminder) {
                $reminderAt = Carbon::parse($reminder->reminder_at);
                return [
                    'id' => $reminder->id,
                    'title' => $reminder->title,
                    'time' => $reminderAt->format('h:i A'),
                    'date' => $reminderAt->isToday() ? 'Today' : ($reminderAt->isTomorrow() ? 'Tomorrow' : $reminderAt->format('M d')),
                ];
            });

        // Get todos (incomplete tasks assigned to user)
        $todos = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->limit(5)
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'completed' => $task->status === 'completed',
                    'due_date' => $task->due_date,
                ];
            });

        // Get leads assigned to current user
        // Apply visibility rules based on user role
        $assignedLeadsQuery = Lead::query();
        $this->applyLeadVisibility($assignedLeadsQuery, $user);
        $assignedLeads = $assignedLeadsQuery
            ->with(['lead_status', 'lead_priority', 'assigned_user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($lead) {
                return [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'company' => $lead->company ?? null,
                    'status' => $lead->lead_status ? $lead->lead_status->name : ($lead->status ?? 'New'),
                    'date' => $lead->created_at->diffForHumans(),
                    'created_at' => $lead->created_at,
                ];
            });

        // Get pending tasks
        $pendingTasksList = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->limit(5)
            ->get()
            ->map(function ($task) {
                $dueDate = $task->due_date ? Carbon::parse($task->due_date) : null;
                $dueText = 'No due date';
                
                if ($dueDate) {
                    if ($dueDate->isToday()) {
                        $dueText = 'Today';
                    } elseif ($dueDate->isTomorrow()) {
                        $dueText = 'Tomorrow';
                    } elseif ($dueDate->isFuture()) {
                        $dueText = 'In ' . $dueDate->diffInDays(now()) . ' days';
                    } else {
                        $dueText = 'Overdue';
                    }
                }

                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'priority' => $task->priority ?? 'medium',
                    'due' => $dueText,
                ];
            });

        // Get projects statistics
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'in_progress')->count();
        $newProjects = Project::whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->count();

        // Get contacts statistics
        $totalContacts = Contact::count();
        $newContacts = Contact::whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->count();
        $urgentContacts = Contact::where('priority', 'urgent')->count();
        $totalCompanies = Contact::whereNotNull('company_name')->distinct('company_name')->count('company_name');

        // Get visit reports statistics
        $totalVisitReports = VisitReport::count();
        $recentVisitReports = VisitReport::whereDate('visit_date', '>=', $startOfDay->copy()->subDays(7))
            ->whereDate('visit_date', '<=', $endOfDay)
            ->count();
        $upcomingMeetings = VisitReport::where('next_meeting_date', '>=', $startOfDay)
            ->where('next_meeting_date', '<=', $endOfDay->copy()->addDays(7))
            ->count();

        // Get projects with upcoming maturity date
        $upcomingMaturityProjects = Project::with('user')
            ->whereNotNull('expected_maturity_date')
            ->where('expected_maturity_date', '>=', $startOfDay)
            ->orderBy('expected_maturity_date')
            ->limit(5)
            ->get();

        // Get quote of the day - Business Quotes
        $businessQuotes = [
            ['text' => "The way to get started is to quit talking and begin doing.", 'author' => "Walt Disney"],
            ['text' => "Don't be afraid to give up the good to go for the great.", 'author' => "John D. Rockefeller"],
            ['text' => "Innovation distinguishes between a leader and a follower.", 'author' => "Steve Jobs"],
            ['text' => "The only way to do great work is to love what you do.", 'author' => "Steve Jobs"],
            ['text' => "Success is not final, failure is not fatal: it is the courage to continue that counts.", 'author' => "Winston Churchill"],
            ['text' => "The future belongs to those who believe in the beauty of their dreams.", 'author' => "Eleanor Roosevelt"],
            ['text' => "The customer's perception is your reality.", 'author' => "Kate Zabriskie"],
            ['text' => "Your most unhappy customers are your greatest source of learning.", 'author' => "Bill Gates"],
            ['text' => "The goal of a company is to have customer service that is not just the best, but legendary.", 'author' => "Sam Walton"],
            ['text' => "Business opportunities are like buses, there's always another one coming.", 'author' => "Richard Branson"],
            ['text' => "The secret of getting ahead is getting started.", 'author' => "Mark Twain"],
            ['text' => "Price is what you pay. Value is what you get.", 'author' => "Warren Buffett"],
            ['text' => "The best time to plant a tree was 20 years ago. The second best time is now.", 'author' => "Chinese Proverb"],
            ['text' => "Success usually comes to those who are too busy to be looking for it.", 'author' => "Henry David Thoreau"],
            ['text' => "The only place where success comes before work is in the dictionary.", 'author' => "Vidal Sassoon"],
            ['text' => "If you are not willing to risk the usual, you will have to settle for the ordinary.", 'author' => "Jim Rohn"],
            ['text' => "The biggest risk is not taking any risk. In a world that's changing really quickly, the only strategy that is guaranteed to fail is not taking risks.", 'author' => "Mark Zuckerberg"],
            ['text' => "I find that the harder I work, the more luck I seem to have.", 'author' => "Thomas Jefferson"],
            ['text' => "People don't buy what you do; they buy why you do it.", 'author' => "Simon Sinek"],
            ['text' => "The best customer service is if the customer doesn't need to call you, doesn't need to talk to you. It just works.", 'author' => "Jeff Bezos"],
            ['text' => "Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work.", 'author' => "Steve Jobs"],
            ['text' => "The greatest glory in living lies not in never falling, but in rising every time we fall.", 'author' => "Nelson Mandela"],
            ['text' => "In the middle of difficulty lies opportunity.", 'author' => "Albert Einstein"],
            ['text' => "The only impossible journey is the one you never begin.", 'author' => "Tony Robbins"],
            ['text' => "Success is walking from failure to failure with no loss of enthusiasm.", 'author' => "Winston Churchill"],
            ['text' => "The customer experience is the next competitive battleground.", 'author' => "Jerry Gregoire"],
            ['text' => "A satisfied customer is the best business strategy of all.", 'author' => "Michael LeBoeuf"],
            ['text' => "Make every detail perfect and limit the number of details to perfect.", 'author' => "Jack Dorsey"],
            ['text' => "The goal isn't to be perfect. The goal is to be better than yesterday.", 'author' => "Unknown"],
            ['text' => "Excellence is not a skill, it's an attitude.", 'author' => "Ralph Marston"],
            ['text' => "The best preparation for tomorrow is doing your best today.", 'author' => "H. Jackson Brown Jr."],
            ['text' => "Believe you can and you're halfway there.", 'author' => "Theodore Roosevelt"],
            ['text' => "The only person you are destined to become is the person you decide to be.", 'author' => "Ralph Waldo Emerson"],
            ['text' => "It does not matter how slowly you go as long as you do not stop.", 'author' => "Confucius"],
            ['text' => "The expert in anything was once a beginner.", 'author' => "Helen Hayes"],
            ['text' => "Focus on being productive instead of busy.", 'author' => "Tim Ferriss"],
            ['text' => "Don't wait for opportunity. Create it.", 'author' => "George Bernard Shaw"],
            ['text' => "The difference between a successful person and others is not a lack of strength, not a lack of knowledge, but rather a lack of will.", 'author' => "Vince Lombardi"],
            ['text' => "The only limit to our realization of tomorrow will be our doubts of today.", 'author' => "Franklin D. Roosevelt"],
            ['text' => "Great things in business are never done by one person. They're done by a team of people.", 'author' => "Steve Jobs"],
            ['text' => "The best way to predict the future is to create it.", 'author' => "Peter Drucker"],
            ['text' => "Your brand is what other people say about you when you're not in the room.", 'author' => "Jeff Bezos"],
            ['text' => "Do what you do so well that they will want to see it again and bring their friends.", 'author' => "Walt Disney"],
            ['text' => "The purpose of a business is to create a customer.", 'author' => "Peter Drucker"],
            ['text' => "If you're not embarrassed by the first version of your product, you've launched too late.", 'author' => "Reid Hoffman"],
            ['text' => "Success is not just about making money. It's about making a difference.", 'author' => "Unknown"],
            ['text' => "The best way to find out if you can trust somebody is to trust them.", 'author' => "Ernest Hemingway"],
            ['text' => "Quality is not an act, it is a habit.", 'author' => "Aristotle"],
            ['text' => "It is during our darkest moments that we must focus to see the light.", 'author' => "Aristotle"],
        ];
        $quoteOfTheDay = $businessQuotes[now()->dayOfYear % count($businessQuotes)];

        return view('admin.dashboard', [
            'stats' => [
                'totalLeads' => $totalLeads,
                'pendingTasks' => $pendingTasks,
                'completedTasks' => $completedTasks,
                'newLeads' => $newLeads,
                'convertThisWeek' => $convertThisWeekCount,
                'converted' => $convertedCount,
                'totalProjects' => $totalProjects,
                'activeProjects' => $activeProjects,
                'newProjects' => $newProjects,
                'totalContacts' => $totalContacts,
                'newContacts' => $newContacts,
                'urgentContacts' => $urgentContacts,
                'totalCompanies' => $totalCompanies,
                'totalVisitReports' => $totalVisitReports,
                'recentVisitReports' => $recentVisitReports,
                'upcomingMeetings' => $upcomingMeetings,
            ],
            'reminders' => $reminders,
            'todos' => $todos,
            'assignedLeads' => $assignedLeads,
            'pendingTasksList' => $pendingTasksList,
            'upcomingMaturityProjects' => $upcomingMaturityProjects,
            'quoteOfTheDay' => $quoteOfTheDay
        ]);
    }

    /**
     * Apply lead visibility rules based on user role.
     * 
     * - Super-admin: sees all leads
     * - Manager: sees all leads in their branches + their assigned leads (even in other branches)
     * - Team lead: sees all leads assigned to their team members + their assigned leads
     * - Agent: sees only their assigned leads
     */
    protected function applyLeadVisibility($query, $user)
    {
        // Super-admin sees all leads
        if ($user->hasRole('super-admin')) {
            return;
        }

        // Manager: sees all leads in their branches + their assigned leads
        if ($user->hasRole('manager')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $query->where(function($q) use ($user, $branchIds) {
                // Leads in manager's branches
                if ($branchIds->isNotEmpty()) {
                    $q->whereIn('branch_id', $branchIds);
                }
                // OR leads assigned to the manager (even in other branches)
                $q->orWhere('assigned_user_id', $user->id);
            });
            return;
        }

        // Team lead: sees all leads assigned to their team members + their assigned leads
        if ($user->hasRole('team-lead')) {
            $teamMemberIds = collect();
            // Get all team members from teams where this user is the team lead
            $ledTeams = $user->ledTeams()->with('users')->get();
            foreach ($ledTeams as $team) {
                $teamMemberIds = $teamMemberIds->merge($team->users->pluck('id'));
            }
            // Remove the team lead's own ID from the list (we'll add it separately)
            $teamMemberIds = $teamMemberIds->unique()->filter(function($id) use ($user) {
                return $id != $user->id;
            });

            $query->where(function($q) use ($user, $teamMemberIds) {
                // Leads assigned to team members
                if ($teamMemberIds->isNotEmpty()) {
                    $q->whereIn('assigned_user_id', $teamMemberIds);
                }
                // OR leads assigned to the team lead
                $q->orWhere('assigned_user_id', $user->id);
            });
            return;
        }

        // Agent: sees only their assigned leads
        $query->where('assigned_user_id', $user->id);
    }

}
