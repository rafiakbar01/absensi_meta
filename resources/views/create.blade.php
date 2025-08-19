@extends('layouts.app')


@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Left Side - Form Attendance Info -->
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-3 mb-4 bg-secondary bg-opacity-25 sticky-top" style="top: 20px; height: fit-content; margin-right: 1%">
                <div class="card-body p-4">
                    <h3 class="text-primary fw-bold mb-2">FORM ATTENDENCE</h3>
                    <p class="text-muted mb-4 fs-5">MICO <span style="color: blue;">HIM</span><span style="color: red;">TECH</span> 2025</p>
                    
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock text-primary me-3 fs-4"></i>
                            <span class="text-muted fs-5">TIME</span>
                        </div>
                        <p class="mb-4 ms-5 text-dark fs-4">08.00 - 12.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Input Form -->
        <div class="col-md-6">
            <!-- Existing Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header dengan Gradient -->
                <div class="card-header border-0 py-4" style="background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);">
                    <div class="d-flex align-items-center">
<!--                      
                        <div>
                            <h4 class="mb-0 text-white">Form Absensi</h4>
                            <p class="mb-0 text-white-50">Silakan isi data kehadiran Anda</p>
                        </div> -->
                               <!-- Info Card -->
            <div class="card border-0 shadow-sm rounded-4 mt-4 ms-3">
                <div class="card-body p-7">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary fs-4 me-3"></i>
                        <p class="mb-2 text-muted">
                            Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan form.
                        </p>
                    </div>
                </div>
            </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Alert Success -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" 
                         style="background-color: #d1e7dd;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fs-4 me-2"></i>
                            <div>
                                <strong>Berhasil!</strong>
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Form -->
                    <form id="absensiForm" method="POST" action="{{ route('store') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Nama Field - Moved up -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="fas fa-user text-primary me-2"></i>
                                <span class="fw-bold">Nama Lengkap</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm rounded-3">
                                <input type="text" 
                                       class="form-control border py-3 @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama') }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                            </div>
                            @error('nama')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Hapus field asal_sekolah -->
                        <!--
                        <div class="mb-4">
                            <label for="asal_sekolah" class="form-label">
                                <i class="fas fa-school text-primary me-2"></i>
                                <span class="fw-bold">Asal Sekolah</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text border-0 bg-light">
                                     <i class="fas fa-building-columns text-primary"></i> -->
                                <!-- </span>
                                <input type="text" 
                                       class="form-control border-0 bg-light @error('asal_sekolah') is-invalid @enderror" 
                                       id="asal_sekolah" 
                                       name="asal_sekolah" 
                                       value="{{ old('asal_sekolah') }}" 
                                       placeholder="Masukkan asal sekolah Anda"
                                       required>
                            </div>
                            @error('asal_sekolah')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        --> 

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <span class="fw-bold">Email</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm rounded-3">
                                <input type="email" 
                                       class="form-control border py-3 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Masukkan email Anda"
                                       required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                         <div class="mb-3">
                            <label for="no_telp" class="form-label">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <span class="fw-bold">No Telepon</span>
                            </label>
                            <div class="input-group input-group-lg shadow-sm rounded-3">
                                <input type="tel" 
                                       class="form-control border py-3 @error('no_telp') is-invalid @enderror" 
                                       id="no_telp" 
                                       name="no_telp" 
                                       value="{{ old('no_telp') }}" 
                                       placeholder="Masukkan nomor telepon"
                                       pattern="[0-9]{10,13}"
                                       required>
                            </div>
                            @error('no_telp')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Format: 08xxxxxxxxxx (10-13 digit)
                            </small>
                        </div>


                            <!-- Minat Field -->
                            <div class="mb-4">
                                <label for="minat" class="form-label">
                                    <i class="fas fa-star text-primary me-2"></i>
                                    <span class="fw-bold">Minat Kamu Masuk TRPL</span>
                                </label>
                                <div class="input-group input-group-lg shadow-sm rounded-3">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-lightbulb text-primary"></i>
                                    </span>
                                    <select class="form-control border py-3 @error('minat') is-invalid @enderror"
                                            id="minat"
                                            name="minat"
                                            onchange="toggleCustomMinat(this.value)"
                                            required>
                                        <option value="">Pilih minat Anda</option>
                                        <option value="Web Development">Web Development</option>
                                        <option value="Mobile Development">Mobile Development</option>
                                        <option value="UI/UX Design">UI/UX Design</option>
                                        <option value="Data Science">Data Science</option>
                                        <option value="Network Engineering">Network Engineering</option>
                                        <option value="Cyber Security">Cyber Security</option>
                                        <option value="custom">Lainnya</option>
                                    </select>
                                </div>
                                <!-- Custom Minat Input -->
                                <div id="customMinatInput" class="mt-3" style="display: none;">
                                    <div class="input-group input-group-lg shadow-sm rounded-3">
                                        <span class="input-group-text border-0 bg-light">
                                            <i class="fas fa-edit text-primary"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control border py-3"
                                            id="customMinat"
                                            name="custom_minat"
                                            placeholder="Masukkan minat Anda"
                                            >
                                    </div>
                                </div>
                                @error('minat')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <script>
                            function toggleCustomMinat(value) {
                                const customInput = document.getElementById('customMinatInput');
                                const customMinatField = document.getElementById('customMinat');
                                
                                if (value === 'custom') {
                                    customInput.style.display = 'block';
                                    customMinatField.required = true;
                                } else {
                                    customInput.style.display = 'none';
                                    customMinatField.required = false;
                                    customMinatField.value = '';
                                }
                            }
                            </script>
                                                                                <!-- No Telepon Field -->
                       
                       
                    </form>
                </div>
            </div>
             <!-- Submit Button -->
                      <div class="d-grid gap-2 mt-5">
                            <button type="button" id="btnsubmit" class="btn btn-primary btn-lg rounded-3 shadow">
                                <i class="fas fa-paper-plane me-2"></i>
                                Submit Absensi
                            </button>
                        </div>

     
        </div>
    </div></div>



