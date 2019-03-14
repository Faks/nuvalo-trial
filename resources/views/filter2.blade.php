@extends('layouts.app')

@section('content')
    <div class="m-b-md">
        <h3 class="m-b-none">Filter 2</h3>
    </div>
    
    <div id="app">
        <filter2-component></filter2-component>
    </div>
    
    {{-- Basic Version Code--}}
    {{--<table class="table table-hover">--}}
    {{--<thead>--}}
    {{--<tr>--}}
    {{--<th>Month / Year</th>--}}
    {{--<th>Hours Worked</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{----}}
    {{--@foreach($each_month_total_hours as $each_month => $each_month_hours )--}}
    {{--<tr>--}}
    {{--<td>{{ $each_month }}</td>--}}
    {{--<td>{{ $each_month_hours }}</td>--}}
    {{--</tr>--}}
    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}
@endsection
