<?php
declare(strict_types=1);

namespace App\Services;


use App\Models\Park;

class ParkService
{
    public function getPark()
    {
        $query = Park::query();
        $search = request()->input('search');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }


        return $query->latest()->paginate(config('settings.default_pagination') ?? 10);
    }
}
