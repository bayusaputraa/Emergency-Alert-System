<!-- resources/views/locations/index.blade.php -->
@extends('layouts.app')

@section('title', 'Locations')

@section('page-actions')
    <a href="{{ route('locations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Location
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Locations</h6>
        </div>
        <div class="card-body">
            @if($locations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Devices</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->address }}</td>
                                    <td>{{ $location->devices_count }}</td>
                                    <td>{{ $location->contact_person ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $location->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $location->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $location->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $location->id }}">Delete Location</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete location <strong>{{ $location->name }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('locations.destroy', $location) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $locations->links() }}
                </div>
            @else
                <p class="text-center">No locations found.</p>
            @endif
        </div>
    </div>
@endsection

<!-- resources/views/locations/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Location')

@section('page-actions')
    <a href="{{ route('locations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Locations
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Location</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('locations.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Location Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_person" class="form-label">Contact Person</label>
                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
                    @error('contact_person')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_phone" class="form-label">Contact Phone</label>
                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                    @error('contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Location</button>
            </form>
        </div>
    </div>
@endsection

<!-- resources/views/locations/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Location')

@section('page-actions')
    <a href="{{ route('locations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Locations
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Location</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('locations.update', $location) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Location Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $location->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address', $location->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $location->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_person" class="form-label">Contact Person</label>
                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" value="{{ old('contact_person', $location->contact_person) }}">
                    @error('contact_person')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_phone" class="form-label">Contact Phone</label>
                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $location->contact_phone) }}">
                    @error('contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Location</button>
            </form>
        </div>
    </div>
@endsection

<!-- resources/views/locations/show.blade.php -->
@extends('layouts.app')

@section('title', $location->name)

@section('page-actions')
    <div>
        <a href="{{ route('locations.edit', $location) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Locations
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Location Details</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $location->name }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $location->address }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $location->description ?? 'No description' }}</td>
                        </tr>
                        <tr>
                            <th>Contact Person:</th>
                            <td>{{ $location->contact_person ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Contact Phone:</th>
                            <td>{{ $location->contact_phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Total Devices:</th>
                            <td>{{ $location->devices->count() }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $location->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $location->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Devices at this Location</h6>
                        <a href="{{ route('devices.create') }}" class="btn btn-sm btn-primary">Add Device</a>
                    </div>
                </div>
                <div class="card-body">
                    @if($location->devices->count() > 0)
                        <ul class="list-group">
                            @foreach($location->devices as $device)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('devices.show', $device) }}">{{ $device->name }}</a>
                                        <span class="badge bg-secondary ms-2">{{ $device->device_id }}</span>
                                        @if(!$device->is_active)
                                            <span class="badge bg-danger ms-2">Inactive</span>
                                        @endif
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $device->alerts_count ?? 0 }} alerts</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">No devices registered at this location.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Alerts at this Location</h6>
                <a href="{{ route('dashboard.alerts', ['location_id' => $location->id]) }}" class="btn btn-sm btn-primary">View All Alerts</a>
            </div>
        </div>
        <div class="card-body">
            @if($recentAlerts->count() > 0)
                @foreach($recentAlerts as $alert)
                    @include('layouts.components.alert-card', ['alert' => $alert])
                @endforeach
            @else
                <p class="text-center">No recent alerts for this location.</p>
            @endif
        </div>
    </div>
@endsection
