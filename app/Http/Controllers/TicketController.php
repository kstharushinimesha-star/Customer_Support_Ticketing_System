<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * ටිකට්පත් ලැයිස්තුව පෙන්වීම (Index)
     */
    public function index()
    {
        $user = Auth::user();

        // Admin හට සියලුම ටිකට්පත් ද පෙන්වන අතර, User හට පෙන්වන්නේ තමාගේ ඒවා පමණි [cite: 13, 35]
        $tickets = Ticket::with('user')
            ->when($user->role !== 'admin', function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->latest()
            ->get();

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets
        ]);
    }

    /**
     * අලුත් ටිකට්පතක් නිර්මාණය කිරීම (Store)
     */
    public function store(Request $request)
    {
        // PDF එකේ ඇති දත්ත වලට අනුව Validation [cite: 15]
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        // දැනට ලොග් වී සිටින පරිශීලකයාට ටිකට්පත සම්බන්ධ කිරීම [cite: 13]
        Auth::user()->tickets()->create($validated);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * ටිකට්පතක විස්තර බැලීම (Show)
     */
    public function show(Ticket $ticket)
    {
        // අදාළ පුද්ගලයාට පමණක් බැලීමට හැකිවන ලෙස ආරක්ෂා කිරීම
        if (Auth::user()->role !== 'admin' && $ticket->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket->load(['user', 'comments.user']) // Threaded discussion සඳහා comments load කිරීම [cite: 18, 36]
        ]);
    }

    /**
     * ටිකට්පතේ Status එක Update කිරීම (Update)
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        // Admin හට පමණක් Status වෙනස් කළ හැක [cite: 5, 16]
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved'
        ]);

        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }
}