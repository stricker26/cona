<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/dashboard"><img src="../img/LP_Logo.png" alt="Logo"></a>
            <a class="navbar-brand hidden" href="/dashboard"><img src="../img/dashboard/logo-sidebar2.png" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse pt-2">
            <ul class="nav navbar-nav">
                <li class="pl-2">
                    <a href="/dashboard"><i class="fas fa-tachometer-alt pr-4"></i>&nbsp;Dashboard </a>
                </li>
                <li class="pl-2">
                    <div class="float-right stat-check">
                        <div class="d-inline pr-2 pl-1">
                            <a href="#" class="a-hover" title="Pending - 10"><i class="far fa-clock pr-1"></i>10</a>
                        </div>
                        <div class="d-inline pr-2">
                            <a href="#" class="a-hover" title="Approved - 22"><i class="fas fa-check pr-1"></i>22</a>
                        </div>
                        <div class="d-inline pr-1">
                            <a href="#" class="a-hover" title="Rejected - 15"><i class="fas fa-times pr-1"></i>15</a>
                        </div>
                    </div>
                    <button class="dropdown-toggle dropdown-btn" type="button" data-toggle="dropdown">
                        <i class="fas fa-users pr-4"></i><span class="pr-2">National Candidates</span><i class="fas fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            @if(!empty($regions))
                            @foreach($regions as $region)
                            <div>
                                <div class="float-right reg-stat">
                                    <div class="d-inline pr-2">
                                        <a href="#" class="a-hover" title="Pending - 22"><i class="far fa-clock pr-1"></i>22</a>
                                    </div>
                                    <div class="d-inline pr-2">
                                        <a href="#" class="a-hover" title="Pending - 44"><i class="fas fa-check pr-1"></i>44</a>
                                    </div>
                                    <div class="d-inline pr-1">
                                        <a href="#" class="a-hover" title="Pending - 22"><i class="fas fa-times pr-1"></i>22</a>
                                    </div>
                                </div>
                            </div>
                            <a class="test d-inline" class="dropdown-btn">
                                <i class="fas fa-map-marker-alt pr-4"></i><span class="pr-2">Region&nbsp;{{ $region }}</span><i class="fas fa-caret-down align-middle"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu submenu">
                                @foreach($provinces as $province)
                                    @if($region === $province->region)
                                    <div>
                                        <div class="float-right reg-stat">
                                            <div class="d-inline pr-2">
                                                <a href="#Pending" class="a-hover" title="Pending - 2"><i class="far fa-clock pr-1"></i>2</a>
                                            </div>
                                            <div class="d-inline pr-2">
                                                <a href="#Approved" class="a-hover" title="Pending - 5"><i class="fas fa-check pr-1"></i>5</a>
                                            </div>
                                            <div class="d-inline pr-1">
                                                <a href="#Rejected" class="a-hover" title="Pending - 1"><i class="fas fa-times pr-1"></i>1</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a data-value="{{$province->province_code}},{{$province->type}},{{$province->lgu}},{{$province->region}}" class="d-inline"><i class="far fa-map align-top pt-2"></i><div class="d-inline-block pl-3 prov-part">{{ ucwords(strtolower($province->lgu)) }}</div></a>
                                    @endif
                                @endforeach
                                </li>
                            </ul>
                            @endforeach
                            @endif
                        </li>
                    </ul>
                </li>
                <li class="pl-2">
                    <a href="#settings"><i class="fas fa-wrench pr-4"></i>&nbsp;Settings </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>