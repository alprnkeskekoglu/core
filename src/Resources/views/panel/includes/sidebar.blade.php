@php
    $structures = \Dawnstar\Models\Structure::all();
@endphp
<div class="leftside-menu leftside-menu-detached">
    <ul class="side-nav">
        <li class="side-nav-title side-nav-item">Navigation</li>
        <li class="side-nav-item">
            <a href="{{ route('dawnstar.websites.index') }}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span>Website</span>
            </a>
            <a href="{{ route('dawnstar.structures.index') }}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span>Structure</span>
            </a>

            <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span class="badge bg-info rounded-pill float-end">4</span>
                <span> Dashboards </span>
            </a>
            <div class="collapse" id="sidebarDashboards">
                <ul class="side-nav-second-level">
                    @foreach($structures as $structure)
                    <li>
                        <a href="{{ route('dawnstar.structures.pages.index', [$structure]) }}">{{ $structure->container->translation->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>

    </ul>
    <div class="clearfix"></div>
</div>
