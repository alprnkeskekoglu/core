<?php

namespace Dawnstar\Http\Controllers;

use Carbon\Carbon;
use Dawnstar\Tracker\Models\TrackerBrowser;
use Dawnstar\Tracker\Models\TrackerDevice;
use Dawnstar\Tracker\Models\TrackerOperatingSystem;
use Dawnstar\Tracker\Models\TrackerVisit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    public function index()
    {
        $views = $this->getViews();
        $visitors = $this->getVisitors();
        $devices = $this->getDevices();
        $operatingSystems = $this->getOperatingSystems();
        $browsers = $this->getBrowsers();
        $mostVisitedPages = $this->getmostVisitedPages();

        return view('DawnstarView::pages.dashboard.index', compact('views', 'visitors', 'devices', 'operatingSystems', 'browsers', 'mostVisitedPages'));
    }

    public function getViews()
    {
        return Cache::remember('dashboard_views' . session('dawnstar.website.id'), 60 * 60 * 60, function () {
            $visitors = TrackerVisit::where('created_at', '>=', date('Y-m-') . 1)
                ->where('created_at', '<=', date('Y-m-t'))
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->created_at)->format('d');
                });

            $views = $uniqueUsers = array_fill(1, date('t'), 0);
            foreach ($visitors as $day => $visitor) {
                $views[$day] = $visitor->count();
                $uniqueUsers[$day] = $visitor->unique('cookie_id')->count();
            }

            return ['views' => $views, 'uniqueUsers' => $uniqueUsers];
        });
    }

    public function getVisitors()
    {
        return Cache::remember('dashboard_visitors' . session('dawnstar.website.id'), 60 * 60 * 60, function () {
            $visitors = TrackerVisit::groupBy('session_id')->get();

            $daily = $visitors->where('created_at', '<=', now())->where('created_at', '>=', now()->subDay())->count();
            $weekly = $visitors->where('created_at', '<=', now())->where('created_at', '>=', now()->subWeek())->count();
            $monthly = $visitors->where('created_at', '<=', now())->where('created_at', '>=', now()->subMonth())->count();

            return ['daily' => $daily, 'weekly' => $weekly, 'monthly' => $monthly];
        });
    }

    public function getOnlineCount()
    {
        return TrackerVisit::groupBy('session_id')
            ->where('created_at', '<=', now())->where('created_at', '>=', now()->subMinutes(2))
            ->get()->count();
    }

    public function getDevices()
    {
        return Cache::remember('dashboard_devices' . session('dawnstar.website.id'), 60 * 60 * 60, function () {
            $devices = TrackerDevice::withCount('cookies')->orderByDesc('cookies_count')->get();

            $sum = $devices->sum('cookies_count');
            $return = [];
            foreach ($devices as $device) {
                $return[] = [
                    'name' => strtoupper($device->name),
                    'rate' => $device->cookies_count * 100 / $sum
                ];
            }
            return $return;
        });
    }

    public function getOperatingSystems()
    {
        return Cache::remember('dashboard_operating_systems' . session('dawnstar.website.id'), 60 * 60 * 60, function () {
            $operatingSystems = TrackerOperatingSystem::withCount('cookies')->orderByDesc('cookies_count')->get();

            $sum = $operatingSystems->sum('cookies_count');
            $return = [];
            foreach ($operatingSystems as $operatingSystem) {
                $return[] = [
                    'name' => strtoupper($operatingSystem->name),
                    'rate' => $operatingSystem->cookies_count * 100 / $sum
                ];
            }
            return $return;
        });
    }

    public function getBrowsers()
    {
        return Cache::remember('dashboard_browsers' . session('dawnstar.website.id'), 60 * 60 * 60, function () {
            $browsers = TrackerBrowser::withCount('cookies')->orderByDesc('cookies_count')->get();

            $sum = $browsers->sum('cookies_count');
            $return = [];
            foreach ($browsers as $browser) {
                $return[] = [
                    'name' => strtoupper($browser->name),
                    'rate' => $browser->cookies_count * 100 / $sum
                ];
            }
            return $return;
        });
    }

    public function getmostVisitedPages()
    {
        return Cache::remember('dashboard_most_visited_pages' . session('dawnstar.website.id'), 60 * 60 * 60, function () {
            $mostVisitedPages = TrackerVisit::groupBy('url_id')
                ->select('id', 'url_id', 'session_id', DB::raw('count(*) as total'))
                ->orderByDesc('total')
                ->take(10)
                ->get();

            $return = [];
            foreach ($mostVisitedPages as $page) {
                $return[] = [
                    'name' => $page->url->model->name,
                    'url' => $page->url->url,
                    'count' => $page->total
                ];
            }

            return $return;
        });
    }
}
