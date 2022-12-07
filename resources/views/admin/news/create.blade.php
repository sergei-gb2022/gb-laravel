@extends('layouts.app')

@section('title', $news->id ? __('Modify the news item') : __('Add a new news item'))

@section('menu')
    @include('admin.menu')
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if ($news->id)
                            {{ __('Modify the news item #') . $news->id }}
                        @else
                            {{ __('Add a new news item') }}
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="@if (!$news->id) {{ route('admin.news.create') }}@else{{ route('admin.news.update', $news) }} @endif"
                            method="post">
                            @csrf
                            <div class="form-group">
                                <label for="newsTitle">Title</label>
                                <input type="text" name="title" id="newsTitle" class="form-control"
                                    value="{{ $news->title ?? old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="newsCategory">News category</label>
                                <select name="category_id" id="newsCategory" class="form-control">
                                    @forelse($categories as $item)
                                        <option @if ($item->id == ($news->category_id ?? old('category'))) selected @endif
                                            value="{{ $item->id }}">{{ $item->title }}</option>
                                    @empty
                                        <option value="0" selected>- no categories -</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="newsText">Text</label>
                                <textarea name="text" id="newsText" class="form-control">{{ $news->text ?? old('text') }}</textarea>
                            </div>

                            <div class="form-check">
                                <input @if ($news->isPrivate == 1 || old('isPrivate') == 1) checked @endif id="newsPrivate" name="isPrivate"
                                    type="checkbox" value="1" class="form-check-input">
                                <label for="newsPrivate">Is private?</label>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-outline-primary"
                                    value="@if ($news->id) Update @else Add @endif">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
