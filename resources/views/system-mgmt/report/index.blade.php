@extends('system-mgmt.report.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-4">
          <h3 class="box-title">List of hired employees</h3>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                {{-- <input type="hidden" value="{{$searchingVals['department_id']}}" name="department_id" />
                <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" /> --}}
                <button type="submit" class="btn btn-primary">
                  Export to Excel
                </button>
            </form>
        </div>
        <div class="col-sm-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('report.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                {{-- <input type="hidden" value="{{$searchingVals['department_id']}}" name="department_id" />
                <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" /> --}}
                <button type="submit" class="btn btn-info">
                  Export to PDF
                </button>
            </form>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('report.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-date-search-row', ['items' => ['From', 'To'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['from'] : '', isset($searchingVals) ? $searchingVals['to'] : '']])
          @endcomponent
         @endcomponent
      </form>
      <form method="POST" action="{{ route('report.search.department') }}">
       {{ csrf_field() }}
        <h3>Search by Department</h3>
        <div class="row">
           @component('layouts.two-cols-date-search-row', ['items' => ['From', 'To'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['from'] : '', isset($searchingVals) ? $searchingVals['to'] : '']])
          @endcomponent
        </div>
         <div class="row">
          <div class="col">
              <div class="form-group">
                <label class="col-md-1 control-label">Department</label>
                <div class="col-md-6">
                    <select class="form-control js-states" name="department_id">
                        <option value="-1">Please select department</option>
                         @foreach ($departments as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach 
                    </select>
                </div>
              </div>
          </div>
          <div class="col"><button class="btn btn-primary" type="submit">Search</button></div>
         </div>
        <br>
      </form>
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('report.excel.department') }}">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                  <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                  <input type="hidden" value="{{$searchingVals['department_id']}}" name="department_id"/>
            
                  <button type="submit" class="btn btn-primary">Export to Excel</button>
              </form>
          </div>
          <div class="col-sm-4">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('report.pdf.department') }}">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                  <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                  {{-- <input type="hidden" value="{{$searchingVals['department_id']}}" name="department_id" />
                  <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" /> --}}
                  <button type="submit" class="btn btn-info">
                    Export to PDF
                  </button>
              </form>
          </div>
      </div>
       <form method="POST" action="{{ route('report.search.country') }}">
        {{ csrf_field() }}
        <h3>Search by Country</h3>
          <div class="row">
           @component('layouts.two-cols-date-search-row', ['items' => ['From', 'To'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['from'] : '', isset($searchingVals) ? $searchingVals['to'] : '']])
          @endcomponent
        </div>
         <div class="row">
          <div class="col">
              <div class="form-group">
                <label class="col-md-1 control-label">Country</label>
                <div class="col-md-6">
                    <select class="form-control js-states" name="country_id" required>
                        <option value="-1">Please select country</option>
                         @foreach ($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach 
                    </select>
                </div>
              </div>
          </div>
          <div class="col"><button class="btn btn-primary" type="submit">Search</button></div>
         </div>
        <br>
      </form>
      <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('report.excel.country') }}">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                  <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                  <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" />
                  {{-- <input type="hidden" value="{{$searchingVals['department_id']}}" name="department_id" />
                  <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" /> --}}
                  <button type="submit" class="btn btn-primary">
                    Export to Excel
                  </button>
              </form>
          </div>
          <div class="col-sm-4">
              <form class="form-horizontal" role="form" method="POST" action="{{ route('report.pdf.country') }}">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                  <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                  <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" />
                  {{-- <input type="hidden" value="{{$searchingVals['department_id']}}" name="department_id" />
                  <input type="hidden" value="{{$searchingVals['country_id']}}" name="country_id" /> --}}
                  <button type="submit" class="btn btn-info">
                    Export to PDF
                  </button>
              </form>
          </div>
      </div>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Employee Name</th>
                <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Birthday</th>
                <th width = "40%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Hired Day</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
                <tr role="row" class="odd">
                  <td>{{ $employee->firstname }} {{ $employee->middlename }} {{ $employee->lastname }}</td>
                  <td>{{ $employee->birthdate }}</td>
                  <td>{{ $employee->address }}</td>
                  <td>{{ $employee->date_hired }}</td>
              </tr>
            @endforeach
            </tbody>
            <tfoot>
              <tr role="row">
                  <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Employee Name</th>
                  <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Birthday</th>
                  <th width = "40%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                  <th width = "20%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Hired Day</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($employees)}} of {{count($employees)}} entries</div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection