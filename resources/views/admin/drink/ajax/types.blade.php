<table class="table card-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Color</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($types as $type)
        <tr>
            <td>{{ $type->name }}</td>
            <td><span style="background-color: {{ $type->color }}" class="label">{{ $type->color }}</span></td>
            <td style="width: 130px;">
                <button class="btnEditType btn btn-primary btn-xs"
                        data-id="{{ $type->id }}"
                ><i class="fa fa-edit"></i></button>
                <button class="btnDeleteType btn btn-danger btn-xs"
                        data-id="{{ $type->id }}"
                ><i class="fa fa-remove"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>