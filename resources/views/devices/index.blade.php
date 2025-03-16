<!-- resources/views/devices/index.blade.php -->
@extends('layouts.app')

@section('title', 'Devices')

@section('page-actions')
    <a href="{{ route('devices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Device
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Devices</h6>
        </div>
        <div class="card-body">
            @if($devices->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Device ID</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $device)
                                <tr>
                                    <td>{{ $device->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $device->device_id }}</span></td>
                                    <td>{{ $device->location->name }}</td>
                                    <td>
                                        @if($device->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $device->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $device->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $device->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $device->id }}">Delete Device</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete device <strong>{{ $device->name }}</strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('devices.destroy', $device) }}" method="POST">
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
                    {{ $devices->links() }}
                </div>
            @else
                <p class="text-center">No devices found.</p>
            @endif
        </div>
    </div>
@endsection

<!-- resources/views/devices/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Device')

@section('page-actions')
    <a href="{{ route('devices.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Devices
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Device</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('devices.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Device Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location_id" class="form-label">Location</label>
                    <select class="form-select @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('location_id')
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

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : 'checked' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Create Device</button>
            </form>
        </div>
    </div>
@endsection

<!-- resources/views/devices/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Device')

@section('page-actions')
    <a href="{{ route('devices.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Devices
    </a>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Device</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('devices.update', $device) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Device Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $device->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="device_id" class="form-label">Device ID</label>
                    <input type="text" class="form-control" id="device_id" value="{{ $device->device_id }}" readonly disabled>
                    <small class="form-text text-muted">Device ID cannot be changed.</small>
                </div>

                <div class="mb-3">
                    <label for="location_id" class="form-label">Location</label>
                    <select class="form-select @error('location_id') is-invalid @enderror" id="location_id" name="location_id" required>
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $device->location_id) == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $device->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $device->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Device</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">API Key</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="api_key" class="form-label">API Key</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="api_key" value="{{ $device->api_key }}" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="copyApiKey">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                </div>
                <small class="form-text text-muted">This key is required for device authentication.</small>
            </div>
            <form method="POST" action="{{ route('devices.regenerate-api-key', $device) }}" onsubmit="return confirm('Are you sure you want to regenerate the API key? The device will need to be reprogrammed with the new key.');">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-key"></i> Regenerate API Key
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('copyApiKey').addEventListener('click', function() {
        const apiKeyInput = document.getElementById('api_key');
        apiKeyInput.select();
        document.execCommand('copy');

        // Show copied tooltip
        this.innerHTML = '<i class="bi bi-clipboard-check"></i> Copied!';
        setTimeout(() => {
            this.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
        }, 2000);
    });
</script>
@endpush

<!-- resources/views/devices/show.blade.php -->
@extends('layouts.app')

@section('title', $device->name)

@section('page-actions')
    <div>
        <a href="{{ route('devices.edit', $device) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('devices.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Devices
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Device Details</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $device->name }}</td>
                        </tr>
                        <tr>
                            <th>Device ID:</th>
                            <td><span class="badge bg-secondary">{{ $device->device_id }}</span></td>
                        </tr>
                        <tr>
                            <th>Location:</th>
                            <td>
                                <a href="{{ route('locations.show', $device->location) }}">
                                    {{ $device->location->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($device->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $device->description ?? 'No description' }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $device->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $device->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Location Information</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $device->location->name }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $device->location->address }}</td>
                        </tr>
                        <tr>
                            <th>Contact Person:</th>
                            <td>{{ $device->location->contact_person ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Contact Phone:</th>
                            <td>{{ $device->location->contact_phone ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Alerts</h6>
                <a href="{{ route('dashboard.alerts', ['device_id' => $device->id]) }}" class="btn btn-sm btn-primary">View All Alerts</a>
            </div>
        </div>
        <div class="card-body">
            @if($device->alerts->count() > 0)
                @foreach($device->alerts as $alert)
                    @include('layouts.components.alert-card', ['alert' => $alert])
                @endforeach
            @else
                <p class="text-center">No alerts found for this device.</p>
            @endif
        </div>
    </div>
@endsection
