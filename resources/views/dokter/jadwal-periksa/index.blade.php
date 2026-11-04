@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Jadwal Periksa Saya</h3>
        <a href="{{ route('dokter.jadwal-periksa.create') }}" class="btn btn-primary">+ Tambah Jadwal</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">No</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $index => $jadwal)
                            <tr>
                                <td class="px-3">{{ $index + 1 }}</td>
                                <td>{{ $jadwal->hari }}</td>
                                <td>{{ $jadwal->jam_mulai }}</td>
                                <td>{{ $jadwal->jam_selesai }}</td>
                                <td>
                                    <span class="badge {{ $jadwal->status == 'Y' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $jadwal->status == 'Y' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('dokter.jadwal-periksa.edit', $jadwal->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                    <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada jadwal periksa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection