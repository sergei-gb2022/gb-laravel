@extends('layouts.app')

@section('title', $category->id ? __('Modify the category') : __('Add a new category'))

@section('menu')
    @include('admin.menu')
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if ($category->id)
                            {{ __('Modify the category #') . $category->id }}
                        @else
                            {{ __('Add a new category') }}
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="@if (!$category->id) {{ route('admin.categories.create') }}@else{{ route('admin.categories.update', $category) }} @endif"
                            method="post">
                            @csrf
                            <div class="form-group">
                                <label for="newsTitle">Title</label>
                                <input type="text" name="title" id="newsTitle" class="form-control"
                                    value="{{ $category->title ?? old('title') }}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-outline-primary"
                                    value="@if ($category->id) Update @else Add @endif">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
