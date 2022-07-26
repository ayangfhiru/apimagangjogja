<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailUserController extends Controller
{
    public function addDetailUser(Request $request)
    {
        try {
            $validationUser = $request->validate([
                'namaLengkap' => 'string|required',
                'nik' => 'string|required',
                'jenisKelamin' => 'string|required|max:12',
                'nomorWhatsapp' => 'string|required|max:15',
                'asalSekolah' => 'string|required',
                'programStudi' => 'string|required',
                'kotaAsal' => 'string|required',
                'alasanMagang' => 'string|required',
                'jenisMagang' => 'string|required|max:20',
                'sistemMagang' => 'string|required|max:5',
                'statusAnda' => 'string|required|max:20',
                'bukuInggris' => 'string|required|max:20',
                'whatsappDosen' => 'string|required|max:15',
                'programMagang' => 'string|required|max:50',
                'jamKerja' => 'string|required|max:15',
                'yangDikuasai' => 'string',
                'laptop' => 'string|required|max:10',
                'memilikiAlat' => 'string|required',
                'mulaiMagang' => 'string|required|max:30',
                'infoMagang' => 'string|required|max:20',
                'motor' => 'string|required|max:10',
                'tglGabung' => 'string',
                'curriculumvitae' => 'string|required',
                'portofolio' => 'string|required'
            ]);


            $detail = DetailUser::create([
                'user_id' => Auth::user()->id,
                'namaLengkap' => $validationUser['namaLengkap'],
                'nik' => $validationUser['nik'],
                'jenisKelamin' => $validationUser['jenisKelamin'],
                'nomorWhatsapp' => $validationUser['nomorWhatsapp'],
                'asalSekolah' => $validationUser['asalSekolah'],
                'programStudi' => $validationUser['programStudi'],
                'kotaAsal' => $validationUser['kotaAsal'],
                'alasanMagang' => $validationUser['alasanMagang'],
                'jenisMagang' => $validationUser['jenisMagang'],
                'sistemMagang' => $validationUser['sistemMagang'],
                'statusAnda' => $validationUser['statusAnda'],
                'bukuInggris' => $validationUser['bukuInggris'],
                'whatsappDosen' => $validationUser['whatsappDosen'],
                'programMagang' => $validationUser['programMagang'],
                'jamKerja' => $validationUser['jamKerja'],
                'yangDikuasai' => $validationUser['yangDikuasai'],
                'laptop' => $validationUser['laptop'],
                'memilikiAlat' => $validationUser['memilikiAlat'],
                'mulaiMagang' => $validationUser['mulaiMagang'],
                'infoMagang' => $validationUser['infoMagang'],
                'motor' => $validationUser['motor'],
                'tglGabung' => $validationUser['tglGabung'],
                'curriculumvitae' => $validationUser['curriculumvitae'],
                'portofolio' => $validationUser['portofolio']
            ]);
    
            return response()->json([
                'success' => true,
                'data' => $detail
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'data' => $err
            ]);
        }
    }

    public function uploadCv(Request $request)
    {
        if ($request->file('curriculumvitae')) {
            $namefilenameWithExt = $request->file('curriculumvitae')->getClientOriginalName();
            $filename = pathinfo($namefilenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('curriculumvitae')->getClientOriginalExtension();

            $filenameCv = $filename.'.'.$extension;
            $moveFile = $request->file('curriculumvitae')->storeAs('cv', $filenameCv);
        }
    }

    public function uploadPorto(Request $request)
    {
        if ($request->file('portofolio')) {
            $namefilenameWithExt = $request->file('portofolio')->getClientOriginalName();
            $filename = pathinfo($namefilenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('portofolio')->getClientOriginalExtension();

            $filenamePorto = $filename.'.'.$extension;
            $moveFile = $request->file('portofolio')->storeAs('portofolio', $filenamePorto);
        }
    }

    public function getDetailUser()
    {
        $detailUser = DetailUser::all();
        return response()->json([
            'success' => true,
            'data' => $detailUser
        ], 200);
    }

    public function  getDetailUserId(Request $request)
    {
        try {
            $user = $request->user();
            $detailUserId = DetailUser::where('user_id', $user->id)->first();
            if ($detailUserId != null) {
                return response()->json([
                    'success' => true,
                    'data' => [$detailUserId]
                ]);
            }
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'data' => $th
            ]);
        }
    }
}
