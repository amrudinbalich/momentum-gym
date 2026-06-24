<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (! Hash::check(
            $request->current_password,
            $user->password
        )) {
            throw ValidationException::withMessages([
                'current_password' => 'Password mismatch.',
            ]);
        }

        $user->update([
            'password' => Hash::make(
                $request->new_password
            ),
        ]);

        return response()->noContent();
    }
}
