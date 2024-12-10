<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Gallery Item</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @include('admin.include.head')
</head>
<body> 
  @include('admin.include.header')       
  @include('admin.include.sidebar')

  <div class="pcoded-content">
    <div class="container">
      <div class="content-head4">
        <h4 class="sub-content-head4" style="font-weight: 900;">Edit Gallery Item</h4>
      </div>
    </div>
    <div class="main-body">
      <div class="page-wrapper">
        <div class="same shop-product-upload-form">
          <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image">
              @if($gallery->image)
                <div class="mt-2">
                  <img src="{{ asset('public/asset/img/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="100">
                  <p>Current Image</p>
                </div>
              @endif
            </div>
            <button type="submit" class="btn btn-primary">Update Gallery Item</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @include('admin.include.script')

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      @if (session('success'))
        Swal.fire({
          text: '{{ session('success') }}',
          icon: 'success',
          title: 'Success',
          timer: 2000,
          showConfirmButton: false
        });
      @endif
    });
  </script>
</body>
</html>
