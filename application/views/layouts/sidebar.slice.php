@php
$sidebarItems = [
    // [
    //     'name' => 'Reservation',
    //     'url' => '',
    //     'icon' => 'fas fa-calendar-plus'
    // ],
    // [
    //     'name' => 'Widgets',
    //     'url' => '',
    //     'icon' => 'fas fa-th',
    //     'badge' => [ 
    //         'text' => 'New', 
    //         'class' => 'badge-danger' 
    //     ],
    // ],
    // [
    //     'name' => 'Forms',
    //     'icon' => 'fas fa-edit',
    //     'submenu' => [ 
    //         [
    //             'name' => 'General Elements',
    //             'url' => ''
    //         ],
    //         [
    //             'name' => 'Advanced Elements',
    //             'url' => ''
    //         ],
    //         [
    //             'name' => 'Editors',
    //             'url' => ''
    //         ],
    //         [
    //             'name' => 'Validation',
    //             'url' => ''
    //         ]
    //     ]
    // ],
    [
        'name' => 'Reservation',
        'url' => 'reservation',
        'icon' => 'fa fa-calendar-day',
    ],
    [
        'name' => 'Room',
        'url' => 'room',
        'icon' => 'fa fa-bed',
    ],
    [
        'name' => 'History',
        'url' => 'history',
        'icon' => 'fa fa-history',
    ],
    [
        'name' => 'Report',
        'url' => 'report',
        'icon' => 'fa fa-file',
    ]
];
// var_dump($sidebarItems);
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
  <img src="<?= base_url('template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8') ?>">
  <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

      @foreach ($sidebarItems as $item)
      <li class="nav-item <?= isset($item['submenu']) ? '' : 'no-submenu' ?>">
        <a href="<?= base_url(isset($item['url']) ? $item['url'] : '#') ?>" class="nav-link">
          <i class="nav-icon <?= $item['icon'] ?>"></i>
          <p>
            <?= $item['name'] ?>

            <!-- right badge -->
            @if (isset($item['badge']))
            <span class="right badge <?= $item['badge']['class'] ?>"><?= $item['badge']['text'] ?></span>
            @endif

            <!-- sub menu -->
            @if (isset($item['submenu']))
            <i class="fas fa-angle-left right"></i>
            @endif
          </p>
        </a>
        @if (isset($item['submenu']))
        <ul class="nav nav-treeview">
            @foreach ($item['submenu'] as $subitem)
            <li class="nav-item">
            <a href="<?= base_url($subitem['url']) ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p><?= $subitem['name'] ?></p>
            </a>
            </li>
            @endforeach
        </ul>
        @endif
      </li>
      @endforeach
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
