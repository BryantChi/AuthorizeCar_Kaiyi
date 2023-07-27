<div class="table-responsive">
    <table class="table table-hover" id="authorizeStatuses-table">
        <thead>
            <tr>
                <th>狀態名稱</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authorizeStatuses as $authorizeStatus)
                <tr>
                    <td>{{ $authorizeStatus->status_name }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.authorizeStatuses.destroy', $authorizeStatus->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.authorizeStatuses.show', [$authorizeStatus->id]) }}"
                                class='btn btn-default'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.authorizeStatuses.edit', [$authorizeStatus->id]) }}"
                                class='btn btn-default'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger',
                                'onclick' => 'return check(this)',
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    function check(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(e).submit();
            }
        })
    }
</script>
