@extends('frontend/layouts.template')

@section('content')

<!-- Main -->
<main id="main">

  <!-- Page Title Section -->
  <section class="gallery-header">
    <div class="container">
      <h1 class="gallery-main-title">Galeri Kegiatan PKK</h1>
      <p class="gallery-subtitle">Kabupaten Nganjuk</p>
    </div>
  </section>

  <!-- Gallery Content Section -->
  <section class="gallery-content">
    <div class="container">

      <!-- Search Bar -->
      <div class="search-section">
        <h3 class="search-label">Search</h3>
        <form action="" method="GET" class="search-form">
          <input type="search" name="search" class="search-input" placeholder="Kata kunci" value="{{ request('search') }}">
          <button type="submit" class="search-button">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>

      <!-- Gallery Title -->
      <h3 class="gallery-section-title">Galeri</h3>

      <!-- Gallery Grid -->
      <div class="gallery-grid">

        @forelse ($galerys as $tampil)

        <div class="gallery-card"
          data-image="{{ asset('storage/gallery/'.$tampil->gambar) }}"
          data-title="{{ $tampil->deskripsi }}"
          data-date="{{ \Carbon\Carbon::parse($tampil->tanggal)->format('Y-m-d H:i:s') }}"
          onclick="openModal(
        this.dataset.image,
        this.dataset.title,
        this.dataset.date
    )">

          <div class="gallery-card-image">

            <img
              src="{{ asset('storage/gallery/'.$tampil->gambar) }}"
              alt="{{ $tampil->deskripsi }}">

          </div>

        </div>

        @empty

        <div class="gallery-empty">
          <p>Data galeri belum tersedia.</p>
        </div>

        @endforelse

      </div>

      <!-- Pagination -->
      @if($galerys->hasPages())
      <div class="gallery-pagination">
        {{ $galerys->links() }}
      </div>
      @endif

    </div>
  </section>

</main>

<!-- Modal Popup -->
<div id="galleryModal" class="modal-overlay" onclick="closeModal()">
  <div class="modal-content" onclick="event.stopPropagation()">
    <span class="modal-close" onclick="closeModal()">&times;</span>
    <div class="modal-image-container">
      <img id="modalImage" src="" alt="">
    </div>
    <div class="modal-info">
      <h3 id="modalTitle"></h3>
      <p id="modalDate"></p>
    </div>
  </div>
</div>

<!-- Gallery Page Styles -->
<style>
  * {
    box-sizing: border-box;
  }

  .gallery-header {
    background: #ffffff;
    padding: 60px 0 40px;
    text-align: center;
  }

  .gallery-main-title {
    font-family: 'Poppins', sans-serif;
    font-size: 36px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 10px 0;
  }

  .gallery-subtitle {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 400;
    color: #7f8c8d;
    margin: 0;
  }

  .gallery-content {
    background: #f8f9fa;
    padding: 40px 0 80px;
    min-height: 60vh;
  }

  .search-section {
    background: transparent;
    padding: 0 0 30px 0;
    border-radius: 0;
    box-shadow: none;
    margin-bottom: 40px;
  }

  .search-label {
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 15px 0;
  }

  .search-form {
    display: flex;
    gap: 10px;
    max-width: 500px;
  }

  .search-input {
    flex: 1;
    padding: 12px 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    transition: all 0.3s ease;
  }

  .search-input:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
  }

  .search-button {
    padding: 12px 24px;
    background: #016AA3;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .search-button:hover {
    background: #015a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
  }

  .gallery-section-title {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 30px 0;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
  }

  .gallery-card {
    background: #d9d9d9;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .gallery-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
  }

  .gallery-card-image {
    width: 100%;
    height: 280px;
    overflow: hidden;
    background: #c4c4c4;
  }

  .gallery-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .gallery-card:hover .gallery-card-image img {
    transform: scale(1.1);
  }

  .gallery-empty {
    grid-column: 1 / -1;
    background: #ffffff;
    padding: 60px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  }

  .gallery-empty p {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    color: #95a5a6;
    margin: 0;
  }

  .gallery-pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
  }

  /* Modal Styles */
  .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    padding: 20px;
    animation: fadeIn 0.3s ease;
  }

  .modal-overlay.active {
    display: flex;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  .modal-content {
    background: #ffffff;
    border-radius: 16px;
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    overflow: auto;
    position: relative;
    animation: slideUp 0.3s ease;
  }

  @keyframes slideUp {
    from {
      transform: translateY(50px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .modal-close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 32px;
    font-weight: bold;
    color: #ffffff;
    cursor: pointer;
    z-index: 10;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    transition: all 0.3s ease;
  }

  .modal-close:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: rotate(90deg);
  }

  .modal-image-container {
    width: 100%;
    max-height: 500px;
    overflow: hidden;
    background: #000;
  }

  .modal-image-container img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .modal-info {
    padding: 30px;
  }

  .modal-info h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 22px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 15px 0;
    line-height: 1.5;
  }

  .modal-info p {
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    font-weight: 400;
    color: #7f8c8d;
    margin: 0;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .gallery-main-title {
      font-size: 28px;
    }

    .gallery-subtitle {
      font-size: 16px;
    }

    .search-section {
      padding: 20px;
    }

    .search-form {
      flex-direction: column;
    }

    .search-button {
      width: 100%;
    }

    .gallery-grid {
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .gallery-card-image {
      height: 220px;
    }

    .modal-content {
      max-width: 95%;
    }

    .modal-info {
      padding: 20px;
    }

    .modal-info h3 {
      font-size: 18px;
    }

    .modal-info p {
      font-size: 14px;
    }
  }

  @media (max-width: 480px) {
    .gallery-header {
      padding: 40px 0 30px;
    }

    .gallery-main-title {
      font-size: 24px;
    }

    .gallery-content {
      padding: 30px 0 60px;
    }

    .gallery-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .gallery-card-image {
      height: 250px;
    }
  }
</style>

<!-- Modal Script -->
<script>
  function openModal(imageSrc, title, date) {
    const modal = document.getElementById('galleryModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDate = document.getElementById('modalDate');

    modalImage.src = imageSrc;
    modalTitle.textContent = title;
    modalDate.textContent = date;

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    const modal = document.getElementById('galleryModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
  }

  // Close modal with ESC key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      closeModal();
    }
  });
</script>

@endsection