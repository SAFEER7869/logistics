@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">

<form method="POST" action="{{ route('pickups.update', $pickup) }}" class="card-body">

      @csrf




      <!-- status -->
 <label for="price" class="form-label">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="">-- Select Status --</option>
        <option value="pending" {{ old('status', $pickup->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="in_progress" {{ old('status', $pickup->status ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="completed" {{ old('status', $pickup->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ old('status', $pickup->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>

    @error('status')
    <div class="text-danger">{{ $message }}</div>
    @enderror

      <!-- adance status -->
 <label for="price" class="form-label mt-4">Advance payment status</label>
    <select name="advance_paid" id="advance_paid" class="form-control">
        <option value="">-- Select advance status paid --</option>
        <option value="Paid" {{ old('advance_paid', $pickup->advance_paid ?? '') == 'Paid' ? 'selected' : '' }}>Paid</option>
        <option value="Unpaid" {{ old('advance_paid', $pickup->advance_paid ?? '') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
      
    </select>

    @error('status')
    <div class="text-danger">{{ $message }}</div>
    @enderror

     <!-- Price -->
      <div class="mt-4">
        <label for="price" class="form-label">Price</label>
        <input type="number" id="price" name="price"  value="{{ old('price', $pickup->price ?? '') }}" class="form-control" autocomplete="tel" />
        @error('price')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>



      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('pickups.index') }}" class="btn btn-secondary">Cancel</a>
      </div>

    </form>
  </div>
</div>
@endsection
