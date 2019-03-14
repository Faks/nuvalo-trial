@extends('layouts.app')

@section('content')
    <div class="m-b-md">
        <h3 class="m-b-none">Filter 3</h3>
    </div>
    
    <form class="col-lg-12" action="{{ route('filter3') }}" method="get">
        
        <div class="col-lg-3">
            
            <div class="form-group">
                <label for="sel1">Filter list:</label>
                <select name="filter" class="form-control" id="sel1">
                    <option value="desc" @if (request()->get('filter') == 'desc') selected @endif>DESC</option>
                    <option value="asc" @if (request()->get('filter') == 'asc') selected @endif>ASC</option>
                </select>
            </div>
        
        </div>
        
        <div class="col-lg-3" style="padding-top: 20px;">
            <button type="submit" class="btn btn-success">Filter</button>
        </div>
    
    </form>
    
    {{--Issues with mutators--}}
    {{--<div id="app">--}}
    {{--<filter3-component></filter3-component>--}}
    {{--</div>--}}
    
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Company</th>
            <th>Employee</th>
            <th>Begin</th>
            <th>End</th>
            <th>Total Hours</th>
        </tr>
        </thead>
        <tbody>
        
        @foreach($model_employee_work_hours as $work_hours)
            <tr>
                <td>{{ $work_hours->employee->company->name }}</td>
                <td>{{ $work_hours->employee->fname }} {{ $work_hours->employee->lname }}</td>
                <td>{{ $work_hours->start }}</td>
                <td>{{ $work_hours->end }}</td>
                <td>{{ $work_hours->total_hours }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
    {{ $model_employee_work_hours->appends(Request::except('page'))->links() }}

@endsection