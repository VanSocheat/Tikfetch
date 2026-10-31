<?php
return [
 'provider'=>env('TIKTOK_PROVIDER','demo'),
 'api_base_url'=>env('TIKTOK_API_BASE_URL',''),
 'api_key'=>env('TIKTOK_API_KEY',''),
 'allowed_provider_hosts'=>array_filter(explode(',',env('TIKTOK_ALLOWED_PROVIDER_HOSTS',''))),
 'allowed_media_hosts'=>array_filter(explode(',',env('TIKTOK_ALLOWED_MEDIA_HOSTS',''))),
 'daily_quota'=>(int)env('TIKTOK_DAILY_QUOTA',20),
];
