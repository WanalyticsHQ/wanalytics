<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\CarbonPeriod;

use App\Models\User;
use App\Models\Website;
use App\Models\Session;
use App\Models\PageView;
use App\Models\Timezone;

class LocalDevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory([
                'name' => 'Admin',
                'email' => 'admin@wanalytics.io'
            ])
            ->hasAttached(
                Website::factory(),
                ['role' => User::ROLE_OWNER]
            )
            ->create();

        $website = Website::first();

        User::where('id', $user->id)->update(['current_website_id' => $website->id]);

        $dates = CarbonPeriod::create(now()->subMonths(4), '5 minutes', now());

        foreach($dates as $date) {
            Session::factory(['created_at' => $date])
                ->count(rand(1, 2))
                ->for($website)
                ->has(PageView::factory(['created_at' => $date])->count(rand(1, 6))->for($website))
                ->create();
        }
    }
}
