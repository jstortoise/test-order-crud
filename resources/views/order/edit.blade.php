@extends('layouts.app')

@section('title', 'Update Order')

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h2>Update Order</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="key">Key</label>
            <select class="form-control" name="key" id="key" required>
                @foreach ($keys as $key)
                    <option value="{{ $key->id }}" @if ($key->id == $order->key_id) selected @endif>{{ $key->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="vehicle">Vehicle</label>
            <select class="form-control" name="vehicle" id="vehicle" required>
                @foreach ($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" @if ($vehicle->id == $order->vehicle_id) selected @endif>{{ $vehicle->model }} {{ $vehicle->year }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="technician">Technician</label>
            <select class="form-control" name="technician" id="technician" required>
                @foreach ($technicians as $technician)
                    <option value="{{ $technician->id }}" @if ($technician->id == $order->technician_id) selected @endif>{{ $technician->last_name }}, {{ $technician->first_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection

@push('scripts')
    <script>
        $('#key').change(function () {
            $.get(`/orders/getVehiclesByKey/${$(this).val()}`, function (res) {
                $('#vehicle').empty();
                for (let i = 0; i < res.length; i++) {
                    $('#vehicle').append(`<option value="${res[i].id}">${res[i].model} ${res[i].year}</option>`)
                }
            });
        });
    </script>
@endpush