<!-- Custom CSS -->
<style>
    /* Card Styles */
    .card {
        background: #FFFFFF;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Header Styles */
    .card-header {
        background: #FFFFFF !important;
        border-bottom: none;
        padding: 1.5rem;
    }

    /* Form Title */
    h4.mb-0 {
        color: #333333;
        font-weight: 600;
    }

    /* Form Fields */
    .form-control {
        border: 1px solid #E5E5E5;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        background: #FFFFFF;
    }

    .form-control:focus {
        border-color: #6B73FF;
        box-shadow: 0 0 0 0.2rem rgba(107, 115, 255, 0.25);
        transform: none;
    }

    /* Labels */
    .form-label {
        color: #333333;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    /* Input Groups */
    .input-group-text {
        background: #FFFFFF;
        border: 1px solid #E5E5E5;
        border-right: none;
    }

    /* Submit Button */
    .btn-primary {
        background: #6B73FF;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
    }

    .btn-primary:hover {
        background: #5158FF;
        transform: none;
        box-shadow: 0 4px 6px rgba(107, 115, 255, 0.3);
    }

    /* Form Spacing */
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    /* Placeholder Text */
    ::placeholder {
        color: #999999;
        opacity: 1;
    }

    /* Remove Animation */
    .card:hover {
        transform: none;
    }

    /* Error States */
    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
    }

    /* Success Alert */
    .alert-success {
        background-color: #d1e7dd;
        border: none;
        color: #0f5132;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
    }

    /* Sticky Card */
    .sticky-top {
        position: sticky;
        top: 20px;
        z-index: 1000;
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .sticky-top {
            position: relative;
            top: 0;
        }
    }
</style>

<!-- Custom JavaScript -->
<script>
    // Form Validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // Input Animation
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'all 0.3s ease';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
</script>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('btnsubmit').addEventListener('click', function() {
    const form = document.getElementById('absensiForm');
    const formData = new FormData(form);
    
    // Show loading state
    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
    this.disabled = true;

    fetch("{{ route('store') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            throw data;
        }
        return data;
    })
    .then(data => {
        if (data.success) {
            // Kirim email setelah data berhasil disimpan
            fetch("{{ route('send.email') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: formData.get('email'),
                    nama: formData.get('nama'),
                    no_telp: formData.get('no_telp'),
                    minat: formData.get('minat')
                })
            })
            .then(response => response.json())
            .then(emailData => {
                if (emailData.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan !',
                        timer: 5000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Data berhasil disimpan',
                        timer: 5000,
                        showConfirmButton: false
                    });
                }
                form.reset();
            })
            .catch(emailError => {
                console.error('Error sending email:', emailError);
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Data berhasil disimpan, tetapi email gagal dikirim.',
                    timer: 5000,
                    showConfirmButton: false
                });
            });
        }
    })
    .catch(error => {
        if (error.errors) {
            let errorMessages = '';
            Object.keys(error.errors).forEach(field => {
                const input = form.querySelector(`[name="${field}"]`);
                const feedback = input.parentElement.nextElementSibling;
                
                input.classList.add('is-invalid');
                if (feedback) {
                    feedback.textContent = error.errors[field][0];
                    feedback.style.display = 'block';
                    errorMessages += `${error.errors[field][0]}\n`;
                }
            });
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: errorMessages,
                timer: 5000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Terjadi kesalahan saat mengirim data',
                timer: 5000,
                showConfirmButton: false
            });
        }
    })
    .finally(() => {
        // Reset button state
        this.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Absensi';
        this.disabled = false;
    });
});
</script>
@endsection
