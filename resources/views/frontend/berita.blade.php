@extends('frontend/layouts.template')

@section('content')

<section class="berita-section" style="background-color: #f5f5f5; padding: 60px 0; min-height: 100vh;">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 36px; color: #1a1a1a; margin-bottom: 0;">Berita</h1>
        </div>

        <div class="row">
            <!-- Main Content - Kiri -->
            <div class="col-lg-8">
                @forelse ($beritas as $tampil)
                <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; background-color: #fff;">
                    <!-- Image -->
                    <div style="width: 100%; height: 300px; background-color: #d3d3d3; overflow: hidden;">
                        <img src="{{ asset('/storage/berita/'.$tampil->image) }}" alt="{{ $tampil->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <!-- Content -->
                    <div style="padding: 30px;">
                        <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 22px; color: #1a1a1a; margin-bottom: 15px; line-height: 1.4;">
                            {{ $tampil->judul }}
                        </h3>
                        
                        <div style="margin-bottom: 15px;">
                            <p style="font-family: 'Poppins', sans-serif; font-size: 13px; color: #888; margin-bottom: 5px;">
                                <strong>Tanggal Upload :</strong> {{ $tampil->created_at->format('Y-m-d H:i:s') }}
                            </p>
                            <p style="font-family: 'Poppins', sans-serif; font-size: 13px; color: #888; margin-bottom: 0;">
                                <strong>Terakhir Diubah :</strong> {{ $tampil->updated_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 30px; background-color: #fff;">
                    <p style="font-family: 'Poppins', sans-serif; font-size: 16px; color: #666; text-align: center; margin: 0;">
                        Data Berita belum Tersedia.
                    </p>
                </div>
                @endforelse

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $beritas->links() }}
                </div>
            </div>

            <!-- Sidebar - Kanan -->
            <div class="col-lg-4">
                <!-- Search Box -->
                <div class="card mb-4" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px; background-color: #fff;">
                    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #1a1a1a; margin-bottom: 15px;">Search</h4>
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control" placeholder="Kata kunci" style="font-family: 'Poppins', sans-serif; font-size: 14px; border: 1px solid #ddd; border-radius: 6px 0 0 6px;">
                            <button type="submit" class="btn" style="background-color: #016AA3; color: white; border-radius: 0 6px 6px 0; padding: 8px 20px; font-family: 'Poppins', sans-serif; font-weight: 500;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Berita Terbaru -->
                <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px; background-color: #fff;">
                    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 18px; color: #1a1a1a; margin-bottom: 20px;">Berita Terbaru</h4>
                    
                    @foreach ($beritas->take(10) as $recent)
                    <div class="d-flex mb-3" style="padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
                        <div style="width: 80px; height: 60px; background-color: #d3d3d3; border-radius: 6px; overflow: hidden; flex-shrink: 0; margin-right: 15px;">
                            <img src="{{ asset('/storage/berita/'.$recent->image) }}" alt="{{ $recent->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="flex: 1;">
                            <a href="{{ route('berita.show', $recent->id) }}" style="text-decoration: none;">
                                <h6 style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 13px; color: #1a1a1a; margin-bottom: 5px; line-height: 1.4;">
                                    {{ Str::limit($recent->judul, 60) }}
                                </h6>
                            </a>
                            <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #888; margin: 0;">
                                {{ $recent->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
