<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;

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
        $maxDailyAttendance = max($dailyAttendance);

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
        $attendances = DB::table('absensis')->get();
        
        $filename = 'attendance-'.date('Y-m-d').'.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        $handle = fopen('php://output', 'w');
        
        fputcsv($handle, ['Name', 'Email', 'Phone', 'Interest', 'Created At']);
        
        foreach ($attendances as $attendance) {
            fputcsv($handle, [
                $attendance->nama,
                $attendance->email,
                $attendance->no_telpon,
                $attendance->minat,
                $attendance->created_at
            ]);
        }
        
        fclose($handle);
        exit;
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