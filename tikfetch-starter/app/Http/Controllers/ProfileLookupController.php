<?php

namespace App\Http\Controllers;

use App\Contracts\TikTokVideoProviderInterface;
use App\Services\TikTokProfileUrlParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ProfileLookupController extends Controller
{
    public function index()
    {
        return view('home', ['result' => null, 'profileUrl' => '']);
    }

    public function lookup(
        Request $request,
        TikTokProfileUrlParser $parser,
        TikTokVideoProviderInterface $provider
    ) {
        $validated = $request->validate([
            'profile_url' => ['required', 'string', 'max:500'],
        ]);

        try {
            $username = $parser->parse($validated['profile_url']);
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['profile_url' => $e->getMessage()])
                ->withInput();
        }

        try {
            $result = $provider->listProfileVideos($username);
        } catch (\Throwable $e) {
            Log::warning('TikTok provider lookup failed', [
                'exception' => get_class($e),
            ]);

            return back()->withErrors([
                'profile_url' => 'The video provider is unavailable. Please try again later.',
            ])->withInput();
        }

        return view('home', [
            'result' => $result,
            'profileUrl' => $validated['profile_url'],
        ]);
    }

    public function download(string $videoId, TikTokVideoProviderInterface $provider)
    {
        // Demo provider intentionally has no downloadable media.
        // Production implementation must verify the ID with the configured provider,
        // validate provider-host allowlists, and stream/redirect safely.
        $url = $provider->getDownloadUrl($videoId);

        if (!$url) {
            return response(
                'Downloads are not configured. Connect and test a compatible, authorized media provider first.',
                501,
                ['Content-Type' => 'text/plain; charset=UTF-8']
            );
        }

        // Do not blindly redirect to arbitrary provider-returned URLs. A production
        // adapter must validate the URL host against an explicit allowlist first.
        return response(
            'Provider returned a URL, but secure media delivery has not yet been enabled.',
            501,
            ['Content-Type' => 'text/plain; charset=UTF-8']
        );
    }
}
