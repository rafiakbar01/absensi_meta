<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbsensiSubmitted;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensis = Absensi::latest()->get();
        return view('index', compact('absensis'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        \Log::info('Store method called with data: ', $request->all());

        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'minat' => 'required|string',
                'custom_minat' => 'nullable|string|max:255',
                'no_telp' => 'required|string|min:10|max:13',
            ]);
    
            // Handle minat value
            $minatValue = ($validated['minat'] === 'custom' && !empty($validated['custom_minat'])) 
                ? $validated['custom_minat'] 
                : $validated['minat'];
    
            // Create new Absensi record
            $attendance = Absensi::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'minat' => $minatValue,
                'no_telpon' => $validated['no_telp'],
                'tanggal' => now()->format('Y-m-d'),
            ]);
    
            \Log::info('Attendance created: ', $attendance->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil disimpan!'
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error storing data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    public function sendEmail(Request $request)
    {
        $email = $request->input('email'); // Ambil email dari request
        $nama = $request->input('nama'); // Ambil nama dari request
        $no_telpon = $request->input('no_telp'); // Ambil no telepon dari request
        $minat = $request->input('minat'); // Ambil minat dari request

        // Buat instance dari model Absensi
        $attendance = new \App\Models\Absensi([
            'email' => $email,
            'nama' => $nama,
            'no_telpon' => $no_telpon,
            'minat' => $minat,
        ]);

        // Kirim notifikasi email
        $attendance->notify(new \App\Notifications\SendEmail());

        return response()->json([
            'success' => true,
            'message' => 'Email notifikasi berhasil dikirim!'
        ]);
    }
}