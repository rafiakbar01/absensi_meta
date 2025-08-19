@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary fw-bold">Absensi Dashboard</h2>
            <p class="text-muted">View and manage Absensi records</p>
        </div>
        <!-- <div class="col-md-4 text-end">
            <a href="{{ route('export.attendance') }}" class="btn btn-success">
                <i class="fas fa-file-export me-2"></i>Export to Excel
            </a>
        </div> -->
    </div>


<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="card-title">Interest Distribution</h5>
                <div id="interestChart" style="height: 370px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="card-title">Daily Attendance</h5>
                <div id="dailyChart" style="height: 370px;"></div>
            </div>  
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Distribusi Minat
    Highcharts.chart('interestChart', {
        chart: {
            type: 'pie'
        },
        title: {
            text: ''
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($interestCounts as $interest => $count)
                {
                    name: '{{ $interest }}',
                    y: {{ $count }}
                },
                @endforeach
            ]
        }]
    });

    // Chart Kehadiran Harian
    Highcharts.chart('dailyChart', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: @json(array_keys($dailyAttendance))
        },
        yAxis: {
            title: {
                text: 'Jumlah Kehadiran'
            },
            min: 0
        },
        series: [{
            name: 'Kehadiran',
            data: @json(array_values($dailyAttendance)),
            color: '#36A2EB'
        }]
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('export.attendance') }}" class="btn btn-danger me-2">
        <i class="fas fa-file-pdf me-2"></i>Export to PDF
    </a>
    <a href="{{ route('export.attendance.excel') }}" class="btn btn-success">
        <i class="fas fa-file-excel me-2"></i>Export to Excel
    </a>
</div>


<div class="card border-0 shadow-lg rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <div class="table-wrapper" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-hover mb-0 border border-3 border-dark">
                    <thead class="bg-light position-sticky" style="top: 0; z-index: 1;">
                        <tr>
                            <th class="px-4 py-3 border border-2 border-dark">Nama</th>
                            <th class="px-4 py-3 border border-2 border-dark">Email</th>
                            <th class="px-4 py-3 border border-2 border-dark">Phone</th>
                            <th class="px-4 py-3 border border-2 border-dark">Interest</th>
                            <th class="px-4 py-3 border border-2 border-dark">Date</th>
                            <th class="px-4 py-3 border border-2 border-dark">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-3 border border-2 border-dark">{{ $attendance->nama }}</td>
                            <td class="px-4 py-3 border border-2 border-dark">{{ $attendance->email }}</td>
                            <td class="px-4 py-3 border border-2 border-dark">{{ $attendance->no_telpon }}</td>
                            <td class="px-4 py-3 border border-2 border-dark">{{ $attendance->minat }}</td>
                            <td class="px-4 py-3 border border-2 border-dark">{{ $attendance->created_at }}</td>
                            <td class="px-4 py-3 border border-2 border-dark">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $attendance->id }}" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('attendance.destroy', $attendance->id) }}"
                                        method="POST"
                                        onsubmit="event.preventDefault(); Swal.fire({
                                            title: 'Apakah Anda yakin?',
                                            text: 'Data yang dihapus tidak dapat dikembalikan!',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, Hapus!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                this.submit();
                                                Swal.fire({
                                                    title: 'Sukses!',
                                                    text: 'Data berhasil dihapus.',
                                                    icon: 'success',
                                                    confirmButtonText: 'OK'
                                                });
                                            }
                                        })">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editModal{{ $attendance->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $attendance->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" onsubmit="event.preventDefault(); 
                                        Swal.fire({
                                            title: 'Apakah Anda yakin?',
                                            text: 'Anda akan menyimpan perubahan data ini',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Ya, Simpan!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                this.submit();
                                                Swal.fire({
                                                    title: 'Sukses!',
                                                    text: 'Data berhasil diperbarui.',
                                                    icon: 'success',
                                                    confirmButtonText: 'OK'
                                                });
                                            }
                                        })">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $attendance->id }}">Edit Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $attendance->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $attendance->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">No Telepon</label>
                                                <input type="text" name="no_telpon" class="form-control" value="{{ $attendance->no_telpon }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Minat</label>
                                                <input type="text" name="minat" class="form-control" value="{{ $attendance->minat }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada data kehadiran yang ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        table {
            width: 100%;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
            position: relative;
        }
        
        thead {
            display: table-header-group;
            position: sticky;
            top: 0;
            z-index: 2;
            background-color: #f8f9fa;
        }
        
        tbody {
            display: table-row-group;
        }
        
        tr {
            display: table-row;
        }
        
        th, td {
            display: table-cell;
            padding: 0.5rem;
            vertical-align: middle;
            white-space: normal;
            min-width: 120px;
        }
        
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .d-flex.gap-2 {
            white-space: nowrap;
        }
        
        .position-sticky {
            position: sticky;
            top: 0;
            z-index: 1;
        }
        
        /* Fix for mobile header */
        thead tr {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
        }
        
        th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
        }
    }
</style>



<style>
    .table th {
        font-weight: 600;
        color: #444;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection