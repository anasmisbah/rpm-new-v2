@extends('layouts.post')
@section('description')
<div class="text-left  text-bold" style="font-size: 20px">{{$event->title}}</div>
<hr style="border-top: 1px solid black">
<p style="font-size: 12px"><i class="fa fa-clock"></i>{{" ".$event->created_at->format('d F Y')}}</p>
<img src="{{asset('/uploads/'.$event->image)}}" class="img-fluid mb-3" alt="">
<span style="font-size: 12px">Start Event :{{$event->startdate->format('l, d F Y')}}</span><br>
<span style="font-size: 12px">End Event :{{$event->enddate->format('l, d F Y')}}</span>
<p class="text-justify">{!! $event->description !!}</p>
@endsection
