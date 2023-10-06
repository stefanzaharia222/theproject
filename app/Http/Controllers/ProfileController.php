<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\User;
use App\ProfileService;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('pages.profile.index', compact('user'));
    }

    public function update(User $user)
    {
        return view('pages.profile.update', compact('user'));
    }

    public function storeImage(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg|max:5000'
        ])->validate();

        $profileService = new ProfileService($user);
        $profileService->storeAvatar($request->file('file'));

    }

    public function store(StoreProfileRequest $request, User $user)
    {
        $profileService = new ProfileService($user);
        $profileService->store($request);

        return redirect()->back()->with(['success' => 'UserProfile was updated']);
    }
}
