<form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $category->name }}" class="form-control">

<br>

@if($category->image)
<img src="{{ asset('uploads/category/'.$category->image) }}" width="80">
@endif

<input type="file" name="image" class="form-control">

<br>

<select name="status" class="form-control">
    <option value="1" {{ $category->status ? 'selected':'' }}>Active</option>
    <option value="0" {{ !$category->status ? 'selected':'' }}>Inactive</option>
</select>

<br>

<button class="btn btn-primary">Update</button>
</form>