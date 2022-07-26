<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        try {
            $user = $request->user();
            if ($user != null) {
                if ($user->avatar != null) {
                    $avatar = asset("storage/avatar/$user->avatar");
                } else {
                    $avatar = null;
                }

                $response = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $avatar,
                    'profile_photo_path' => $user->profile_photo_path
                ];
                return response()->json([
                    'successs' => true,
                    'data' => $response,
                ]);
            }
            return response()->json(
                $user
            );
        } catch (Exception $err) {
            return response()->json([
                'successs' => false,
                'data' => $err
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        try {
            $user = Auth::user()->id;
            $validate = $request->validate([
                'avatar' => 'image|file|max:1024',
            ]);
            if ($request->file('avatar')) {
                $namefilenameWithExt = $request->file('avatar')->getClientOriginalName();
                $filename = pathinfo($namefilenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('avatar')->getClientOriginalExtension();

                $filenameAvatar = $filename . '_' . time() . '.' . $extension;
                $moveFile = $request->file('avatar')->storeAs('avatar', $filenameAvatar);
                // $request->file('avatar')->move(public_path('storage/avatar'), $filenameAvatar);

                if ($moveFile) {
                    $user = Auth::user();
                    $user->avatar = $filenameAvatar;
                    $user->save();

                    return response()->json([
                        'file' => gettype($filenameAvatar),
                        asset("storage/avatar/$filenameAvatar"),
                        'message' => asset("images/$filenameAvatar") ? 'Image saved' : 'Image failed to save'
                    ]);
                }
                return response()->json([
                    'x' => $moveFile
                ]);
            }
            return response()->json([
                'data' => $user
            ]);
        } catch (Exception $err) {
            return response()->json([
                'successs' => false,
                'data' => $err
            ]);
        }
    }

    public function getUserDetail(Request $request)
    {
        try {
            $user = DB::table('detail_users')
                ->join('users', 'detail_users.user_id', '=', 'users.id')
                ->where('detail_users.user_id', '=', $request->user()->id)
                ->get();
            foreach ($user as $newdata) {
                $result = $newdata;
            }
            return response()->json(
                [
                    'success' => true,
                    'data' => $result
                ]
            );
        } catch (Excaption $err) {
            return response()->json([
                'success' => false,
                'data' => $err
            ]);
        }
    }

    public function getUserForKegiatan(Request $request)
    {
        try {
            $user = DB::table('detail_users')
                ->join('users', 'detail_users.user_id', '=', 'users.id')
                ->where('detail_users.user_id', '=', $request->user()->id)
                ->get(['detail_users.id', 'detail_users.namaLengkap']);
            foreach ($user as $newdata) {
                $result = $newdata;
            }
            return response()->json(
                [
                    'success' => true,
                    'data' => $result
                ]
            );
        } catch (Excaption $err) {
            return response()->json([
                'success' => false,
                'data' => $err
            ]);
        }
    }

    public function getUserForStatus(Request $request)
    {
        try {
            $user = DB::table('detail_users')
                ->join('users', 'detail_users.user_id', '=', 'users.id')
                ->where('detail_users.user_id', '=', $request->user()->id)
                ->get(['users.id', 'users.avatar', 'detail_users.namaLengkap', 'detail_users.programMagang', 'detail_users.tglGabung']);

            foreach ($user as $newdata) {
                $result = $newdata;
            }
            return response()->json(
                [
                    'success' => true,
                    'data' => $result
                ]
            );
        } catch (Excaption $err) {
            return response()->json([
                'success' => false,
                'data' => $err
            ]);
        }
    }

    public function getListAnak(Request $request)
    {
        try {
            $user = DB::table('users')
            ->join('detail_users', 'users.id', '=', 'detail_users.user_id')
            ->where('users.role', '=', 'user')
            ->get(['users.id', 'users.email', 'users.avatar', 'detail_users.namaLengkap']);

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
