<?php

namespace App;

use App\Http\Requests\StoreProfileRequest;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Support\Str;

class ProfileService
{
    public function __construct(protected User $user)
    {
    }

    public function storeAvatar($image): bool
    {
        if ($this->user->image) {
            $userImage = UserImage::find($this->user->image->id);
            if(\File::exists(public_path('avatarImages'.$userImage->path))){
                \File::delete(public_path('avatarImages'.$userImage->path));

            }

            $userImage->delete();
        }

        $filename = 'avatar_' . $this->user->id . '_' . Str::random(12) . '.'.$image->getClientOriginalExtension();

        $image->move(public_path('avatarImages'), $filename);

        $image = new UserImage();
        $image->path = $filename;
        $image->user_id = $this->user->id;
        $image->save();

        return true;

    }

    public function store(StoreProfileRequest $request): bool
    {
        if ($request->input('first_name') !== $this->user->first_name)
        {
            $this->user->first_name = $request->input('first_name');
        }

        if ($request->input('last_name') !== $this->user->last_name)
        {
            $this->user->last_name = $request->input('last_name');
        }

        if ($request->input('email') !== $this->user->email)
        {
            $this->user->email = $request->input('email');
        }
        if ($request->input('phone') !== $this->user->phone)
        {
            $this->user->phone = $request->input('phone');
        }

        if ($request->input('password')) {
            $this->user->phone = $request->input('password');
        }

        $this->user->save();

        return true;

    }
}