<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}"
           class="form-control @error('title') is-invalid @enderror">
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        @foreach(['open' => 'Open', 'completed' => 'Completed'] as $val => $label)
            <option value="{{ $val }}" @selected(old('status', $task->status ?? 'open') === $val)>{{ $label }}</option>
        @endforeach
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Assign Staff</label>
    <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
        <option value="">-- Select staff --</option>
        @foreach($staff as $s)
            <option value="{{ $s->id }}" @selected(old('assigned_to', $task->assigned_to ?? '') == $s->id)>{{ $s->name }}</option>
        @endforeach
    </select>
    @error('assigned_to') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>