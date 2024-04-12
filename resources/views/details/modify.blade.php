@extends('layouts.header')
@section('content')
<section style="background-color: #eee;">

@if (session()->has('success'))
<div class="row alert alert-success ml-0 col-12" role="alert">
    {{ session('success') }}
</div>
@endif
@if (session()->has('error'))
    <div class="row alert alert-danger ml-0 col-12" role="alert">
    {{ session('error') }}
    </div>
@endif

<div class="container row">
    <div class="col-md-12">
        @foreach ($historicalData as $versionIndex => $version)
        <div class="card my-2" style="width: 100%">
            <form method="POST" action="/details/undo/{{ $pendaftaran->id }}">
            @method('PUT')
            @csrf
            <div class="card-header">
            <input type="hidden" name="version" id="version" value="{{ $versionIndex }}">
            <p>Reviewing changes made on <b>{{ \Carbon\Carbon::parse($version['timestamp'])->format('F j, Y, g:i A') }}</b>, here are the old values:</p>
            </div>
            {{-- <div class="row">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        @foreach ($version as $column => $newValue)
                            @if ($column !== 'timestamp')
                                <li class="list-group-item">{{ ucfirst(str_replace('_', ' ', $column)) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        @foreach ($version as $column => $newValue)
                            @if ($column !== 'timestamp')
                                <li class="list-group-item"> {{ $newValue ?? '-' }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div> --}}
            <div class="table-responsive">
                <table class="table custom-table-responsive">
                    <tbody>
                        @foreach ($version as $column => $newValue)
                            @if ($column !== 'timestamp')
                                <tr>
                                    <td class="fw-bold px-3" style="background-color: #f0f0f0; width: 50%;">{{ ucfirst(str_replace('_', ' ', $column)) }}</td>
                                    <td class="px-3">{{ $newValue ?? '-' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <ul class="list-group list-group-flush">
                @foreach ($version as $column => $newValue)
                    @if ($column !== 'timestamp')
                        <li class="list-group-item">{{ ucfirst(str_replace('_', ' ', $column)) }} : {{ $newValue ?? '-' }}</li>
                    @endif
                @endforeach
            </ul> --}}
            <div class="card-footer d-flex justify-content-center">
                <button class="btn btn-success bold">Undo to this Version</button>
            </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

</section>
@endsection