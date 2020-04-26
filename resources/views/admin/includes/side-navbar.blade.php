<!-- Sidebar -->

<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="{{route('displayAdmin')}}">
            <i class="fas fa-fw fa-tachometer-alt clr"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('agents')}}">
            <i class="fas fa-user-secret clr"></i>
            <span>Agents</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('viewRiders')}}">
            <i class="fa fa-motorcycle clr"></i>
            <span>Riders</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('showUserView')}}">
            <i class="fas fa-user-friends clr"></i>
            <span>Users On Portal</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('showVendorView')}}">
            <i class="fas fa-store clr"></i>
            <span>Vendors</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('adDetailView')}}">
            <i class="fas fa-tag clr"></i>
            <span>Advertisement & Details</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('fetchAdDetail')}}">
            <i class="fas fa-flag clr"></i>
            <span>Advertisement Request</span></a>
    </li>
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">--}}
            {{--<i class="fab fa-ravelry clr"></i>--}}
            {{--<span>Traffic & Revenu</span></a>--}}
    {{--</li>--}}
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">--}}
            {{--<i class="fas fa-thumbs-up clr"></i>--}}
            {{--<span>Feedback</span></a>--}}
    {{--</li>--}}
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="#">--}}
            {{--<i class="fas fa-bell fa-fw clr"></i>--}}
            {{--<span>Notifications</span></a>--}}
    {{--</li>--}}
</ul>
