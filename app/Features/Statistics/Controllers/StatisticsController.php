<?php

namespace App\Features\Statistics\Controllers;

use App\Features\Properties\Models\Property;
use App\Features\Properties\Models\PropertyType;
use App\Features\SystemManagements\Models\User;
use App\Features\Regions\Models\City;
use App\Features\Regions\Models\Area;
use App\Features\Banners\Models\Banner;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    use ApiResponses;

    /**
     * Get dashboard statistics
     */
    public function dashboard(): JsonResponse
    {
        $statistics = [
            // User Statistics
            'users' => [
                'total' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'agents' => User::where('role', 'agent')->count(),
                'customers' => User::where('role', 'customer')->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ],

            // Property Statistics
            'properties' => [
                'total' => Property::count(),
                'available' => Property::where('status', 'available')->count(),
                'rented' => Property::where('status', 'rented')->count(),
                'sold' => Property::where('status', 'sold')->count(),
                'active' => Property::where('is_active', true)->count(),
                'new_this_month' => Property::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'by_type' => PropertyType::withCount('properties')->get()->map(function ($type) {
                    return [
                        'name' => $type->name,
                        'count' => $type->properties_count,
                    ];
                }),
                'price_ranges' => [
                    'under_1000' => Property::where('price', '<', 1000)->count(),
                    '1000_5000' => Property::whereBetween('price', [1000, 5000])->count(),
                    '5000_10000' => Property::whereBetween('price', [5000, 10000])->count(),
                    'over_10000' => Property::where('price', '>', 10000)->count(),
                ],
            ],

            // Location Statistics
            'locations' => [
                'cities' => City::count(),
                'areas' => Area::count(),
                'properties_by_city' => City::withCount('properties')->get()->map(function ($city) {
                    return [
                        'name' => $city->name,
                        'name_ar' => $city->name_ar,
                        'count' => $city->properties_count,
                    ];
                }),
            ],

            // Banner Statistics
            'banners' => [
                'total' => Banner::count(),
                'recent' => Banner::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ],

            // Recent Activity
            'recent_activity' => [
                'latest_properties' => Property::with(['propertyType', 'city', 'area'])
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($property) {
                        return [
                            'id' => $property->id,
                            'title' => $property->title,
                            'type' => $property->propertyType->name,
                            'city' => $property->city->name,
                            'price' => $property->price,
                            'status' => $property->status,
                            'created_at' => $property->created_at->format('Y-m-d H:i:s'),
                        ];
                    }),
                'latest_users' => User::latest()
                    ->take(5)
                    ->get()
                    ->map(function ($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'role' => $user->role,
                            'phone' => $user->phone_code . $user->phone,
                            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        ];
                    }),
            ],

            // Monthly Trends (last 6 months)
            'trends' => [
                'properties_monthly' => $this->getMonthlyTrends(Property::class),
                'users_monthly' => $this->getMonthlyTrends(User::class),
            ],
        ];

        return $this->okResponse($statistics, "Dashboard statistics retrieved successfully");
    }

    /**
     * Get property statistics
     */
    public function properties(): JsonResponse
    {
        $statistics = [
            'overview' => [
                'total' => Property::count(),
                'available' => Property::where('status', 'available')->count(),
                'rented' => Property::where('status', 'rented')->count(),
                'sold' => Property::where('status', 'sold')->count(),
                'active' => Property::where('is_active', true)->count(),
                'inactive' => Property::where('is_active', false)->count(),
            ],
            'by_type' => PropertyType::withCount('properties')->get(),
            'by_city' => City::withCount('properties')->get(),
            'by_agent' => User::where('role', 'agent')
                ->withCount(['agentProperties'])
                ->get()
                ->map(function ($agent) {
                    return [
                        'id' => $agent->id,
                        'name' => $agent->name,
                        'properties_count' => $agent->agent_properties_count,
                    ];
                }),
            'price_analysis' => [
                'average_price' => Property::avg('price'),
                'min_price' => Property::min('price'),
                'max_price' => Property::max('price'),
                'price_ranges' => [
                    'under_1000' => Property::where('price', '<', 1000)->count(),
                    '1000_5000' => Property::whereBetween('price', [1000, 5000])->count(),
                    '5000_10000' => Property::whereBetween('price', [5000, 10000])->count(),
                    'over_10000' => Property::where('price', '>', 10000)->count(),
                ],
            ],
        ];

        return $this->okResponse($statistics, "Property statistics retrieved successfully");
    }

    /**
     * Get user statistics
     */
    public function users(): JsonResponse
    {
        $statistics = [
            'overview' => [
                'total' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'agents' => User::where('role', 'agent')->count(),
                'customers' => User::where('role', 'customer')->count(),
            ],
            'registration_trends' => $this->getMonthlyTrends(User::class, 12),
            'by_role' => User::select('role', DB::raw('count(*) as count'))
                ->groupBy('role')
                ->get(),
        ];

        return $this->okResponse($statistics, "User statistics retrieved successfully");
    }

    /**
     * Get monthly trends for a model
     */
    private function getMonthlyTrends($model, $months = 6): array
    {
        $trends = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = $model::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $trends[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        }

        return $trends;
    }
}
