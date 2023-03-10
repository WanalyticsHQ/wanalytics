<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;

use App\Jobs\ProcessColletectedData;

use App\Http\Requests\CollectRequest;

use Illuminate\Http\Request;
use Browser;

use App\Models\User;
use App\Models\Website;
use App\Models\Session;
use App\Models\PageView;

use Illuminate\Support\Facades\Cache;

class CollectController extends Controller
{
    public function store(CollectRequest $request)
    {
        $website = Cache::remember("website:{$request->hostname}", now()->addMinutes(5), function () use ($request) {
            return Website::where('domain', $request->hostname)->first();
        });

        if(!$website) {
            return response()->json(null, 404);
        }

        $data = [
            'ip' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            'event' => $request->event,
            'hostname' => $request->hostname,
            'referrer' => $request->referrer,
            'language' => $request->language,
            'screen' => $request->screen,
            'url' => $request->url
        ];

        ProcessColletectedData::dispatch($data, $website);

        return response()->json(null, 202);
    }
}
