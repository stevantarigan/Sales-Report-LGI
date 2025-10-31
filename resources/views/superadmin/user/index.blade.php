@extends('layouts.app')

@section('title', 'Users Management | SuperAdmin')
@section('page-title', 'User Management')
@section('page-description', 'Kelola pengguna dan akses sistem')

@push('styles')
    <style>
        :root {
            --primary-color: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --transition: all 0.3s ease;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.8rem;
            text-align: center;
            transition: var(--transition);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            background: var(--gradient-primary);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.8rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.2rem;
            align-items: end;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-box {
            position: relative;
            min-width: 320px;
        }

        .search-box input {
            padding-left: 3rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            background: white;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-success {
            background: var(--gradient-success);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* User Avatar */
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
        }

        .user-avatar:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }

        /* Badge Styles */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        .badge-primary {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        /* Status Badge */
        .status-badge.active {
            color: var(--success-color);
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .status-badge.inactive {
            color: var(--error-color);
            font-weight: 600;
            background: rgba(239, 68, 68, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.6rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .btn-icon-view {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .btn-icon-view:hover {
            background: var(--info-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-icon-edit {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

        .btn-icon-edit:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-icon-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-icon-delete:hover {
            background: var(--error-color);
            color: white;
            transform: scale(1.1);
        }

        /* Bulk Actions */
        .bulk-actions {
            background: rgba(79, 70, 229, 0.05);
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
        }

        .bulk-actions:hover {
            background: rgba(79, 70, 229, 0.08);
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.5rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state h4 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: #64748b;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-icon {
                width: 32px;
                height: 32px;
            }
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: var(--gradient-primary);
            color: white;
            border-bottom: none;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 2rem;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 2rem;
        }

        .btn-close {
            filter: invert(1);
        }

        .form-switch .form-check-input {
            width: 3em;
            height: 1.5em;
        }

        .form-switch .form-check-input:checked {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        /* Loading state */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon" style="background: var(--gradient-primary);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalUsers ?? $users->total() }}</div>
            <div class="stat-label">Total Users</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon" style="background: var(--gradient-success);">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-value">{{ $activeUsers ?? $users->where('is_active', true)->count() }}</div>
            <div class="stat-label">Active Users</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-value">{{ $inactiveUsers ?? $users->where('is_active', false)->count() }}</div>
            <div class="stat-label">Inactive Users</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-value">{{ $superAdmins ?? $users->where('role', 'superadmin')->count() }}</div>
            <div class="stat-label">Super Admins</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="filter-row">
                <div>
                    <label class="form-label">Search Users</label>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                <div>
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">All Roles</option>
                        <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Super Admin
                        </option>
                        <option value="adminsales" {{ request('role') == 'adminsales' ? 'selected' : '' }}>Admin Sales
                        </option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-control">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>Email A-Z</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Bar -->
    <div class="action-bar" data-aos="fade-up" data-aos-delay="600">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="quickSearch" class="form-control" placeholder="Quick search...">
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Add New User
            </a>
            <button class="btn btn-primary" onclick="exportUsers()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-container" data-aos="fade-up" data-aos-delay="700">
        @if ($users->count() > 0)
            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">
                        Select All
                    </label>
                </div>
                <select class="form-select form-select-sm" style="width: auto;" onchange="handleBulkAction(this.value)">
                    <option value="">Bulk Actions</option>
                    <option value="activate">Activate</option>
                    <option value="deactivate">Deactivate</option>
                    <option value="delete">Delete</option>
                </select>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" class="form-check-input">
                        </th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                            <td>
                                <input type="checkbox" class="form-check-input user-checkbox"
                                    value="{{ $user->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="user-avatar bg-light d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $user->name }}</div>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                <span
                                    class="badge 
                                    @if ($user->role == 'superadmin') badge-danger
                                    @elseif($user->role == 'adminsales') badge-warning
                                    @else badge-secondary @endif">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                @if ($user->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('M j, Y') : 'Never' }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-icon btn-icon-edit" title="Edit"
                                        data-user-id="{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h4>No users found</h4>
                                    <p>Get started by adding your first user to the system.</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add New User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="pagination-container">
                <div class="text-muted">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </div>
                <nav>
                    {{ $users->links() }}
                </nav>
            </div>
        @endif
    </div>
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                <div class="invalid-feedback" id="name_error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                                <div class="invalid-feedback" id="email_error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="edit_phone" name="phone">
                                <div class="invalid-feedback" id="phone_error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_role" class="form-label">Role *</label>
                                <select class="form-control" id="edit_role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="adminsales">Admin Sales</option>
                                    <option value="sales">Sales</option>
                                </select>
                                <div class="invalid-feedback" id="role_error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active"
                                        value="1">
                                    <label class="form-check-label" for="edit_is_active">Active User</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body p-3">
                                        <small class="text-muted">
                                            <strong>Last Login:</strong>
                                            <span id="last_login_text">Never</span>
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <strong>Created:</strong>
                                            <span id="created_at_text">-</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Section (Optional) -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Change Password (Optional)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="edit_password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="edit_password"
                                                    name="password" placeholder="Leave blank to keep current password">
                                                <div class="invalid-feedback" id="password_error"></div>
                                                <small class="form-text text-muted">Minimal 8 characters</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="edit_password_confirmation" class="form-label">Confirm
                                                    Password</label>
                                                <input type="password" class="form-control"
                                                    id="edit_password_confirmation" name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updateUserBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            let currentUserId = null;

            // Get CSRF token safely
            function getCsrfToken() {
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                if (csrfMeta) {
                    return csrfMeta.getAttribute('content');
                }

                // Fallback: check for CSRF token in form input
                const csrfInput = document.querySelector('input[name="_token"]');
                if (csrfInput) {
                    return csrfInput.value;
                }

                console.warn('CSRF token not found');
                return '';
            }

            // Edit button click handler
            document.addEventListener('click', function(e) {
                const editButton = e.target.closest('.btn-icon-edit');
                if (editButton) {
                    e.preventDefault();
                    const userId = editButton.getAttribute('data-user-id');

                    if (userId) {
                        loadUserData(userId);
                    }
                }
            });

            // Load user data for editing - FIXED VERSION
            function loadUserData(userId) {
                console.log('Loading user data for ID:', userId);

                // Ambil data dari row table
                const row = document.querySelector(`.user-checkbox[value="${userId}"]`)?.closest('tr');
                if (!row) {
                    alert('User data not found in table');
                    return;
                }

                // Debug: Check semua cell
                console.log('All cells:');
                const cells = row.querySelectorAll('td');
                cells.forEach((cell, index) => {
                    console.log(`Cell ${index}:`, cell.textContent.trim());
                });

                // Ambil name dengan cara yang lebih reliable
                const nameCell = row.querySelector('td:nth-child(2)');
                let userName = '';

                if (nameCell) {
                    const nameDiv = nameCell.querySelector('div div:first-child');
                    if (nameDiv) {
                        userName = nameDiv.textContent.trim();
                    } else {
                        // Jika struktur berbeda, ambil semua text dan filter
                        const allText = nameCell.textContent.trim();
                        // Hapus "ID: xxxx" jika ada
                        userName = allText.replace(/ID:\s*\d+/, '').trim();
                    }
                }

                // Ambil email
                const emailCell = row.querySelector('td:nth-child(3)');
                const userEmail = emailCell ? emailCell.textContent.trim() : '';

                // Ambil role dari badge
                const roleBadge = row.querySelector('.badge');
                const userRole = roleBadge ? roleBadge.textContent.trim().toLowerCase() : '';

                // Ambil status
                const statusBadge = row.querySelector('.status-badge');
                const isActive = statusBadge ? statusBadge.textContent.trim() === 'Active' : false;

                console.log('Extracted data:', {
                    userName,
                    userEmail,
                    userRole,
                    isActive
                });

                // Isi form fields
                document.getElementById('edit_name').value = userName;
                document.getElementById('edit_email').value = userEmail;
                document.getElementById('edit_role').value = userRole;
                document.getElementById('edit_is_active').checked = isActive;

                // Set phone kosong dulu, akan diisi via AJAX
                document.getElementById('edit_phone').value = '';

                // Set form action
                document.getElementById('editUserForm').action = `/admin/users/${userId}`;

                // Clear previous errors
                clearErrors();

                // Show modal
                editUserModal.show();

                // Load detailed user data via AJAX untuk dapat phone number dan info lainnya
                loadUserDetails(userId);
            }

            // Load user details via AJAX untuk dapat phone number
            async function loadUserDetails(userId) {
                try {
                    console.log('Loading detailed data for user:', userId);

                    const response = await fetch(`/admin/users/${userId}/edit`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        }
                    });

                    if (response.ok) {
                        const userData = await response.json();
                        console.log('Detailed user data:', userData);

                        // Update form dengan data dari AJAX
                        if (userData.phone) {
                            document.getElementById('edit_phone').value = userData.phone;
                        }

                        // Update informasi tambahan
                        if (userData.last_login_at) {
                            const lastLogin = new Date(userData.last_login_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            document.getElementById('last_login_text').textContent = lastLogin;
                        } else {
                            document.getElementById('last_login_text').textContent = 'Never';
                        }

                        if (userData.created_at) {
                            const createdAt = new Date(userData.created_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            document.getElementById('created_at_text').textContent = createdAt;
                        }

                        // Pastikan role sesuai
                        if (userData.role) {
                            document.getElementById('edit_role').value = userData.role;
                        }

                    } else {
                        console.warn('Failed to load user details, status:', response.status);
                    }
                } catch (error) {
                    console.error('Error loading user details:', error);
                    // Continue without detailed data
                }
            }

            // Form submission handler - FIXED VERSION
            document.getElementById('editUserForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    showLoading(true, 'updateUserBtn');
                    clearErrors();

                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');

                    const csrfToken = getCsrfToken();
                    if (!csrfToken) {
                        throw new Error('CSRF token not found');
                    }

                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });

                    const contentType = response.headers.get('content-type');

                    // Handle JSON response
                    if (contentType && contentType.includes('application/json')) {
                        const data = await response.json();

                        if (response.ok) {
                            // Success response
                            showNotification(data.message || 'User updated successfully!', 'success');
                            editUserModal.hide();

                            // Reload page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);

                        } else {
                            // Error response dengan validasi
                            if (data.errors) {
                                displayErrors(data.errors);
                            } else {
                                showNotification(data.message || 'Failed to update user', 'error');
                            }
                        }
                    } else {
                        // Handle non-JSON response (redirect response)
                        if (response.ok) {
                            // Jika response adalah redirect, reload page
                            showNotification('User updated successfully!', 'success');
                            editUserModal.hide();
                            window.location.reload();
                        } else {
                            // Handle other non-JSON errors
                            const errorText = await response.text();
                            console.error('Non-JSON error response:', errorText);
                            showNotification('Failed to update user. Please try again.', 'error');
                        }
                    }

                } catch (error) {
                    console.error('Error updating user:', error);
                    showNotification('An error occurred while updating user: ' + error.message,
                    'error');
                } finally {
                    showLoading(false, 'updateUserBtn');
                }
            });

            // Helper functions
            function clearErrors() {
                const errorElements = document.querySelectorAll('.invalid-feedback');
                const inputElements = document.querySelectorAll('.is-invalid');

                errorElements.forEach(el => el.textContent = '');
                inputElements.forEach(el => el.classList.remove('is-invalid'));
            }

            function displayErrors(errors) {
                for (const [field, messages] of Object.entries(errors)) {
                    const input = document.querySelector(`[name="${field}"]`);
                    const errorElement = document.getElementById(`${field}_error`);

                    if (input && errorElement) {
                        input.classList.add('is-invalid');
                        errorElement.textContent = messages[0];
                    }
                }
            }

            function showLoading(show, buttonId) {
                const button = document.getElementById(buttonId);
                if (!button) {
                    console.error('Button not found:', buttonId);
                    return;
                }

                if (show) {
                    button.disabled = true;
                    button.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status"></span> Updating...';
                } else {
                    button.disabled = false;
                    button.innerHTML =
                        '<span class="spinner-border spinner-border-sm d-none" role="status"></span> Update User';
                }
            }

            function showNotification(message, type) {
                // Remove existing notifications
                const existingAlerts = document.querySelectorAll('.alert.position-fixed');
                existingAlerts.forEach(alert => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                });

                // Create new notification
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'} me-2"></i>
                    <div>${message}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            `;
                document.body.appendChild(alertDiv);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.parentNode.removeChild(alertDiv);
                    }
                }, 5000);
            }

            // Quick search functionality
            const quickSearch = document.getElementById('quickSearch');
            if (quickSearch) {
                quickSearch.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Select all functionality
            const selectAll = document.getElementById('selectAll');
            if (selectAll) {
                selectAll.addEventListener('change', function(e) {
                    const checkboxes = document.querySelectorAll('.user-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = e.target.checked;
                    });
                });
            }

            // Initialize edit buttons with data attributes
            function initializeEditButtons() {
                const editButtons = document.querySelectorAll('.btn-icon-edit');
                editButtons.forEach(button => {
                    const row = button.closest('tr');
                    if (row) {
                        const checkbox = row.querySelector('.user-checkbox');
                        if (checkbox) {
                            const userId = checkbox.value;
                            button.setAttribute('data-user-id', userId);
                        }
                    }
                });
            }

            // Initialize on page load
            initializeEditButtons();

            // Add CSRF token to all fetch requests globally
            const originalFetch = window.fetch;
            window.fetch = function(...args) {
                const [url, options = {}] = args;

                // Only add CSRF token to same-origin requests
                if (typeof url === 'string' && url.startsWith('/')) {
                    options.headers = {
                        ...options.headers,
                        'X-CSRF-TOKEN': getCsrfToken()
                    };
                }

                return originalFetch.call(this, url, options);
            };
        });

        function handleBulkAction(action) {
            const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedUsers.length === 0) {
                showNotification('Please select at least one user.', 'error');
                return;
            }

            if (action === 'delete') {
                if (!confirm(`Are you sure you want to delete ${selectedUsers.length} user(s)?`)) {
                    return;
                }
            }

            console.log('Bulk action:', action, 'on users:', selectedUsers);

            // Implement bulk action logic here
            showNotification(`Bulk action "${action}" would be performed on ${selectedUsers.length} users`, 'info');
        }

        function exportUsers() {
            showNotification('Export functionality would be implemented here', 'info');
        }

        // Global helper function untuk notifications
        function showNotification(message, type = 'info') {
            const alertClass = type === 'success' ? 'alert-success' :
                type === 'error' ? 'alert-danger' : 'alert-info';
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                             type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 5000);
        }
    </script>
@endpush
