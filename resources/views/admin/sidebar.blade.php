<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="text-transform: uppercase;">{{ Auth::guard('admin')->user()->nm_admin }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i>{{ Auth::guard('admin')->user()->created_at }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header bg-red" style="text-align: center;">MENU UTAMA ADMIN</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{set_active('admin.dashboard')}}">
          <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview {{ set_active(['manajemen.jenis_indikator','manajemen.indikator']) }}">
          <a href="#"><i class="glyphicon glyphicon-th"></i> <span>Manajemen Indikator</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ set_active('manajemen.jenis_indikator') }}"><a href="{{route('manajemen.jenis_indikator')}}"><i class="glyphicon glyphicon-list-alt"></i>Jenis Indikator</a></li>
            <li class="{{ set_active('manajemen.indikator') }}"><a href="{{ route('manajemen.indikator') }}"><i class="glyphicon glyphicon-list"></i>Indikator Penilaian</a></li>
          </ul>
        </li>

        <li class="treeview {{ set_active(['api.laporan-per-jenis','laporan.per_jenis','laporan.per_indikator','api.laporan-per-indikator','laporan.saran_mahasiswa','api.saran_mahasiswa']) }}">
          <a href="#"><i class="fa fa-bar-chart"></i> <span>Laporan Evaluasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ set_active(['laporan.per_jenis','api.laporan-per-jenis']) }}"><a href="{{ route('laporan.per_jenis') }}"><i class="fa fa-pie-chart "></i>Laporan Per Jenis Indikator</a></li>
            <li class="{{ set_active(['laporan.per_indikator','api.laporan-per-indikator']) }}"><a href="{{ route('laporan.per_indikator') }}"><i class="fa fa-line-chart"></i>Laporan Per Indikator</a></li>
            <li class="{{ set_active(['laporan.saran_mahasiswa','api.saran_mahasiswa']) }}"><a href="{{ route('laporan.saran_mahasiswa') }}"><i class="fa fa-envelope"></i>Saran Mahasiswa</a></li>
            
            {{-- <li class="{{ set_active('laporan.detail') }}"><a href="{{ route('laporan.detail') }}"><i class="fa fa-info"></i>Laporan Keseluruhan (Detail)</a></li> --}}
            {{-- <li class="{{ set_active(['laporan.per_dosen','admin.api_laporan_per_dosen']) }}"><a href="{{ route('laporan.per_dosen') }}"><i class="fa fa-address-card-o"></i>Laporan Per Dosen</a></li> --}}
          </ul>
        </li>

        <li class="{{set_active('manajemen.admin')}}">
          <a href="{{ route('manajemen.admin') }}"><i class="fa fa-cog"></i> <span>Pengaturan Admin</span>
          </a>
        </li>

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->