<div class="table-responsive">
    <table class="table" id="cumulativeAuthorizedUsageRecords-table">
        <thead>
        <tr>
            <th>Authorization Serial Number</th>
        <th>Reports Id</th>
        <th>Reports Num</th>
        <th>Applicant</th>
        <th>Reports Vin</th>
        <th>Quantity</th>
        <th>Authorization Date</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cumulativeAuthorizedUsageRecords as $cumulativeAuthorizedUsageRecords)
            <tr>
                <td>{{ $cumulativeAuthorizedUsageRecords->authorization_serial_number }}</td>
            <td>{{ $cumulativeAuthorizedUsageRecords->reports_id }}</td>
            <td>{{ $cumulativeAuthorizedUsageRecords->reports_num }}</td>
            <td>{{ $cumulativeAuthorizedUsageRecords->applicant }}</td>
            <td>{{ $cumulativeAuthorizedUsageRecords->reports_vin }}</td>
            <td>{{ $cumulativeAuthorizedUsageRecords->quantity }}</td>
            <td>{{ $cumulativeAuthorizedUsageRecords->authorization_date }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.cumulativeAuthorizedUsageRecords.destroy', $cumulativeAuthorizedUsageRecords->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.cumulativeAuthorizedUsageRecords.show', [$cumulativeAuthorizedUsageRecords->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.cumulativeAuthorizedUsageRecords.edit', [$cumulativeAuthorizedUsageRecords->id]) }}"
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
