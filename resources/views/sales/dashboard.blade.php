@extends('layouts.app3')

@section('title', 'Sales Dashboard')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Dashboard Sales</h2>

        <div class="row text-center">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Total Produk</h5>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Total Customer</h5>
                    <h2>{{ $totalCustomers }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Total Transaksi</h5>
                    <h2>{{ $totalTransactions }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
