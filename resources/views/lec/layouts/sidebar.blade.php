<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand navbar-brand-lec" href="index.html">
                <div>
                    <img src="../img/dashboard/admin.png" alt="Logo">
                </div>
            </a>
            <div class="navbar-profile" style="color:#fff;">
                <span>User Admin</span>
            </div>
            <a class="navbar-brand hidden" href="index.html"><img class="user-avatar rounded-circle" src="../img/dashboard/admin.png" alt="User Avatar"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="/lec"><i class="far fa-user pr-4 pl-3"></i>Profile </a>
                    <a href="/lec/candidates"><i class="fas fa-user pr-4 pl-3"></i>Candidates </a>
                    <a href="#"><i class="fa fa-power-off pr-4 pl-3"></i>Logout</a>
                </li>
                {{-- <h3 class="menu-title">MENU</h3>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-laptop"></i>Nominations</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="far fa-clock"></i><a href="/nomination/pending">Pending</a></li>
                        <li><i class="fas fa-check"></i><a href="/nomination/approve">Approved</a></li>
                        <li><i class="fas fa-times"></i><a href="/nomination/reject">Rejeted</a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </nav>
</aside>