<?php

namespace Dawnstar\Core\Http\Controllers;

use Carbon\Carbon;
use Dawnstar\Tracker\Models\TrackerBrowser;
use Dawnstar\Tracker\Models\TrackerDevice;
use Dawnstar\Tracker\Models\TrackerOperatingSystem;
use Dawnstar\Tracker\Models\TrackerVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends BaseController
{
    protected $startDate;
    protected $endDate;

    public function __construct()
    {
        $this->startDate = Carbon::parse(request('start_date', Carbon::now()->subWeek()->format('Y-m-d')));
        $this->endDate = Carbon::parse(request('end_date', Carbon::now()->format('Y-m-d')))->endOfDay();
    }

    public function index()
    {
        return view('Core::modules.dashboard.index');
    }

    public function getReport()
    {
        $report = request('report');

        return $this->{$report}();
    }

    private function activeUsers()
    {
        $activeUsers = TrackerVisit::groupBy('session_id')
            ->where('created_at', '<=', now())->where('created_at', '>=', now()->subMinutes(1))
            ->get()->count();

        return view('Core::modules.dashboard.partials.online', compact('activeUsers'));
    }

    private function userCount()
    {
        $userCount = TrackerVisit::groupBy('session_id')
            ->where('created_at', '>=', $this->startDate)
            ->where('created_at', '<=', $this->endDate)
            ->get()->count();

        return view('Core::modules.dashboard.partials.user_count', compact('userCount'));
    }

    private function viewsPerMinute()
    {
        $visitors = TrackerVisit::where('created_at', '>=', $this->startDate)
            ->where('created_at', '<=', $this->endDate)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('i');
            });

        $count = $visitors->count();

        $total = 0;
        foreach ($visitors as $visitor) {
            $total += $visitor->count();
        }

        $viewsPerMinute = $count ? number_format($total/$count, 2) : 0;

        return view('Core::modules.dashboard.partials.views_per_minute', compact('viewsPerMinute'));
    }

    private function sessions()
    {
        $visitors = TrackerVisit::where('created_at', '>=', $this->startDate)
            ->where('created_at', '<=', $this->endDate)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('d.m.Y');
            });

        $sessions = [];
        for ($i = $this->startDate->copy(); $i <= $this->endDate; $i->addDay()) {
            $date = $i->format('d.m.Y');
            $sessions[$date] = isset($visitors[$date]) ? $visitors[$date]->count() : 0;
        }

         return view('Core::modules.dashboard.partials.sessions', compact('sessions'));
    }

    private function devices()
    {
        $devices = TrackerDevice::withCount(['cookies' => function ($q) {
            $q->where('created_at', '>=', $this->startDate)
                ->where('created_at', '<=', $this->endDate);
        }])
            ->orderByDesc('cookies_count')->get();

        $return = [];
        foreach ($devices as $device) {
            $return[ucwords($device->name)] = $device->cookies_count;
        }
        $devices = $return;

        return view('Core::modules.dashboard.partials.devices', compact('devices'));
    }

    private function operatingSystems()
    {
        $operatingSystems = TrackerOperatingSystem::withCount(['cookies' => function ($q) {
            $q->where('created_at', '>=', $this->startDate)
                ->where('created_at', '<=', $this->endDate);
        }])
            ->orderByDesc('cookies_count')->get();

        $return = [];
        foreach ($operatingSystems as $operatingSystem) {
            $return[ucwords($operatingSystem->name ?: 'none')] = $operatingSystem->cookies_count;
        }
        $operatingSystems = $return;

        return view('Core::modules.dashboard.partials.operating_systems', compact('operatingSystems'));
    }

    private function browsers()
    {
        $browsers = TrackerBrowser::withCount(['cookies' => function ($q) {
            $q->where('created_at', '>=', $this->startDate)
                ->where('created_at', '<=', $this->endDate);
        }])
            ->orderByDesc('cookies_count')->get();


        $return = [];
        foreach ($browsers as $browser) {
            $return[ucwords($browser->name ?: 'none')] = $browser->cookies_count;
        }
        $browsers = $return;

        return view('Core::modules.dashboard.partials.browsers', compact('browsers'));
    }

    private function pageViews()
    {
        $pageViews = TrackerVisit::groupBy('url_id')
            ->select('id', 'url_id', 'session_id', 'created_at', DB::raw('count(*) as total'))
            ->orderByDesc('total')
            ->where('created_at', '>=', $this->startDate)
            ->where('created_at', '<=', $this->endDate)
            ->whereNotNull('url_id')
            ->get();

        $sum = $pageViews->sum('total');
        $pageViews = $pageViews->take(8);
        $return = [];
        foreach ($pageViews as $page) {
            $return[] = [
                'name' => $page->url->model->name,
                'url' => $page->url->url,
                'count' => $page->total,
                'rate' => number_format($page->total * 100 / $sum, 1),
            ];
        }

        $pageViews = $return;

        return view('Core::modules.dashboard.partials.page_views', compact('pageViews'));
    }

    private function weeklyViews()
    {
        $views = TrackerVisit::select('id', 'hour', 'week', DB::raw('count(*) as total'))
            ->where('created_at', '>=', $this->startDate)
            ->where('created_at', '<=', $this->endDate)
            ->groupBy('hour', 'week')
            ->get();

        $sum = $views->sum('total');

        $weeklyViews = array_fill(1, 24, array_fill(1, 7, 0));
        foreach ($views as $view) {
            $weeklyViews[$view->hour][$view->week] = number_format($view->total * 100 / $sum, 2) . '%';
        }

        return view('Core::modules.dashboard.partials.weekly_views', compact('weeklyViews'));
    }

    private function referers()
    {
        $visits = TrackerVisit::groupBy('referer')
            ->select('id', 'referer', 'session_id', 'created_at', DB::raw('count(*) as total'))
            ->orderByDesc('total')
            ->where('created_at', '>=', $this->startDate)
            ->where('created_at', '<=', $this->endDate)
            ->whereNotNull('referer')
            ->get();

        $sum = $visits->sum('total');
        $visits = $visits->take(8);
        $referers = [];

        foreach ($visits as $visit) {
            $name = $visit->referer;
            if (!$visit->referer || $visit->referer == dawnstar()->website->domain) {
                $name = 'Direct';
            }
            $referers[] = [
                'name' => $name,
                'count' => $visit->total,
                'rate' => number_format($visit->total * 100 / $sum, 1),
            ];
        }

        return view('Core::modules.dashboard.partials.referers', compact('referers'));
    }
}
