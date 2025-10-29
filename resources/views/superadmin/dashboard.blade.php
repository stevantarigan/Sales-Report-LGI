@extends('layouts.app')

@section('title', 'SuperAdmin Dashboard | Sales Management')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Welcome back, ' . auth()->user()->name . '. Here\'s what\'s happening today.')

@section('content')
    <!-- Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card" data-aos="fade-up" data-aos-delay="100">
            <div class="metric-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Users</div>
                <div class="metric-value">{{ $totalUsers }}</div>
                <div class="metric-trend {{ $userGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                    <i class="fas fa-arrow-{{ $userGrowth >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($userGrowth) }}% {{ $userGrowth >= 0 ? 'growth' : 'decline' }}
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="200">
            <div class="metric-icon" style="background: var(--gradient-success);">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Active Users</div>
                <div class="metric-value">{{ $activeUsers }}</div>
                <div class="metric-trend {{ $activeGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                    <i class="fas fa-arrow-{{ $activeGrowth >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($activeGrowth) }}% {{ $activeGrowth >= 0 ? 'growth' : 'decline' }}
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="300">
            <div class="metric-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">New This Month</div>
                <div class="metric-value">{{ $newUsersThisMonth }}</div>
                <div class="metric-trend {{ $monthlyGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                    <i class="fas fa-arrow-{{ $monthlyGrowth >= 0 ? 'up' : 'down' }}"></i>
                    {{ abs($monthlyGrowth) }}% {{ $monthlyGrowth >= 0 ? 'growth' : 'decline' }}
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="400">
            <div class="metric-icon" style="background: var(--gradient-secondary);">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Admin Users</div>
                <div class="metric-value">{{ $adminUsers }}</div>
                <div class="metric-trend {{ $adminGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                    <i class="fas fa-{{ $adminGrowth >= 0 ? 'plus' : 'minus' }}"></i>
                    {{ abs($adminGrowth) }} {{ $adminGrowth >= 0 ? 'more' : 'less' }} than last month
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="feature-grid">
        <div class="feature-card" onclick="window.location.href='{{ route('admin.users.create') }}'" data-aos="zoom-in"
            data-aos-delay="100">
            <div class="feature-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3 class="feature-title">Add New User</h3>
            <p class="feature-description">Create new user accounts with specific roles and permissions for your team
                members.</p>
            <div class="feature-action">
                <span>Add User</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        <div class="feature-card" onclick="window.location.href='{{ route('admin.users.index') }}'" data-aos="zoom-in"
            data-aos-delay="200">
            <div class="feature-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <h3 class="feature-title">Manage Users</h3>
            <p class="feature-description">View, edit, and manage all user accounts, roles, and permissions in one place.
            </p>
            <div class="feature-action">
                <span>Manage</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        <div class="feature-card" onclick="window.location.href='{{ route('products.index') }}'" data-aos="zoom-in"
            data-aos-delay="300">
            <div class="feature-icon">
                <i class="fas fa-box"></i>
            </div>
            <h3 class="feature-title">Product Management</h3>
            <p class="feature-description">Manage your product catalog, inventory, and product information efficiently.</p>
            <div class="feature-action">
                <span>Manage Products</span>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>
    </div>

    <!-- Recent Users Section -->
    <div class="card" data-aos="fade-up" data-aos-delay="400">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-clock"></i>
                Recently Added Users
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="table-header">
                <h3 class="table-title">Latest User Registrations</h3>
                <div class="d-flex gap-3 flex-wrap" style="flex: 1; min-width: 300px;">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchRecentUsers"
                            placeholder="Search recent users...">
                    </div>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('admin.users.index') }}'">
                        <i class="fas fa-list me-2"></i>View All Users
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3"
                                            style="background: {{ $user->is_active ? 'var(--gradient-success)' : 'var(--gradient-secondary)' }};">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $user->name }}</div>
                                            <small class="text-muted">ID:
                                                USR{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role === 'superadmin')
                                        <span class="badge badge-primary">SuperAdmin</span>
                                    @elseif($user->role === 'adminsales')
                                        <span class="badge badge-success">AdminSales</span>
                                    @else
                                        <span class="badge badge-warning">Sales</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-icon-edit" title="Edit User"
                                            onclick="window.location.href='{{ route('admin.users.edit', $user) }}'">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-icon-reset" title="Reset Password"
                                            onclick="resetPassword({{ $user->id }})">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        @if ($user->id !== auth()->id())
                                            <button class="btn-icon btn-icon-delete" title="Delete User"
                                                onclick="confirmDelete({{ $user->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="text-muted">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                    </div>
                    <nav>
                        {{ $users->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key"></i>
                        Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="resetPasswordForm">
                    @csrf
                    <input type="hidden" name="user_id" id="resetPasswordUserId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">New Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter new password"
                                required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm new password" required minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync me-2"></i>Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toggle Status Modal -->
    <div class="modal fade" id="toggleStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-cog"></i>
                        Change User Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="toggleStatusForm">
                    @csrf
                    <input type="hidden" name="user_id" id="toggleStatusUserId">
                    <div class="modal-body">
                        <p>Are you sure you want to change this user's status?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            This will <span id="statusActionText">activate/deactivate</span> the user account.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sync me-2"></i>Change Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Search functionality
        document.getElementById('searchRecentUsers')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value;
                window.location.href = '{{ route('superadmin.welcome') }}?search=' + encodeURIComponent(
                searchTerm);
            }
        });

        // Reset Password Function
        function resetPassword(userId) {
            document.getElementById('resetPasswordUserId').value = userId;
            const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
            modal.show();
        }

        // Toggle Status Function
        function toggleStatus(userId, currentStatus) {
            document.getElementById('toggleStatusUserId').value = userId;
            const actionText = currentStatus ? 'deactivate' : 'activate';
            document.getElementById('statusActionText').textContent = actionText;

            const modal = new bootstrap.Modal(document.getElementById('toggleStatusModal'));
            modal.show();
        }

        // Confirm Delete Function
        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error deleting user');
                    }
                });
            }
        }

        // Handle Reset Password Form Submission
        document.getElementById('resetPasswordForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('admin.users.reset-password') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Password reset successfully');
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'resetPasswordModal'));
                        modal.hide();
                    } else {
                        alert('Error resetting password');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error resetting password');
                });
        });

        // Handle Toggle Status Form Submission
        document.getElementById('toggleStatusForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('admin.users.toggle-status') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User status updated successfully');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('toggleStatusModal'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert('Error updating user status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating user status');
                });
        });
    </script>
@endsection
