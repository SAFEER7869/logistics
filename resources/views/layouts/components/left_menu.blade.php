<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
      <img src="{{ asset('img/avatars/logo.png') }}" style="width: 90px; height: auto;">
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Admins -->
    <li class="menu-item {{ request()->is('admin/admins*') ? ' active' : '' }}">
      <a href="{{ route('admins.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user-circle"></i>
        <div data-i18n="Admins">Admins</div>
      </a>
    </li>

    <!-- Dashboard -->
    <li class="menu-item {{ request()->is('admin/pickups*') ? ' active' : '' }}">
      <a href="{{ route('pickups.index') }}" class="menu-link">
     <i class="menu-icon tf-icons ti ti-truck"></i>
        <div data-i18n="Pickups">Pickups</div>
      </a>
    </li>

    <!-- Employees
    <li class="menu-item {{ request()->is('admin/employees*') ? ' active' : '' }}">
      <a href="{{ route('employees.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Employees">Employees</div>
      </a>
    </li>-->






  </ul>
</aside>
