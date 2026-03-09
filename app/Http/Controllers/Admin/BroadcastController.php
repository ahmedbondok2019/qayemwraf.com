<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\User;
use App\Notifications\CampaignNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class BroadcastController extends Controller
{
    public function index()
    {
        $broadcasts = Broadcast::latest()->paginate(10);
        return view('dashboard.admin.broadcasts.index', compact('broadcasts'));
    }

    public function create()
    {
        return view('dashboard.admin.broadcasts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'audience' => 'required|string',
            'channels' => 'required|array',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'schedule_at' => 'nullable|date|after:now',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('broadcasts', 'public');
        }

        $broadcast = Broadcast::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'link' => $request->input('link'),
            'audience' => $request->input('audience'),
            'channels' => $request->input('channels'),
            'status' => $request->input('schedule_at') ? 'scheduled' : 'sent',
            'scheduled_at' => $request->input('schedule_at'),
        ]);

        if (!$request->input('schedule_at')) {
            $this->sendBroadcast($broadcast);
        }

        return redirect()->route('admin.broadcasts.index')->with('success', 'Broadcast campaign created successfully!');
    }

    private function sendBroadcast(Broadcast $broadcast)
    {
        $users = User::query();

        switch ($broadcast->audience) {
            case 'new':
                $users->where('created_at', '>=', now()->subDays(30));
                break;
            case 'returning':
                $users->has('orders', '>', 1);
                break;
            case 'top_spenders':
                $users->withSum('orders', 'total')->orderByDesc('orders_sum_total')->take(100);
                break;
            case 'active_orders':
                $users->whereHas('orders', function ($q) {
                    $q->whereIn('status', ['pending', 'processing', 'shipped']);
                });
                break;
            case 'potential':
                $users->has('cartItems')->doesntHave('orders');
                break;
        }

        $targets = $users->get();
        $broadcast->update(['sent_count' => $targets->count()]);

        Notification::send($targets, new CampaignNotification($broadcast));
    }

    public function trackClick($id)
    {
        $broadcast = Broadcast::findOrFail($id);
        $broadcast->increment('clicks_count');
        
        if ($broadcast->link) {
            return redirect()->away($broadcast->link);
        }
        
        return redirect()->route('frontend.index');
    }

    public function destroy(Broadcast $broadcast)
    {
        if ($broadcast->image) {
            Storage::disk('public')->delete($broadcast->image);
        }
        $broadcast->delete();
        return redirect()->route('admin.broadcasts.index')->with('success', 'Broadcast deleted successfully!');
    }
}
