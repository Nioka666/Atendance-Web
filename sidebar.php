<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <?php
    if ($guru_status === "admin") { ?>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
            <div class="sidebar-brand-icon">
                <i class="fas fa-university"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SKANEDA</div>
        </a>

    <?php } else { ?>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon">
                <i class="fas fa-university"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SKANEDA</div>
        </a>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php
    if ($guru_status == "admin") { ?>
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="admin.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Admin Dashboard</span></a>
        </li>
    <?php } else { ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="absensi.php">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Absensi</span></a>
    </li>
    <!-- ??????? -->
    <hr class="sidebar-divider d-none d-md-block">
    <?php if ($guru_status === 'admin') { ?>
        <li class="nav-item">
            <a class="nav-link" href="guru.php">
                <i class="fas fa-fw fa-user-check"></i>
                <span>Guru</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
    <?php } ?>
    <?php if ($guru_status === 'admin') { ?>
        <li class="nav-item">
            <a class="nav-link" href="lihatsiswa.php">
                <i class="fas fa-fw fa-user"></i>
                <span>Siswa</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item">
            <a class="nav-link" href="lihatkelas.php">
                <i class="fas fa-fw fa-home"></i>
                <span>Data Kelas</span>
            </a>
            <br>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="lihatmapel.php">
                <i class="fas fa-fw fa-book"></i>
                <span>Mata Pelajaran</span>
            </a>
            <br>
        </li>
    <?php } ?>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>