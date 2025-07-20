@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Pickups</h5>
      {{-- <a href="{{ route('pickups.create') }}" class="btn btn-primary"> --}}
        {{-- <i class="ti ti-plus me-1"></i> Add New Pickup --}}
      {{-- </a> --}}
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Pickup ID</th>
            <th>Pickup Date</th>
            <th>Pickup Location</th>
            <th>Drop Location</th>
            <th>Vehicle Size</th>
            <th>Email</th>
            <th>Contact</th>
            <th>status</th>
            <th>Price</th>
            <th>Advance Payment Status</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody class="table-border-bottom-0">
          @forelse ($pickups as $pickup)
          <tr>
            <td>{{ $pickup->pickup_id ?? '-' }}</td>
<td>{{$pickup->pickup_date}}</td>

            <td>{{ $pickup->pickup_location ?? '-' }}</td>
            <td>{{ $pickup->drop_location ?? '-' }}</td>
            <td>{{ $pickup->size_of_vehicle ?? '-' }}</td>
            <td>{{ $pickup->email ?? '-' }}</td>
            <td>{{ $pickup->contact ?? '-' }}</td>
            <td>{{ $pickup->status ?? '-' }}</td>
            <td>{{ $pickup->price ?? '-' }}</td>
            <td>{{ $pickup->advance_paid ?? '-' }}</td>

         
       

<td>{{ $pickup->created_at->format('d-m-Y h:i A') }}</td>


            <td>
              <a href="{{ route('pickups.edit', $pickup->id) }}">
                <button class="btn btn-warning"><i class="ti ti-edit me-2"></i></button>
              </a>

              <form method="POST" action="{{ route('pickups.destroy', $pickup->id) }}" 
                onsubmit="return confirm('Are you sure you want to delete this pickup?');" 
                style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">
                  <i class="ti ti-trash me-2"></i>
                </button>
              </form>

                            <a href="{{ route('pickups.sendemail', $pickup) }}">
                <button class="btn btn-warning"><i class="ti ti-mail
me-2"></i></button>
              </a>
            </td>
          </tr>

          @empty
          <tr>
            <td colspan="9" class="text-center">No pickups found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@push('scripts')

@endpush
