@extends('layouts.line')

<style>
 .padding {
     padding-bottom: :10px;
 }
</style>

@section('content')

<div class="container">
<h1 class="title">Users</h1>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Comment</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @for($i=0; $i<count($users); $i++)
        @if($users[$i]->id != Auth::user()->id)
            <tr>
                <td>
                    {{$usersInfo[$i]->nickname}}
                </td>
                <td>
                    @if($usersInfo[$i]->comment == null)
                    <small class="text-muted">コメントがありません</small>
                    @else
                    {{$usersInfo[$i]->comment}}
                    @endif
                </td>
                <td>
                    <button type="button" id="{{$users[$i]->id}}" value="{{$users[$i]->id}}" class="FollowBtn btn btn-primary">追加</button>

                @foreach($friends as $friend)
                @if($friend->yourid == $users[$i]->id)
                <script>
                    document.getElementById("{{$users[$i]->id}}").textContent = "解除";
                    document.getElementById("{{$users[$i]->id}}").className = "FollowBtn btn btn-danger";
                </script>
                @endif
                @endforeach
                    <script>
                        $(function(){
                            // Ajax button click
                            $('#{{$users[$i]->id}}').on('click',function(){
                                var val = $(this).val();
                                $.ajax({
                                    type: 'POST',
                                    url: "/line/befriend",
                                    data: {
                                        date:val,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(data){
                                        document.getElementById("{{$users[$i]->id}}").textContent = data;
                                        if(data == "解除"){
                                            document.getElementById("{{$users[$i]->id}}").className = "FollowBtn btn btn-danger";
                                        } else {
                                            document.getElementById("{{$users[$i]->id}}").className = "FollowBtn btn btn-primary";
                                        }
                                    },
                                    beforeSend: function(){
                                            document.getElementById("{{$users[$i]->id}}").innerHTML = '<span class=" spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>'
                                    }
                                })
                            });
                        });
                    </script>
                </td>
            </tr>
        @endif
    @endfor
    </tbody>
</table>


</div>
@endsection