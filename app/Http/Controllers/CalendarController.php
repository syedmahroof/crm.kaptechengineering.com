<?php

namespace App\Http\Controllers;

use App\Actions\Calendar\GetCalendarDataAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct(
        private GetCalendarDataAction $getCalendarDataAction
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $data = $this->getCalendarDataAction->execute($user);

        return view('admin.calendar.index', $data);
    }
}
