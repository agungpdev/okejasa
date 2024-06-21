<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);

            // return back()->with('status', 'password-updated');

            DB::commit();
                $status = [
                    'success' => true,
                    'message' => 'Password berhasil diganti'
                ];
            return response()->json($status);

        } catch (\Throwable $th) {
            DB::rollBack();

                if ($th->getCode() == 1) {
                    $pesan_error = $th->getMessage();
                }else{
                    $pesan_error=$th;
                }
                $status = [
                    'error' => true,
                    'message' => $pesan_error
                ];
                return response()->json($status);
        }
    }
}
