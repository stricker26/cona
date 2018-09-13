<!-- Left Panel -->
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="index.html"><img src="../img/dashboard/logo-sidebar.png" alt="Logo"></a>
            <a class="navbar-brand hidden" href="index.html"><img src="../img/dashboard/logo-sidebar2.png" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="index.html"> <i class="menu-icon fas fa-tachometer-alt"></i>Dashboard </a>
                </li>
                <h3 class="menu-title">MENU</h3><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-laptop"></i>Nominations</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="far fa-clock"></i><a href="{{ route('/nomination/pending') }}">Pending</a></li>
                        <li><i class="fas fa-check"></i><a href="{{ route('/nomination/approve') }}">Approved</a></li>
                        <li><i class="fas fa-times"></i><a href="{{ route('/nomination/reject') }}">Rejeted</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->