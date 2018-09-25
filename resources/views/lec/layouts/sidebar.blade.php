<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="navbar-brand navbar-brand-lec">
                <img class="user-avatar rounded-circle" src="../img/dashboard/admin.png" alt="Logo">
            </div>
            <div class="navbar-brand hidden" href="/lec">
                <img class="user-avatar rounded-circle" src="../img/dashboard/admin.png" alt="User Avatar">
            </div>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse mt-3">
            <div class="col">
                <div class="row pb-3">
                    <a href="/lec"><i class="far fa-user pr-4 pl-3"></i><span>Profile</span></a>
                </div>
                <div class="row pb-2 logout-click">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt pr-4 pl-3"></i><span>Logout</span></a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <div class="pb-3">
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
                        <i class="fas fa-users pr-4"></i><span class="pr-2">Candidates</span><i class="fas fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu ul-menu">
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
                                    @if(($region === $province->region &&
                                        $province->type != 'HUC') ||
                                        ($region === $province->region &&
                                        $region == 'NCR'))
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
                </div>
            </div>
        </div>
    </nav>
</aside>