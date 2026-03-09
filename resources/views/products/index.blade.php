<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📦 Daftar Produk</h4>
        </div>

        <div class="card-body">

            <!-- Alert sukses -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <a href="{{ route('products.create') }}" class="btn btn-success mb-3">
                ➕ Tambah Produk
            </a>

            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>Rp {{ number_format($product->price) }} /kg</td>
                            <td>{{ $product->stock }}</td>
                            <td>

                                <!-- 🔍 DETAIL -->
                                <button
                                    class="btn btn-info btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-name="{{ $product->name }}"
                                    data-price="Rp {{ number_format($product->price) }} /kg"
                                    data-stock="{{ $product->stock }}"
                                    data-description="{{ $product->description ?? 'Tidak ada deskripsi' }}"
                                    data-image="{{ $product->image }}"
                                >
                                    🔍 Detail
                                </button>

                                <!-- ✏️ EDIT -->
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="btn btn-warning btn-sm">
                                    ✏️ Edit
                                </a>

                                <!-- 🗑 HAPUS -->
                                <a href="#" class="btn btn-danger btn-sm"
                                   onclick="event.preventDefault();
                                            if(confirm('Yakin hapus produk ini?')) {
                                                document.getElementById('delete-form-{{ $product->id }}').submit();
                                            }">
                                    🗑 Hapus
                                </a>

                                <form id="delete-form-{{ $product->id }}"
                                      action="{{ route('products.destroy', $product->id) }}"
                                      method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- ================= MODAL DETAIL PRODUK ================= -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">

            <!-- HEADER -->
            <div class="modal-header bg-gradient bg-info text-white">
                <h5 class="modal-title fw-bold" id="modalName"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <div class="row">

                    <!-- GAMBAR -->
                    <div class="col-md-5 text-center mb-3">
                        <img id="modalImage"
                             src=""
                             class="img-fluid rounded shadow-sm"
                             style="max-height:280px; display:none;">
                    </div>

                    <!-- DETAIL -->
                    <div class="col-md-7">
                        <p class="mb-2">
                            <span class="badge bg-success fs-6">
                                💰 <span id="modalPrice"></span>
                            </span>
                        </p>

                        <p class="mb-2">
                            <span class="badge bg-primary fs-6">
                                📦 Stok: <span id="modalStock"></span>
                            </span>
                        </p>

                        <hr>

                        <h6 class="fw-bold">📝 Deskripsi Produk</h6>
                        <p id="modalDescription" class="text-muted"></p>
                    </div>

                </div>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT MODAL -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('detailModal');

    detailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('modalName').innerText = button.dataset.name;
        document.getElementById('modalPrice').innerText = button.dataset.price;
        document.getElementById('modalStock').innerText = button.dataset.stock;
        document.getElementById('modalDescription').innerText = button.dataset.description;

        const image = button.dataset.image;
        const img = document.getElementById('modalImage');

        if (image) {
            img.src = `/storage/${image}`;
            img.style.display = 'block';
        } else {
            img.style.display = 'none';
        }
    });
});
</script>

</body>
</html>