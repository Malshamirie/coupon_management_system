@extends('backend.layouts.master')

@section('page_title')
    {{ __('back.loyalty_containers') }}
@endsection

@section('title')
    {{ __('back.loyalty_containers') }}
@endsection

@section('content')
    <div class="row mb-2" id="table-bordered">
        <div class="col-md-9">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_loyalty_container">
                <i class="fas fa-plus"></i>
                {{ __('back.add_loyalty_container') }}
            </button>
        </div>

        <div class="col-md-3 mb-1">
            <form action="{{ route('admin.loyalty_containers.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" name="query" value="{{ old('query', request()->input('query')) }}"
                        placeholder="{{ trans('back.search') }}">
                    <button class="btn btn-purple ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('admin.loyalty_containers.index') }}" class="btn btn-success ml-1" title="Reload">
                        <span class="fas fa-sync-alt"></span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>{{ trans('back.name') }}</th>
                                    <th>{{ trans('back.description') }}</th>
                                    <th>{{ trans('back.campaigns_count') }}</th>
                                    <th>{{ trans('back.customers_count') }}</th>
                                    {{-- <th>{{ trans('back.status') }}</th> --}}
                                    <th>{{ trans('back.Created_at') }}</th>
                                    <th>{{ trans('back.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($containers as $container)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $container->name }}</td>
                                        <td>{{ $container->description ?? '--' }}</td>
                                        <td>
                                            <a href="{{ route('admin.loyalty_containers.campaigns', $container->id) }}" 
                                               class="btn btn-info btn-xs">
                                                {{ $container->campaigns_count }}
                                            </a>
                                        </td>
                                        <td>{{ $container->customers_count }}</td>
                                        {{-- <td>
                                            <span class="badge bg-{{ $container->is_active ? 'success' : 'danger' }}">
                                                {{ $container->is_active ? trans('back.active') : trans('back.inactive') }}
                                            </span>
                                        </td> --}}
                                        <td>{{ $container->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal"
                                                data-bs-target="#edit_loyalty_container{{ $container->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal"
                                                data-bs-target="#delete_loyalty_container{{ $container->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                           
                                        </td>
                                    </tr>

                                    <!-- Modal تعديل -->
                                    @include('backend.pages.loyalty_containers.edit', ['container' => $container])

                                    <!-- Modal حذف -->
                                    @include('backend.pages.loyalty_containers.delete', ['container' => $container])
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $containers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.pages.loyalty_containers.add')
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // تبديل حالة الحاوية
    $('.toggle-status').click(function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        
        $.ajax({
            url: '/admin/loyalty-containers/' + id + '/toggle-status',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toast(response.message, 'success');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function() {
                toast('حدث خطأ أثناء تحديث الحالة', 'error');
            }
        });
    });
});
</script>
@endpush
