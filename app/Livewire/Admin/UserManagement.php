<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAccountCreated;
use Illuminate\Support\Str;

class UserManagement extends Component
{
    use WithPagination;

    // User form properties
    public $userId = null;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';
    public $status = 'active';
    public $department_id = '';
    public $position = '';
    public $employee_id = '';
    
    // UI states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showViewModal = false;
    public $isEditing = false;
    public $selectedUser = null;
    
    // Filters and search
    public $search = '';
    public $statusFilter = 'all';
    public $roleFilter = 'all';
    public $departmentFilter = 'all';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Bulk actions
    public $selectedUsers = [];
    public $selectAll = false;
    public $bulkAction = '';
    
    // Messages
    public $successMessage = '';
    public $errorMessage = '';

    protected $listeners = [
        'userDeleted' => 'refreshComponent',
        'userUpdated' => 'refreshComponent'
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->userId)
            ],
            'phone' => 'nullable|string|max:20',
            'password' => $this->isEditing ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'role' => 'required|in:admin,manager,user,hr',
            'status' => 'required|in:active,inactive,suspended',
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'nullable|string|max:255',
            'employee_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('users')->ignore($this->userId)
            ]
        ];
    }

    protected $messages = [
        'name.required' => 'Full name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email address is already registered.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
        'employee_id.unique' => 'This employee ID is already in use.'
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function updatedDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedUsers = $this->users->pluck('id')->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->status = $user->status;
        $this->department_id = $user->department_id;
        $this->position = $user->position;
        $this->employee_id = $user->employee_id;
        $this->password = '';
        $this->password_confirmation = '';
        $this->isEditing = true;
        $this->showEditModal = true;
    }

    public function openViewModal($userId)
    {
        $this->selectedUser = User::with(['department', 'createdBy', 'updatedBy'])
                                 ->findOrFail($userId);
        $this->showViewModal = true;
    }

    public function openDeleteModal($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->showDeleteModal = true;
    }

    public function createUser()
    {
        $this->validate();

        try {
            // Generate random password if not provided
            $password = $this->password ?: Str::random(12);
            
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($password),
                'role' => $this->role,
                'status' => $this->status,
                'department_id' => $this->department_id ?: null,
                'position' => $this->position,
                'employee_id' => $this->employee_id,
                'created_by' => auth()->id(),
                'email_verified_at' => now(), // Auto-verify admin created users
            ]);

            // Send welcome email with credentials
            try {
                Mail::to($user->email)->send(new UserAccountCreated($user, $password));
            } catch (\Exception $e) {
                \Log::warning('Failed to send welcome email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);
            }

            $this->successMessage = 'User created successfully! Welcome email sent to ' . $user->email;
            $this->resetForm();
            $this->showCreateModal = false;
            $this->resetPage();

        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to create user: ' . $e->getMessage();
        }
    }

    public function updateUser()
    {
        $this->validate();

        try {
            $user = User::findOrFail($this->userId);
            
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'status' => $this->status,
                'department_id' => $this->department_id ?: null,
                'position' => $this->position,
                'employee_id' => $this->employee_id,
                'updated_by' => auth()->id(),
            ];

            // Only update password if provided
            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($this->password);
            }

            $user->update($updateData);

            $this->successMessage = 'User updated successfully!';
            $this->resetForm();
            $this->showEditModal = false;

        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to update user: ' . $e->getMessage();
        }
    }

    public function deleteUser()
    {
        try {
            if ($this->selectedUser->id === auth()->id()) {
                $this->errorMessage = 'You cannot delete your own account.';
                return;
            }

            $this->selectedUser->delete();
            $this->successMessage = 'User deleted successfully!';
            $this->showDeleteModal = false;
            $this->selectedUser = null;
            $this->resetPage();

        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to delete user: ' . $e->getMessage();
        }
    }

    public function toggleUserStatus($userId)
    {
        try {
            $user = User::findOrFail($userId);
            
            if ($user->id === auth()->id()) {
                $this->errorMessage = 'You cannot change your own status.';
                return;
            }

            $newStatus = $user->status === 'active' ? 'inactive' : 'active';
            $user->update(['status' => $newStatus]);

            $this->successMessage = "User status changed to {$newStatus}!";

        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to update user status: ' . $e->getMessage();
        }
    }

    public function executeBulkAction()
    {
        if (empty($this->selectedUsers) || empty($this->bulkAction)) {
            $this->errorMessage = 'Please select users and an action.';
            return;
        }

        try {
            $count = 0;
            $users = User::whereIn('id', $this->selectedUsers)
                        ->where('id', '!=', auth()->id()) // Exclude current user
                        ->get();

            switch ($this->bulkAction) {
                case 'activate':
                    $users->each(function ($user) use (&$count) {
                        $user->update(['status' => 'active']);
                        $count++;
                    });
                    $this->successMessage = "{$count} users activated successfully!";
                    break;

                case 'deactivate':
                    $users->each(function ($user) use (&$count) {
                        $user->update(['status' => 'inactive']);
                        $count++;
                    });
                    $this->successMessage = "{$count} users deactivated successfully!";
                    break;

                case 'delete':
                    $users->each(function ($user) use (&$count) {
                        $user->delete();
                        $count++;
                    });
                    $this->successMessage = "{$count} users deleted successfully!";
                    break;

                default:
                    $this->errorMessage = 'Invalid bulk action selected.';
                    return;
            }

            $this->selectedUsers = [];
            $this->selectAll = false;
            $this->bulkAction = '';
            $this->resetPage();

        } catch (\Exception $e) {
            $this->errorMessage = 'Bulk action failed: ' . $e->getMessage();
        }
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'user';
        $this->status = 'active';
        $this->department_id = '';
        $this->position = '';
        $this->employee_id = '';
        $this->isEditing = false;
        $this->selectedUser = null;
        $this->errorMessage = '';
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->showViewModal = false;
        $this->resetForm();
    }

    public function refreshComponent()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        $query = User::with(['department'])
                    ->when($this->search, function ($query) {
                        $query->where(function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%')
                              ->orWhere('email', 'like', '%' . $this->search . '%')
                              ->orWhere('employee_id', 'like', '%' . $this->search . '%')
                              ->orWhere('phone', 'like', '%' . $this->search . '%');
                        });
                    })
                    ->when($this->statusFilter !== 'all', function ($query) {
                        $query->where('status', $this->statusFilter);
                    })
                    ->when($this->roleFilter !== 'all', function ($query) {
                        $query->where('role', $this->roleFilter);
                    })
                    ->when($this->departmentFilter !== 'all', function ($query) {
                        $query->where('department_id', $this->departmentFilter);
                    })
                    ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getDepartmentsProperty()
    {
        return Department::get();
    }

    public function getUserStatsProperty()
    {
        return [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'managers' => User::where('role', 'manager')->count(),
            'users' => User::where('role', 'user')->count(),
            'hr' => User::where('role', 'hr')->count(),
        ];
    }

    public function getRoleOptionsProperty()
    {
        return [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'hr' => 'HR Manager',
            'user' => 'User'
        ];
    }

    public function getStatusOptionsProperty()
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'suspended' => 'Suspended'
        ];
    }

    public function render()
    {
        return view('livewire.admin.user-management');
    }
}