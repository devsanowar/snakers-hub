@extends('admin.layouts.app')
@section('title', 'Category')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />
@endpush

@section('admin_content')
    <div class="container-fluid">
        <!-- Horizontal Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-uppercase"> All Categories
                            <span>
                                <a href="{{ route('category.create') }}" class="btn btn-primary right">Add Category</a>
                            </span>
                        </h4>
                    </div>


                    <div class="body table-responsive">
                        <table class="table table-bpositioned">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all" class="custom-design">
                                    </th>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">

                                @forelse ($categories as $key => $category)
                                    <tr id="row-{{ $category->id }}" data-id="{{ $category->id }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input custom-design row-checkbox"
                                                value="{{ $category->id }}">
                                        </td>
                                        {{-- <td ><i class="zmdi zmdi-select-all"></i> {{ $key+1 }} </td> --}}
                                        <td scope="row">{{ $key + 1 }}</td>
                                        <td><img src="{{ asset($category->image) }}" alt="category image" width="40">
                                        </td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>
                                            <button data-id="{{ $category->id }}"
                                                class="btn btn-sm status-toggle-btn {{ $category->is_active ? 'btn-success' : 'btn-danger' }}">
                                                {{ $category->is_active ? 'Active' : 'DeActive' }}
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ route('category.edit', $category->id) }}"
                                                class="btn btn-warning"><i class="material-icons text-white">edit</i></a>

                                            <form class="d-inline-block"
                                                action="{{ route('category.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-raised bg-pink waves-effect show_confirm">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Category Not Found! :) Please Add Category. Thank you</td>
                                    </tr>
                                @endforelse

                                <tr>
                                    <button id="bulk-delete" class="btn btn-danger mb-3">Delete Selected</button>
                                </tr>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- #END# Horizontal Layout -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });
        });
    </script>


<script>
    $(document).ready(function () {
        $("#sortable-list").sortable({
            placeholder: "ui-state-highlight",
            axis: "y",
            update: function (event, ui) {
                var position = [];

                $("#sortable-list tr").each(function () {
                    position.push($(this).data('id')); // ✅ এখন এটি <tr data-id="..."> থেকে আইডি নিচ্ছে
                });

                console.log(position); // Debug: দেখুন array তৈরি হচ্ছে কিনা

                $.ajax({
                    url: "{{ route('category.updateOrder') }}",
                    type: "POST",
                    data: {
                        position: position,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        toastr.error(response.message || 'Something went wrong.');
                    }
                });
            }
        });
    });
</script>


    <script>
        $('#bulk-delete').on('click', function() {
            const selectedIds = [];
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                toastr.error('Please select at least one category.');
                return;
            }

            if (confirm('Are you sure you want to delete selected categories?')) {
                $.ajax({
                    url: "{{ route('category.bulkDelete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);

                            // Remove deleted rows from DOM
                            selectedIds.forEach(function(id) {
                                $('#row-' + id).remove();
                            });
                        } else {
                            toastr.error(response.message || 'Something went wrong.');
                        }
                    }
                });
            }
        });
    </script>


    <script>
        const categoryStatusRoute = "{{ route('category.status') }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('backend') }}/assets/js/category.js"></script>
@endpush
