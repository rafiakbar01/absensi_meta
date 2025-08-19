<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        /* Mengatur ukuran kertas A4 */
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        p {
            margin-bottom: 10px;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed; /* Supaya lebar kolom bisa diatur */
        }
        th, td {
            border: 1px solid #bdc3c7;
            padding: 8px;
            text-align: left;
            word-wrap: break-word; /* Biar teks panjang otomatis turun ke bawah */
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        th:nth-child(1), td.nama {
            width: 20%;   /* Batasi lebar kolom Nama */
        }
        th:nth-child(2), td:nth-child(2) {
            width: 25%;   /* Batasi Email */
        }
        th:nth-child(3), td:nth-child(3) {
            width: 15%;   /* Batasi No. Telpon */
        }
        th:nth-child(4), td:nth-child(4) {
            width: 15%;   /* Batasi Minat */
        }
        th:nth-child(5), td:nth-child(5) {
            width: 25%;   /* Waktu Absen */
        }
        tbody tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        tbody tr:hover {
            background-color: #bdc3c7;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Tanggal Cetak: {{ $date }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Minat</th>
                <th>Waktu Absen</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
            <tr>
                <td class="nama">{{ $attendance->nama }}</td> <!-- Menambahkan class "nama" -->
                <td>{{ $attendance->email }}</td>
                <td>{{ $attendance->no_telpon }}</td>
                <td>{{ $attendance->minat }}</td>
                <td>{{ $attendance->created_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data absensi yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh sistem.
    </div>
</body>
</html>