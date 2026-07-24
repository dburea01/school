<em style="font-size: 10px">

    @if ($model->created_by)
    Created by : <strong>{{ $model->created_by }} ({{ $model->created_at }})</strong>
    @endif
    <br>

    @if ($model->updated_by)
    Last update by : <strong>{{ $model->updated_by }} ({{ $model->updated_at }})</strong>
    @endif

    @if ($model->last_request_at)
    Last request at : <strong>{{ $model->last_request_at }}</strong>
    @endif
</em>