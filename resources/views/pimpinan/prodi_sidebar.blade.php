<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            {{ Session::get('nama') }}
          </p>
          <!-- Status -->
          <a href="#"><i class="fa fa-id-card"></i>
            {{ Session::get('fak_prodi') }}
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header bg-red text-center">MENU UTAMA PIMPINAN PRODI</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{set_active('prodi.dashboard')}}">
          <a href="{{ route('prodi.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class=" {{set_active(['prodi.daftar_dosen','prodi.laporan_dosen'])}}">
          <a href="{{ route('prodi.daftar_dosen',[Session::get('kode_prodi')]) }}"><i class="fa fa-users"></i> <span>Daftar Dosen</span>
          </a>
        </li>        

        {{-- <li class="{{set_active('mahasiswa.berikan_evaluasi')}}">
          <a href="{{ route('mahasiswa.berikan_evaluasi') }}"><i class="fa fa-dashboard"></i> <span>Berikan Evaluasi</span>
          </a>
        </li> --}}

       
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->