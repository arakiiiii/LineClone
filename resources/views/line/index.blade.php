@extends('layouts.line')

<style>
.message{
    width:100px;
}
.comment{
    margin:10px 0px 0px 0px;
}
.balloon {
  width: 100%;
  text-align: left;
}
/*以下、②左側のコメント*/


.says {
  display: inline-block;
  position: relative;
  padding: 10px;
  max-width: 250px;
  border-radius: 12px;
  background: #edf1ee;
}


.says:after {
  content: "";
  display: inline-block;
  position: absolute;
  top: 3px;
  left: -19px;
  border: 8px solid transparent;
  border-right: 18px solid #edf1ee;
  -webkit-transform: rotate(35deg);
  transform: rotate(35deg);
}
.says p {
  margin: 0;
  padding: 0;
}
.mycomment{
    text-align:right;
}
/*以下、③右側の緑コメント*/
.mycomment p {
  display: inline-block;
  position: relative;
  margin: 0 10px 0 0;
  padding: 8px;
  max-width: 250px;
  border-radius: 12px;
  background: #30e852;
  font-size: 15px:
}

.mycomment p:after {
  content: "";
  position: absolute;
  top: 3px;
  right: -19px;
  border: 8px solid transparent;
  border-left: 18px solid #30e852;
  -webkit-transform: rotate(-35deg);
  transform: rotate(-35deg);
}

</style>

@section('content')
<div class='container'>
    <div class="title"><h1>Choose Friend</h1></div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Comment</th>
                <th>message</th>
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
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$friends[$i]->nickname}}" data-whatever="{{$friends[$i]->nickname}}" id="message{{$friends[$i]->nickname}}">Message</button>
                    <div class="modal fade" id="{{$friends[$i]->nickname}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{$friends[$i]->nickname}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="text-center" id="loading{{$friends[$i]->nickname}}">

                            </div>

                            <div id="ulMessages{{$friends[$i]->nickname}}">

                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="text" class="form-control" id="target{{$friends[$i]->nickname}}">
                            <button type="button" class="message btn btn-primary" id="send{{$friends[$i]->nickname}}">送信</button>
                            <script>
                                var a{{$friends[$i]->nickname}} = 0;
                                $(function(){
                                    // Ajax button click
                                    $('#send{{$friends[$i]->nickname}}').on('click',function(){
                                        var val = $('#target{{$friends[$i]->nickname}}').val();
                                        if(val !=null){
                                            $('#target{{$friends[$i]->nickname}}').val("");

                                            $("#ulMessages{{$friends[$i]->nickname}}").append("<div class='mycomment comment'><p>"+val+"</p></div>");

                                            let yourid = {{$friends[$i]->user_id}}
                                            $.ajax({
                                                type: 'POST',
                                                url: "/line/message",
                                                data: {
                                                    message: val,
                                                    yourid: yourid,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(data){
                                                    console.log("send成功");
                                                }
                                            })
                                        }
                                    });

                                    $('#message{{$friends[$i]->nickname}}').on('click',function(){
                                        if(a{{$friends[$i]->nickname}} == 0){
                                            a{{$friends[$i]->nickname}} += 1; //再ロードをさせない

                                            let yourid = {{$friends[$i]->user_id}}

                                            $.ajax({
                                                type: 'POST',
                                                url: "/line/show",
                                                data: {
                                                    yourid: yourid,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                success: function(data){
                                                    $("#load").remove();
                                                        if(data.length == 0){
                                                            $("#ulMessages{{$friends[$i]->nickname}}").append("<p>"+'メッセージはありません'+"</p>");
                                                        }
                                                    for(var i=0; i<data.length; i++){
                                                        if(data[i].myid == {{Auth::user()->id}}){
                                                            $("#ulMessages{{$friends[$i]->nickname}}").append("<div class='mycomment comment'><p>"+data[i].message+"</p></div>");
                                                        } else {
                                                            $("#ulMessages{{$friends[$i]->nickname}}").append("<div class='baloon'><div class='says comment'><p>"+data[i].message+"</p></div></div>")
                                                        }
                                                    }
                                                },
                                                beforeSend: function(){
                                                    $("#loading{{$friends[$i]->nickname}}").append('<div class="spinner-border" role="status" id="load"><span class="sr-only">Loading...</span></div>');
                                                }
                                            })
                                        }
                                    });

                                });
                            </script>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endfor
    </tbody>
</table>
</div>
@endsection
