<!-- Top Navigation -->
<header class="top-nav">
    <div class="nav-left">
        <button class="sidebar-toggle" id="sidebarToggle" type="button">
            <i class="fas fa-bars"></i>
        </button>
        <div class="nav-title">
            <h1 id="typing-title">@yield('page-title', 'Dashboard Overview')</h1>
            <p>@yield('page-description', 'Welcome back, ' . auth()->user()->name . '. Here\'s what\'s happening today.')</p>
        </div>
    </div>

    <div class="user-menu">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-weight: 600; font-size: 0.9rem;">{{ auth()->user()->name }}</div>
                <div style="font-size: 0.75rem; color: #64748b;">
                    @if (auth()->user()->role === 'superadmin')
                        Super Administrator
                    @elseif(auth()->user()->role === 'adminsales')
                        Admin Sales
                    @else
                        Sales
                    @endif
                </div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </div>
</header>
