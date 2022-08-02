@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="row mb-1 d-flex justify-content-between align-items-center mt-3">
        <h2>Orders</h2>
        <a class="btn btn-primary" href="{{ route('orders.create') }}">Create Order</a>
    </div>
    @isset($message)
        <p class="alert alert-success">{{ $message }}</p>
    @endisset
    @php
        $darr = '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z"/><path fill-rule="evenodd" d="M10.082 12.629L9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z"/><path d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999l.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/></g></svg>';
        $uarr = '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path fill-rule="evenodd" d="M10.082 5.629L9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/><path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999l.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/></g></svg>';
        if (!$sortBy) {
            $sortArr = $uarr;
        } else if ($sortBy == 'asc') {
            $sortArr = $darr;
        } else {
            $sortArr = $uarr;
        }
    @endphp
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th class="d-flex aling-items-center">
                        Key
                        <a href="{{ route('orders.index') }}?orderBy=key&sort={{ $sortBy && $orderBy == 'key' ? $sortBy : 'asc' }}"> {!! $sortArr !!}</a>
                    </th>
                    <th>
                        Vehicle
                        <a href="{{ route('orders.index') }}?orderBy=vehicle&sort={{ $sortBy && $orderBy == 'vehicle' ? $sortBy : 'asc' }}"> {!! $sortArr !!}</a>
                    </th>
                    <th>
                        Technicain
                        <a href="{{ route('orders.index') }}?orderBy=technician&sort={{ $sortBy && $orderBy == 'technician' ? $sortBy : 'asc' }}"> {!! $sortArr !!}</a>
                    </th>
                    <th>
                        Created At
                    </th>
                    <th>
                        Updated At
                    </th>
                    <th>
                        Edit
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td title="{{ $order->key->description }}">{{ $order->key->name }}</td>
                        <td>{{ $order->vehicle->model }} {{ $order->vehicle->year }}</td>
                        <td>{{ $order->technician->last_name }}, {{ $order->technician->first_name }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td class="d-flex justify-content-sm-around align-content-center">
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection