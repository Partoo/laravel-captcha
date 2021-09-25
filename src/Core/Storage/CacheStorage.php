<?php

namespace Tao\Captcha\Core\Storage;

use Illuminate\Support\Facades\Cache;

class CacheStorage implements IStorage
{

    /**
     * @inheritDoc
     */
    public function put(string $cache_key, string $code)
    {
        Cache::put($cache_key, $code, now()->addMinute());
    }
    /**
     * @inheritDoc
     */
    public function get($cache_key): ?string
    {
        $code = Cache::get($cache_key);
        if (!empty($code)) {
            Cache::get($cache_key);
        }
        return $code;
    }
    public function forget($cache_key) {
        Cache::forget($cache_key);
    }
}
