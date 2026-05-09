@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card shadow-sm mt-4">

                <div class="card-header bg-success text-white">
                    Status Produksi
                </div>

                <div class="card-body">

                    {{-- CARD RINGKASAN --}}
                    <div class="row g-4 mb-4">

                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">

                                    <div>
                                        <div class="fw-bold text-secondary">
                                            Produksi Hari Ini
                                        </div>

                                        <div class="fs-4">
                                            {{ $produksiHarian }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">

                                    <div>
                                        <div class="fw-bold text-secondary">
                                            Produksi Mingguan
                                        </div>

                                        <div class="fs-4">
                                            {{ $produksiMingguan }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">

                                    <span class="fs-1 me-3 text-warning">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>

                                    <div>
                                        <div class="fw-bold text-secondary">
                                            Produksi Bulanan
                                        </div>

                                        <div class="fs-4">
                                            {{ $produksiBulanan }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- TABEL PRODUKSI --}}
                    <div class="mt-4">

                        <h5 class="fw-bold mb-3">
                            Daftar Produksi Terbaru
                        </h5>

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover">

                                <thead class="table-light">

                                    <tr>

                                        <th>Tanggal</th>
                                        <th>Kandang</th>
                                        <th>Jumlah Telur</th>
                                        <th>Telur Layak</th>
                                        <th>Telur Tidak Layak</th>
                                        <th>Status</th>
                                        <th>Aksi</th>

                                    </tr>

                                </thead>

                                <tbody id="produksi-table-body">

                                    @foreach($listProduksi as $produksi)

                                        <tr>

                                            <td>
                                                {{ $produksi->tanggal }}
                                            </td>

                                            <td>
                                                {{ $produksi->kandang->nama ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $produksi->jumlah }}
                                            </td>

                                            <td>
                                                {{ $produksi->telur_layak ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $produksi->telur_tidak_layak ?? '-' }}
                                            </td>

                                            <td>

                                                <span class="badge
                                                    {{ $produksi->status == 'approved' || $produksi->status == 'final'
                                                        ? 'bg-success'
                                                        : ($produksi->status == 'draft'
                                                            ? 'bg-warning'
                                                            : ($produksi->status == 'rejected'
                                                                ? 'bg-danger'
                                                                : 'bg-secondary')) }}
                                                    text-white">

                                                    {{ ucfirst($produksi->status) }}

                                                </span>

                                            </td>

                                            <td>

                                                @if(
                                                    $produksi->status != 'final' &&
                                                    $produksi->status != 'approved' &&
                                                    $produksi->status != 'rejected'
                                                )

                                                    <form
                                                        method="POST"
                                                        action="{{ route('produksi.validasi', $produksi->id) }}"
                                                        style="display:inline;"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Setujui data produksi ini?')"
                                                        >
                                                            Approved
                                                        </button>

                                                    </form>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('produksi.reject', $produksi->id) }}"
                                                        style="display:inline; margin-left:4px;"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Tolak data produksi ini?')"
                                                        >
                                                            Rejected
                                                        </button>

                                                    </form>

                                                @elseif(
                                                    $produksi->status == 'approved' ||
                                                    $produksi->status == 'final'
                                                )

                                                    <span class="text-success">
                                                        Approved
                                                    </span>

                                                @elseif($produksi->status == 'rejected')

                                                    <span class="text-danger">
                                                        Rejected
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                    {{-- PAGINATION --}}
                    <div class="d-flex justify-content-end align-items-center mt-2">

                        <div class="d-flex align-items-center gap-2">

                            <form method="get" class="d-flex align-items-center gap-1">

                                <label
                                    for="perPage"
                                    class="form-label mb-0 me-1 small"
                                >
                                    Tampil
                                </label>

                                <select
                                    name="perPage"
                                    id="perPage"
                                    class="form-select form-select-sm d-inline-block w-auto"
                                    style="font-size:0.85em;min-width:60px;"
                                    onchange="this.form.submit()"
                                >

                                    <option value="10"
                                        {{ request('perPage',25)==10 ? 'selected' : '' }}>
                                        10
                                    </option>

                                    <option value="25"
                                        {{ request('perPage',25)==25 ? 'selected' : '' }}>
                                        25
                                    </option>

                                    <option value="50"
                                        {{ request('perPage',25)==50 ? 'selected' : '' }}>
                                        50
                                    </option>

                                    <option value="100"
                                        {{ request('perPage',25)==100 ? 'selected' : '' }}>
                                        100
                                    </option>

                                </select>

                                <span class="ms-1 small">
                                    data
                                </span>

                            </form>

                            <div>
                                {!! $listProduksi->links('pagination::bootstrap-5') !!}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

async function fetchProduksiTable() {

    try {

        const response = await fetch('/realtime-produksi');

        const data = await response.json();

        let tbody = '';

        data.forEach(function(produksi) {

            let badgeClass = 'bg-secondary';

            if (
                produksi.status === 'approved' ||
                produksi.status === 'final'
            ) {

                badgeClass = 'bg-success';

            } else if (produksi.status === 'draft') {

                badgeClass = 'bg-warning';

            } else if (produksi.status === 'rejected') {

                badgeClass = 'bg-danger';
            }

            tbody += `
                <tr>

                    <td>${produksi.tanggal}</td>

                    <td>
                        ${produksi.kandang
                            ? produksi.kandang.nama
                            : '-'}
                    </td>

                    <td>${produksi.jumlah}</td>

                    <td>${produksi.telur_layak ?? '-'}</td>

                    <td>${produksi.telur_tidak_layak ?? '-'}</td>

                    <td>
                        <span class="badge ${badgeClass} text-white">
                            ${produksi.status}
                        </span>
                    </td>

                    <td>-</td>

                </tr>
            `;
        });

        document.getElementById('produksi-table-body').innerHTML = tbody;

    } catch (error) {

        console.log('Error realtime:', error);
    }
}

// load pertama
fetchProduksiTable();

// auto refresh tiap 2 detik
setInterval(fetchProduksiTable, 2000);

</script>

@endpush