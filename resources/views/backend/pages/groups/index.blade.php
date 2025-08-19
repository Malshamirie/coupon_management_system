@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.groups') }}
@endsection
@section('title')
  {{ __('back.groups') }}
@endsection
@section('content')
  <div class="row mb-2" id="table-bordered">
    @can('add_group')
      <div class="col-md-9">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_group">
          <i class="fas fa-plus"></i>
          {{ __('back.add_group') }}
        </button>
        @include('backend.pages.groups.add')
      </div>
    @endcan

    @can('groups')
      <div class="col-md-3 mb-1 ">
        <form action="{{ route('admin.groups.index') }}" method="GET" role="search">
          <div class="input-group">
            <input type="text" class="form-control " name="query" value="{{ old('query', request()->input('query')) }}"
              placeholder="{{ trans('back.search') }}">
            <button class="btn btn-purple ml-1" type="submit" title="Search">
              <span class="fas fa-search"></span>
            </button>
            <a href="{{ route('admin.groups.index') }}" class="btn btn-success ml-1" title="Reload">
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
                  <th>{{ __('back.group_name') }}</th>
                  <th>{{ __('back.Created_at') }}</th>
                  <th>{{ __('back.actions') }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($groups as $group)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->created_at }}</td>
                    <td>
                      @can('edit_group')
                        <a href="" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#edit_group{{ $group->id }}">
                          {{ trans('back.edit') }}
                        </a>
                      @endcan

                      @can('delete_group')
                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#delete_group{{ $group->id }}">
                          {{ trans('back.Delete') }}
                        </a>
                      @endcan
                    </td>
                  </tr>
                  @include('backend.pages.groups.edit')
                  @include('backend.pages.groups.delete')
                @endforeach
              </tbody>
            </table>
            {!! $groups->appends(Request::all())->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
