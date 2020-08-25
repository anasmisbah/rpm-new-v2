
@extends('layouts.post')
@section('description')
<p class="text-left  text-bold" style="font-size: 20px">{{$news->title}}</p>
<hr style="border-top: 1px solid black">
<p style="font-size: 12px"><i class="fa fa-clock"></i>{{" ".$news->created_at->format('d F Y')}}</p>
<img src="{{asset('/uploads/'.$news->image)}}" class="img-fluid" alt="">
<p class="text-justify">{!! $news->description !!}</p>
@endsection
