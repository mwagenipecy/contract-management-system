<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Notification;
use App\Models\Employee;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $type = '';
    
    #[Url]
    public $status = '';
    
    #[Url]
    public $priority = '';
    
    #[Url]
    public $employee_id = '';

    public $selectedNotifications = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'status' => ['except' => ''],
        'priority' => ['except' => ''],
        'employee_id' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedNotifications = $this->notifications->pluck('id')->toArray();
        } else {
            $this->selectedNotifications = [];
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update([
                'status' => 'read',
                'read_at' => now()
            ]);
            session()->flash('message', 'Notification marked as read.');
        }
    }

    public function markAsUnread($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update([
                'status' => 'sent',
                'read_at' => null
            ]);
            session()->flash('message', 'Notification marked as unread.');
        }
    }

    public function bulkMarkAsRead()
    {
        if (!empty($this->selectedNotifications)) {
            Notification::whereIn('id', $this->selectedNotifications)->update([
                'status' => 'read',
                'read_at' => now()
            ]);
            $count = count($this->selectedNotifications);
            $this->selectedNotifications = [];
            $this->selectAll = false;
            session()->flash('message', $count . ' notifications marked as read.');
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedNotifications)) {
            Notification::whereIn('id', $this->selectedNotifications)->delete();
            $count = count($this->selectedNotifications);
            $this->selectedNotifications = [];
            $this->selectAll = false;
            session()->flash('message', $count . ' notifications deleted.');
        }
    }

    public function resendNotification($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            // In a real app, you would trigger the notification sending logic here
            $notification->update([
                'status' => 'sent',
                'sent_at' => now()
            ]);
            session()->flash('message', 'Notification resent successfully.');
        }
    }

    public function getNotificationsProperty()
    {
        return Notification::query()
            ->with(['employee', 'contract'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('message', 'like', '%' . $this->search . '%')
                      ->orWhereHas('employee', function ($eq) {
                          $eq->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->priority, function ($query) {
                $query->where('priority', $this->priority);
            })
            ->when($this->employee_id, function ($query) {
                $query->where('employee_id', $this->employee_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    public function getStatsProperty()
    {
        return [
            'total' => Notification::count(),
            'unread' => Notification::where('status', 'sent')->count(),
            'pending' => Notification::where('status', 'pending')->count(),
            'failed' => Notification::where('status', 'failed')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.notifications.index', [
            'notifications' => $this->notifications,
            'employees' => $this->employees,
            'stats' => $this->stats,
        ]);
    }
}