<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-laugh-wink"></i>
            {{-- <img src="{{asset('front_assets/assets/img/Bank-Sampah.png')}}" width="30px"> --}}
        </div>
        <div class="sidebar-brand-text mx-3">MikroApp </div>
    </a>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider my-0"> --}}

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link " href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Hotspot
    </div>

    <li class="nav-item">
        <a class="nav-link" href=" ">
            <i class="fas fa-plus"></i>
            <span>Hotspot Profile</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('hotspot.index') }}">
            <i class="fas fa-recycle"></i>
            <span>User Hotspot</span>
        </a>
    </li>

    {{-- PRODUCT --}}
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Product
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('product.index') }}">
            <i class="fas fa-plus"></i>
            <span>Produk</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rates.index') }}">
            <i class="fas fa-recycle"></i>
            <span>Rate Limit</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('voucher.index') }}">
            <i class="fas fa-recycle"></i>
            <span>Voucher</span>
        </a>
    </li>


    {{-- Config --}}
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Config
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('config.index') }}">
            <i class="fas fa-cogs"></i>
            <span>Mikrotik Config</span>
        </a>
    </li>



</ul>
<!-- End of Sidebar -->
