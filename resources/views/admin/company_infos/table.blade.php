<div class="table-responsive">
    <table class="table" id="companyInfos-table">
        <thead>
            <tr>
                <th>公司名</th>
                <th>統一編號</th>
                <th>地址</th>
                <th>聯絡電話</th>
                <th>傳真</th>
                <th>公司印章</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companyInfos as $companyInfo)
                <tr>
                    <td>{{ $companyInfo->com_name }}</td>
                    <td>{{ $companyInfo->com_gui_number }}</td>
                    <td>{{ $companyInfo->com_address }}</td>
                    <td>{{ $companyInfo->com_phone }}</td>
                    <td>{{ $companyInfo->com_fax }}</td>
                    <td>
                        <img src="{{ ($companyInfo->com_seal ?? '') == '' ? '' : env('APP_URL').'/uploads/'.$companyInfo->com_seal }}" class="img-fluid" width="150" alt="">
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.companyInfos.destroy', $companyInfo->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.companyInfos.show', [$companyInfo->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.companyInfos.edit', [$companyInfo->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-edit"></i>
                            </a>
                            {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'button',
                                'class' => 'btn btn-danger btn-sm',
                                'onclick' => "return check(this)",
                            ]) !!} --}}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
