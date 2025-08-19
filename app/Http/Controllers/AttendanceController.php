<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use PDF; // Gunakan facade PDF yang benar
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = DB::table('absensis')->orderBy('created_at', 'desc')->get();
        
        // Calculate interest distribution
        $interestCounts = DB::table('absensis')
            ->select('minat', DB::raw('count(*) as count'))
            ->groupBy('minat')
            ->pluck('count', 'minat')
            ->toArray();
        
        // Calculate daily attendance
        $dailyAttendance = DB::table('absensis')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->pluck('count', 'date')
            ->toArray();
        
        $totalAttendees = array_sum($interestCounts);
        $maxDailyAttendance = empty($dailyAttendance) ? 0 : max($dailyAttendance);

        return view('dashboard', compact(
            'attendances',
            'interestCounts',
            'dailyAttendance',
            'totalAttendees',
            'maxDailyAttendance'
        ));
    }

    public function export()
    {
        // Mendapatkan semua data absensi
        $attendances = DB::table('absensis')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Memeriksa apakah ada data absensi
        if ($attendances->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data absensi untuk diekspor.');
        }

        // Data yang akan dikirim ke view PDF
        $data = [
            'attendances' => $attendances,
            'title' => 'Laporan Absensi Lengkap',
            'date' => date('d-m-Y')
        ];

        // Memuat view 'pdf.attendance' dan mengubahnya menjadi PDF
        $pdf = PDF::loadView('pdf.attendance', $data);

        // Mengunduh file PDF
        return $pdf->download('laporan-absensi-'.date('Y-m-d').'.pdf');
    }

    public function exportExcel()
    {
        // Mendapatkan semua data absensi
        $attendances = DB::table('absensis')
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($attendances->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data absensi untuk diekspor.');
        }
    
        // Header Excel
        $headers = [
            ['Nama','Email','No Telepon','Minat','Tanggal Absensi']
        ];
    
        // Data Excel
        $data = [];
        foreach ($attendances as $attendance) {
            $data[] = [
                $attendance->nama,
                $attendance->email,
                $attendance->no_telpon,
                $attendance->minat,
                $attendance->created_at
            ];
        }
    
        // Export dengan styling
        return Excel::download(new class($headers, $data) implements FromArray, WithStyles
        {
            private $headers;
            private $data;
    
            public function __construct($headers, $data)
            {
                $this->headers = $headers;
                $this->data = $data;
            }
    
            public function array(): array
            {
                return array_merge($this->headers, $this->data);
            }
    
            public function styles(Worksheet $sheet)
            {
                // Hitung total row (header + data)
                $totalRows = count($this->headers) + count($this->data);
    
                // Style untuk header
                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF']
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD']
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);
    
                // Tambahkan border untuk semua cell (header + data)
                $sheet->getStyle('A1:E'.$totalRows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);
    
                // Auto size kolom
                foreach(range('A','E') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            }
        }, 'laporan-absensi-'.date('Y-m-d').'.xlsx');
    }
    

    public function getAttendanceCount()
    {
        // Group attendance data by date and count students
        $attendanceCounts = DB::table('absensis')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as student_count'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $attendanceCounts
        ]);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update($request->only(['nama', 'email', 'no_telpon', 'minat']));

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.')->with('resetTable', true);
    }
}
