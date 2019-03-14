@extends('layouts.app')

@section('content')
    <div class="m-b-md">
        <h3 class="m-b-none">Filter 1</h3>
    </div>
    
    <form class="col-lg-12" action="{{ route('filter') }}" method="get" id="app">
        
        <div class="col-lg-3">
            <div class="form-group">
                <label for="sel1">Name:</label>
                <input type="text" name="name" value="{{ request()->get('name') }}" class="form-control" id="sel1">
            </div>
        </div>
        
        <div class="col-lg-3">
            <div class="form-group">
                <label for="sel1">From:</label>
                <datetime-component input-class="form-control" value="{{ request()->get('from') }}" type="date"
                                    name="from" id="sel1">{{ request()->get('from') }}</datetime-component>
            </div>
        </div>
        
        <div class="col-lg-3">
            <div class="form-group">
                <label for="sel1">Till:</label>
                <datetime-component input-class="form-control" value="{{ request()->get('till') }}" type="date"
                                    name="till" id="sel1">{{ request()->get('till') }}</datetime-component>
            </div>
        </div>
        
        <div class="col-lg-3" style="padding-top: 20px;">
            <button type="submit" class="btn btn-success">Filter</button>
        </div>
    
    </form>
    
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Company</th>
            <th>Employee</th>
            <th>Begin</th>
            <th>End</th>
        </tr>
        </thead>
        <tbody>
        
        @foreach($model_employee as $employee)
            <tr>
                <td>{{ $employee->company->name }}</td>
                <td>{{ $employee->fname }} {{ $employee->lname }}</td>
                <td>{{ $employee->workhours->getOriginal('start') }}</td>
                <td>{{ $employee->workhours->getOriginal('end') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
    {{ $model_employee->render() }}
@endsection
