<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form with avatar.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Check if the avatar is already cached
        $avatarUrl = Cache::rememberForever('avatar_' . $user->id, function () use ($user) {
            // If no avatar exists, generate one using the API
            return $this->generateAvatar();
        });

        return view('profile.edit', [
            'user' => $user,
            'avatarUrl' => $avatarUrl,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // Invalidate email verification if the email is updated
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Generate an avatar using the Vision AI API.
     */
    protected function generateAvatar(): string
    {
        $client = new Client();
        $response = $client->post('https://vision-ai-api.p.rapidapi.com/texttoimage3', [
            'body' => json_encode([
                'text' => 'an avatar',
                'width' => 512,
                'height' => 512,
            ]),
            'headers' => [
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => 'vision-ai-api.p.rapidapi.com',
                'x-rapidapi-key' => 'b1cd77318fmsh22bd1f715d40dc6p1c952cjsn0c4f79854c46',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['generated_image'] ?? 'default-avatar-url';
    }
}
