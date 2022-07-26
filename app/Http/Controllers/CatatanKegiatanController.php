<?php

namespace App\Http\Controllers;

use App\Models\CatatanKegiatan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatatanKegiatanController extends Controller
{
    public function addCatatanKegiatan(Request $request)
    {
        try {
            $timestamp = round(microtime(true) * 1000);

            $validate = $request->validate([
                'catatan' => 'required|string'
            ]);

            $catatan = CatatanKegiatan::create([
                'user_id' => Auth::user()->id,
                'tanggal' => $timestamp,
                'catatan' => $validate['catatan']
            ]);

            if ($catatan) {
                $res = CatatanKegiatan::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
                return response()->json([
                    'success' => true,
                    'data' => $res
                ]);
            }
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'data' => $err
            ]);
        }
    }

    public function getCatatan(Request $request)
    {
        try {
            $role = Auth::user()->role;
            if ($role == 'super admin') {
                $res = CatatanKegiatan::all()->where('user_id', Auth::user()->id);
            } elseif ($role == 'admin') {
                $res = CatatanKegiatan::all()->where('user_id', Auth::user()->id);
            } else {
                $start = $request->input('start');
                $end = $request->input('end');

                $dateStart = strtotime($start) * 1000;
                $dateEnd = strtotime($end) * 1000;

                if ($start != null && $end != null) {
                    $res = CatatanKegiatan::all()->where('user_id', Auth::user()->id)->whereBetween('tanggal', [$dateStart, $dateEnd]);
                } else {
                    $res = CatatanKegiatan::all()->where('user_id', Auth::user()->id);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $res
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th
            ]);
        }
    }

    public function getCatatanId(Request $request)
    {
        try {
            $id = $request->input('id');
            $start = $request->input('start');
            $end = $request->input('end');

            $dateStart = strtotime($start) * 1000;
            $dateEnd = strtotime($end) * 1000;

            if ($start != null && $end != null) {
                $res = CatatanKegiatan::all()->where('user_id', Auth::user()->id)->whereBetween('tanggal', [$dateStart, $dateEnd]);
            } else {
                $res = CatatanKegiatan::all()->where('user_id', Auth::user()->id);
            }

            return response()->json([
                'success' => true,
                'data' => $res,
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th
            ]);
        }
    }

    public function getListCatatan()
    {
        $detail = DB::table('users')
        ->join('detail_users', 'users.id', '=', 'detail_users.user_id')
        ->join('catatan_kegiatans', 'users.id', '=', 'catatan_kegiatans.user_id')
        ->where('users.role', '=', 'user')
        ->get(['catatan_kegiatans.*', 'detail_users.namaLengkap', 'users.avatar']);

        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    public function getDetailCatatanById(Request $request)
    {
        if ($request['id'] != null) {
            $detail = DB::table('catatan_kegiatans')
                ->join('users', 'catatan_kegiatans.user_id', '=', 'users.id')
                ->join('detail_users', 'users.id', '=', 'detail_users.user_id')
                ->where('catatan_kegiatans.id', '=', $request['id'])
                ->get(['catatan_kegiatans.*', 'detail_users.namaLengkap']);
        }
        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }
}
