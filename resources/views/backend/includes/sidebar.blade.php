<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @auth('web')
        {{-- Tanda Tangan --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ttd.*') ? '' : 'collapsed' }}"
                href="{{ route('ttd.index') }}">
                <i class="bi bi-pencil-square"></i>
                <span>Tanda Tangan</span>
            </a>
        </li>

        {{-- Berita --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('input_berita.*') ? '' : 'collapsed' }}"
                href="{{ route('input_berita.index') }}">
                <i class="bi bi-newspaper"></i>
                <span>Berita</span>
            </a>
        </li>

        {{-- Pengumuman --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('input_pengumuman.*') ? '' : 'collapsed' }}"
                href="{{ route('input_pengumuman.index') }}">
                <i class="bi bi-megaphone"></i>
                <span>Pengumuman</span>
            </a>
        </li>
        @endauth

        {{-- Galeri --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('galeribidangumum.*','galeripokja1.*','galeripokja2.*','galeripokja3.*','galeripokja4.*') ? '' : 'collapsed' }}"
                data-bs-target="#galeri_nav"
                data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-image"></i>
                <span>Kegiatan</span>
            </a>
            <ul id="galeri_nav"
                class="nav-content collapse {{ request()->routeIs('galeribidangumum.*','galeripokja1.*','galeripokja2.*','galeripokja3.*','galeripokja4.*') ? 'show' : '' }}">
                <li>
                    <a href="{{ route('galeribidangumum.index') }}"
                        class="{{ request()->routeIs('galeribidangumum.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Bidang Umum</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('galeripokja1.index') }}"
                        class="{{ request()->routeIs('galeripokja1.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 1</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('galeripokja2.index') }}"
                        class="{{ request()->routeIs('galeripokja2.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 2</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('galeripokja3.index') }}"
                        class="{{ request()->routeIs('galeripokja3.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 3</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('galeripokja4.index') }}"
                        class="{{ request()->routeIs('galeripokja4.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 4</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Kelompok Kerja --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('accbidangumum.*','pokja1.*','pokja2.*','pokja3.*','pokja4.*') ? '' : 'collapsed' }}"
                data-bs-target="#pokja_nav"
                data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-briefcase"></i>
                <span>Kelompok Kerja</span>
            </a>
            <ul id="pokja_nav"
                class="nav-content collapse {{ request()->routeIs('accbidangumum.*','pokja1.*','pokja2.*','pokja3.*','pokja4.*') ? 'show' : '' }}">
                <li>
                    <a href="{{ route('accbidangumum.index') }}"
                        class="{{ request()->routeIs('accbidangumum.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Bidang Umum</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pokja1.index') }}"
                        class="{{ request()->routeIs('pokja1.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 1</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pokja2.index') }}"
                        class="{{ request()->routeIs('pokja2.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 2</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pokja3.index') }}"
                        class="{{ request()->routeIs('pokja3.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 3</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pokja4.index') }}"
                        class="{{ request()->routeIs('pokja4.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Kelompok Kerja 4</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Garis pemisah --}}
        <li><hr class="sidebar-divider"></li>

        {{-- Profil --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.*') ? '' : 'collapsed' }}"
                href="{{ route('profile.index') }}">
                <i class="bi bi-person"></i>
                <span>Profil</span>
            </a>
        </li>

        {{-- Logout --}}
        <li class="nav-item">
            <a class="nav-link collapsed text-danger fw-semibold" href="#" onclick="confirmLogout(event)">
                <i class="bi bi-box-arrow-left text-danger"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
</aside>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Keluar Aplikasi?',
            text: "Sesi Anda akan diakhiri. Apakah Anda yakin ingin keluar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // Danger color
            cancelButtonColor: '#6c757d', // Secondary color
            confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i> Ya, Logout',
            cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
            reverseButtons: true, // Batal di kiri, Logout di kanan
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                title: 'fs-4 fw-bold text-dark font-poppins',
                htmlContainer: 'text-muted font-poppins',
                confirmButton: 'btn btn-danger rounded-pill px-4 py-2 mx-2 fw-semibold font-poppins',
                cancelButton: 'btn btn-secondary rounded-pill px-4 py-2 mx-2 fw-semibold font-poppins text-white'
            },
            buttonsStyling: false, // Mematikan style bawaan swal agar class bootstrap berfungsi
            showLoaderOnConfirm: true, // Fitur anti-nyantol: muncul spinner saat ditekan
            preConfirm: () => {
                return new Promise((resolve) => {
                    // Membuat form secara dinamis
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("logout") }}';
                    form.style.display = 'none'; // Sembunyikan form agar tidak merusak layout

                    // Membuat CSRF Token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    // Gabungkan dan eksekusi
                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    
                    // Delay sangat singkat untuk memastikan browser merender DOM sebelum submit
                    setTimeout(() => {
                        form.submit();
                        resolve();
                    }, 100);
                });
            },
            allowOutsideClick: () => !Swal.isLoading() // Tidak bisa diklik di luar kotak saat loading
        });
    }
</script>

<style>
    /* Styling tambahan agar font Poppins teraplikasi dengan baik di SweetAlert */
    .font-poppins {
        font-family: 'Poppins', sans-serif !important;
    }
    
    /* Efek hover pada tombol agar lebih hidup */
    .swal2-confirm.btn-danger:hover {
        background-color: #c82333 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        transition: all 0.2s ease-in-out;
    }
    
    .swal2-cancel.btn-secondary:hover {
        background-color: #5a6268 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
        transition: all 0.2s ease-in-out;
    }
</style>