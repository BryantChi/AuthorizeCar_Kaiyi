<div class="table-responsive">
    <table class="table" id="exportAuthorizeRecords-table">
        <thead>
        <tr>
            <th>Reports Ids</th>
        <th>Export Authorize Num</th>
        <th>Export Authorize Com</th>
        <th>Export Authorize Brand</th>
        <th>Export Authorize Model</th>
        <th>Export Authorize Vin</th>
        <th>Export Authorize Auth Num Id</th>
        <th>Export Authorize Reports Nums</th>
        <th>Export Authorize Path</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($exportAuthorizeRecords as $exportAuthorizeRecords)
            <tr>
                <td>{{ $exportAuthorizeRecords->reports_ids }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_num }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_com }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_brand }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_model }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_vin }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_auth_num_id }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_reports_nums }}</td>
            <td>{{ $exportAuthorizeRecords->export_authorize_path }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.exportAuthorizeRecords.destroy', $exportAuthorizeRecords->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.exportAuthorizeRecords.show', [$exportAuthorizeRecords->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.exportAuthorizeRecords.edit', [$exportAuthorizeRecords->id]) }}"
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
