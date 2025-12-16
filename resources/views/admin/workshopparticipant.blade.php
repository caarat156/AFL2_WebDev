@extends('layout.mainlayout')

@section('title', 'Workshop Participants')

@section('content')
<div class="container my-5">
    
    {{-- Back Button & Workshop Info --}}
    <div class="mb-4">
        <a href="{{ route('admin.workshops') }}" class="btn btn-outline-secondary mb-3">
            ← Back to Workshops
        </a>
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="mb-3">{{ $workshop->title }}</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Date:</strong> 
                            {{ \Carbon\Carbon::parse($workshop->date)->format('d M Y') }}
                        </p>
                        <p class="mb-2">
                            <strong>Time:</strong> 
                            {{ \Carbon\Carbon::parse($workshop->time)->format('H:i') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Location:</strong> 
                            {{ $workshop->location }}
                        </p>
                        <p class="mb-2">
                            <strong>Capacity:</strong> 
                            {{ $workshop->capacity }} people
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Participants List --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Registered Participants 
                <span class="badge bg-light text-dark">{{ $participants->count() }}</span>
            </h4>
        </div>
        <div class="card-body">
            @if($participants->isEmpty())
                <p class="text-center text-muted py-5">
                    No participants registered yet.
                </p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Participants</th>
                                <th>Registration Date</th>
                                <th>Payment Status</th>
                                <th>Special Requirements</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $index => $participant)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $participant->full_name }}</td>
                                    <td>{{ $participant->email }}</td>
                                    <td>{{ $participant->phone }}</td>
                                    <td>{{ $participant->address }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $participant->participant_count }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($participant->registration_date)->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if($participant->payment_status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($participant->payment_status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $participant->special_requirements ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection