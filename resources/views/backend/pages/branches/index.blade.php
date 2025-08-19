@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.branches') }}
@endsection
@section('title')
  {{ __('back.branches') }}
@endsection
@section('content')
  <div class="row mb-2" id="table-bordered">
    @can('add_branch')
      <div class="col-md-9">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_branch">
          <i class="fas fa-plus"></i>
          {{ __('back.add_branch') }}
        </button>
        @include('backend.pages.branches.add')
      </div>
    @endcan

    @can('branches')
      <div class="col-md-3 mb-1 ">
        <form action="{{ route('admin.branches.index') }}" method="GET" role="search">
          <div class="input-group">
            <input type="text" class="form-control " name="query" value="{{ old('query', request()->input('query')) }}"
              placeholder="{{ trans('back.search') }}">
            <button class="btn btn-purple ml-1" type="submit" title="Search">
              <span class="fas fa-search"></span>
            </button>
            <a href="{{ route('admin.branches.index') }}" class="btn btn-success ml-1" title="Reload">
              <span class="fas fa-sync-alt"></span>
            </a>
          </div>
        </form>
      </div>
    @endcan
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
                  <th>{{ __('back.branch_number') }}</th>
                  <th>{{ __('back.branch_name') }}</th>
                  <th>{{ __('back.contact_number') }}</th>
                  <th>{{ __('back.city') }}</th>
                  <th>{{ __('back.area') }}</th>
                  <th>{{ __('back.group') }}</th>
                  <th>{{ __('back.Created_at') }}</th>
                  <th>{{ __('back.actions') }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($branches as $branch)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $branch->branch_number }}</td>
                    <td>{{ $branch->branch_name }}</td>
                    <td>{{ $branch->contact_number }}</td>
                    <td>{{ $branch->city->name ?? '' }}</td>
                    <td>{{ $branch->area }}</td>
                    <td>{{ $branch->group->name ?? '' }}</td>
                    <td>{{ $branch->created_at }}</td>
                    <td>
                      @can('edit_branch')
                        <a href="" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#edit_branch{{ $branch->id }}">
                          {{ trans('back.edit') }}
                        </a>
                      @endcan

                      @can('delete_branch')
                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#delete_branch{{ $branch->id }}">
                          {{ trans('back.Delete') }}
                        </a>
                      @endcan
                    </td>
                  </tr>
                  @include('backend.pages.branches.edit')
                  @include('backend.pages.branches.delete')
                @endforeach
              </tbody>
            </table>
            {!! $branches->appends(Request::all())->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
