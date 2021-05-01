<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="<?= base_url('dashboard'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">CRUD</div>
                    <a class="nav-link" href="<?= base_url('builder'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                        Query Builder
                    </a>
                    <a class="nav-link" href="<?= base_url('objects'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-server"></i></div>
                        Object Model
                    </a>
                    <a class="nav-link" href="<?= base_url('ajax-jquery'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-spinner"></i></div>
                        Ajax jQuery
                    </a>
                    <div class="sb-sidenav-menu-heading">Report</div>
                    <a class="nav-link" href="<?= base_url('export-pdf'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-pdf"></i></div>
                        PDF
                    </a>
                    <a class="nav-link" href="<?= base_url('export-excel'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-excel"></i></div>
                        EXCEL
                    </a>
                    <div class="sb-sidenav-menu-heading">Logout</div>
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                        <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>
                        Logout
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?= user()->username; ?>
            </div>
        </nav>
    </div>