<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('hqPanel') }}"><img src="{{ asset('img/LP_Logo.png') }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="{{ route('hqPanel') }}"><img src="{{ asset('img/dashboard/logo-sidebar2.png') }}" alt="Logo"></a>
        </div>

        <form id="statusCandidates" action="/hq/status" method="POST">
            @csrf
            <input type="hidden" name="statusData" id="statusData" value="">
        </form>

        <div id="main-menu" class="main-menu collapse navbar-collapse pt-2">
            <ul class="nav navbar-nav">
                <li class="pl-2">
                    <a href="{{ route('hqPanel') }}"><i class="fas fa-tachometer-alt pr-4"></i>&nbsp;Dashboard </a>
                </li>
                <li class="pl-2">
                    <div class="float-right stat-check">
                        <div class="d-inline pr-2 pl-1">
                            <span data-value="0,ph,empty,none" class="a-hover" title="Pending - {{ $pending_count_all }}"><i class="far fa-clock pr-1"></i>{{ $pending_count_all }}</span>
                        </div>
                        <div class="d-inline pr-2">
                            <span data-value="1,ph,empty,none" class="a-hover" title="Approved - {{ $approved_count_all }}"><i class="fas fa-check pr-1"></i>{{ $approved_count_all }}</span>
                        </div>
                        <div class="d-inline pr-1">
                            <span data-value="2,ph,empty,none" class="a-hover" title="Rejected - {{ $rejected_count_all }}"><i class="fas fa-times pr-1"></i>{{ $rejected_count_all }}</span>
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
                                        <span data-value="0,{{$region}},empty,none" class="a-hover" title="Pending - {{ $pending_count_region->$region }}"><i class="far fa-clock pr-1"></i>{{ $pending_count_region->$region }}</span>
                                    </div>
                                    <div class="d-inline pr-2">
                                        <span data-value="1,{{$region}},empty,none" class="a-hover" title="Approved - {{ $approved_count_region->$region }}"><i class="fas fa-check pr-1"></i>{{ $approved_count_region->$region }}</span>
                                    </div>
                                    <div class="d-inline pr-1">
                                        <span data-value="2,{{$region}},empty,none" class="a-hover" title="Rejected - {{ $rejected_count_region->$region }}"><i class="fas fa-times pr-1"></i>{{ $rejected_count_region->$region }}</span>
                                    </div>
                                </div>
                            </div>
                            <a class="test d-inline" class="dropdown-btn">
                                <i class="fas fa-map-marker-alt pr-4"></i><span class="pr-2">Region&nbsp;{{ $region }}</span><i class="fas fa-caret-down align-middle"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu submenu">
                                @php
                                    $key_p = 0;
                                @endphp
                                @foreach($provinces as $province)
                                    @if(($region === $province->region && $province->type != 'HUC') ||
                                        ($region === $province->region &&
                                        $region == 'NCR'))
                                    <div>
                                        <div class="float-right reg-stat">
                                            <div class="d-inline pr-2">
                                                <span data-value="0,{{$region}},{{$province->province_code}},{{$province->type}}" class="a-hover" title="Pending - {{ $pending_count_province->{$province->lgu} }}"><i class="far fa-clock pr-1"></i>{{ $pending_count_province->{$province->lgu} }}</span>
                                            </div>
                                            <div class="d-inline pr-2">
                                                <span data-value="1,{{$region}},{{$province->province_code}},{{$province->type}}" class="a-hover" title="Approved - {{ $approved_count_province->{$province->lgu} }}"><i class="fas fa-check pr-1"></i>{{ $approved_count_province->{$province->lgu} }}</span>
                                            </div>
                                            <div class="d-inline pr-1">
                                                <span data-value="2,{{$region}},{{$province->province_code}},{{$province->type}}" class="a-hover" title="Rejected - {{ $rejected_count_province->{$province->lgu} }}"><i class="fas fa-times pr-1"></i>{{ $rejected_count_province->{$province->lgu} }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a data-value="{{$province->province_code}},{{$province->type}},{{$province->lgu}},{{$province->region}}" class="d-inline"><i class="far fa-map align-top pt-2"></i><div class="d-inline-block pl-3 prov-part">{{ ucwords(mb_strtolower($province->lgu, 'UTF-8')) }}</div></a>
                                    @php
                                        $key_p++;
                                    @endphp
                                    @endif
                                @endforeach
                                </li>
                            </ul>
                            @endforeach
                            @endif
                        </li>
                    </ul>
                </li>{{-- 
                <li class="pl-2">
                    <a href="#settings"><i class="fas fa-wrench pr-4"></i>&nbsp;Settings </a>
                </li> --}}
            </ul>
        </div>
    </nav>
</aside>