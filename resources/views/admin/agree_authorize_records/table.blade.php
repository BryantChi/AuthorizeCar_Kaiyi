<div class="table-responsive">
    <table class="table" id="agreeAuthorizeRecords-table">
        <thead>
        <tr>
            <th>Reports Id</th>
        <th>Reports Num</th>
        <th>Authorize Date</th>
        <th>Authorize Year</th>
        <th>Car Brand Id</th>
        <th>Car Model Id</th>
        <th>Reports Vin</th>
        <th>Reports Regulations</th>
        <th>Licensee</th>
        <th>Invoice Title</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($agreeAuthorizeRecords as $agreeAuthorizeRecords)
            <tr>
                <td>{{ $agreeAuthorizeRecords->reports_id }}</td>
            <td>{{ $agreeAuthorizeRecords->reports_num }}</td>
            <td>{{ $agreeAuthorizeRecords->authorize_date }}</td>
            <td>{{ $agreeAuthorizeRecords->authorize_year }}</td>
            <td>{{ $agreeAuthorizeRecords->car_brand_id }}</td>
            <td>{{ $agreeAuthorizeRecords->car_model_id }}</td>
            <td>{{ $agreeAuthorizeRecords->reports_vin }}</td>
            <td>{{ $agreeAuthorizeRecords->reports_regulations }}</td>
            <td>{{ $agreeAuthorizeRecords->licensee }}</td>
            <td>{{ $agreeAuthorizeRecords->Invoice_title }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.agreeAuthorizeRecords.destroy', $agreeAuthorizeRecords->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.agreeAuthorizeRecords.show', [$agreeAuthorizeRecords->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.agreeAuthorizeRecords.edit', [$agreeAuthorizeRecords->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
