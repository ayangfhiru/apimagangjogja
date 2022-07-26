<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function Absen(Request $request)
    {
        try {
            $validate = $request->validate([
                'lokasi' => 'required|string',
                'time' => 'required',
                'status' => 'required'
            ]);

            $timestamp = $validate['time'];
            $data = Absen::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
            if ($validate['status'] == 'masuk' && $data == null) {
                Absen::create([
                    'user_id' => Auth::user()->id,
                    'lokasi' => $validate['lokasi'],
                    'tanggal' => date('y-m-d'),
                    'masuk' => $timestamp,
                ]);
                $message = "masuk";
            } elseif ($validate['status'] == 'istirahat_keluar') {
                $data = Absen::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                if ($data->istirahatKeluar == null) {
                    $data->istirahatKeluar = $timestamp;
                    $data->save();
                    $message = "istirahat keluar";
                }
            } elseif ($validate['status'] == 'istirahat_masuk') {
                $data = Absen::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                if ($data->istirahatMasuk == null) {
                    $data->istirahatMasuk = $timestamp;
                    $data->save();
                    $message = "istirahat masuk";
                }
            } elseif ($validate['status'] == 'izin_keluar') {
                $data = Absen::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                if ($data->izinKeluar == null) {
                    $data->izinKeluar = $timestamp;
                    $data->save();
                    $message = "istirahat masuk";
                }
            } elseif ($validate['status'] == 'izin_masuk') {
                $data = Absen::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                if ($data->izinMasuk == null) {
                    $data->izinMasuk = $timestamp;
                    $data->save();
                    $message = "izin masuk";
                }
            } elseif ($validate['status'] == 'pulang') {
                $data = Absen::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
                if ($data->pulang == null) {
                    $data->pulang = $timestamp;
                    $data->save();
                    $message = "pulang";
                }
            } else {
                $message = "Saatnya pulang";
            }

            $result = Absen::where('user_id', Auth::user()->id)->orderBy('tanggal', 'desc')->first();
            return response()->json([
                'success' => true,
                'data' => $result,
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th
            ]);
        }
    }

    public function getAbsen()
    {
        try {
            $userId = Auth::user()->id;
            $data = Absen::where('user_id', $userId)->where('tanggal', date('Y-m-d'))->first();
            if ($data != null) {
                return response()->json([
                    'successs' => true,
                    'data' => $data
                ]);
            }
            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'successs' => false,
                'data' => $err
            ]);
        }
    }

    public function getAbsensiGuru(Request $request)
    {
        // SELECT * FROM absens JOIN users ON absens.user_id = users.id 
        // JOIN detail_users ON users.id = detail_users.user_id 
        // WHERE absens.user_id = 1
        if ($request['id'] != null) {
            $data = DB::table('absens')
                ->join('users', 'absens.user_id', '=', 'users.id')
                ->join('detail_users', 'users.id', '=', 'detail_users.user_id')
                ->where('absens.user_id', '=', $request['id'])
                ->get(['detail_users.namaLengkap', 'absens.*']);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }
}
