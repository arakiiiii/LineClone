@extends('layouts.line')

@section('content')
<div class="container">
    <h1 class="title">MyPage</h1>
    <h1 class="sub-title">EditMyData</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/line/edit" method="post">
        {{ csrf_field() }}
            <table class="table">
            <input type="hidden" name="user_id" value="{{$myInfoData->user_id}}">
                <tr>
                    <th>Name</th>
                    <th><input type="text" class="form-control" name="name" value="{{$myData->name}}"></th>
                </tr>
                <tr>
                    <th>Email</th>
                    <th><input type="text" class="form-control" name="email" value="{{$myData->email}}"></th>
                </tr>
                <tr>
                    <th>Nickname</th>
                    <th><input type="text" class="form-control" name="nickname" value="{{$myInfoData->nickname}}"></th>
                </tr>
                <tr>
                    <th>Comment</th>
                    <th><textarea class="form-control" name="comment" low="3">{{$myInfoData->comment}}</textarea></th>
                </tr>
            </table>
        <button type="submit" class="btn btn-primary btn-block">変更する</button>
    </form>
    <h1 class="sub-title">MyFriends</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            @for($i=0; $i<count($friends); $i++)
                <tr>
                    <td>
                        {{$friends[$i]->nickname}}
                    </td>
                    <td>
                        @if($friends[$i]->comment == null)
                        <small class="text-muted">コメントがありません</small>
                        @else
                        {{$friends[$i]->comment}}
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
@endsection