<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">
                <img src="{{ asset('admin/assets/img/' . auth()->user()->avatar . '') }}" alt="img">
            </a>
            <a href="{{ route('admin.profile') }}" class="simple-text logo-normal">
                {{ auth()->user()->name }}
            </a>
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    Dashboard
                </a>
            </li>
            @if (auth()->user()->role == 1)
                <li>
                    <a href="{{ route('admin.users') }}">
                        <i class="tim-icons icon-single-02 "></i>
                        Users
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ route('admin.posts') }}">
                    <i class="tim-icons icon-paper"></i>
                    Posts
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories') }}">
                    <i class="tim-icons icon-components "></i>
                    Category
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="tim-icons icon-world"></i>
                    Support
                </a>
            </li>
        </ul>
    </div>
</div>
