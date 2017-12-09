<table id="jquery-datatable-default" class="table table-striped table-bordered bulk_action jquery-datatable">
    <thead>
        <tr>
            <th></th>
            <th>{{__('label.ten')}}</th>
            <th>{{__('label.hinhanh')}}</th>
            <th>{{__('label.luotxem')}}</th>
            <th>{{__('label.ngaytao')}}</th>
            <th>{{__('label.noibat')}}</th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th>{{__('label.ten')}}</th>
            <th>{{__('label.hinhanh')}}</th>
            <th>{{__('label.luotxem')}}</th>
            <th>{{__('label.ngaytao')}}</th>
            <th>{{__('label.noibat')}}</th>
            <th>{{__('label.hienthi')}}</th>
            <th>{{__('label.thaotac')}}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach($items as $k=>$v)
        <tr>
            <td>
            <th><input type="checkbox" class="flat"></th>
            </td>
            <td>{{$v->name}}</td>
            <td></td>
            <td>{{$v->views}}</td>
            <td>{{ Carbon\Carbon::parse($v->created_at)->format('d-m-Y h:i:s') }}</td>
            <td>
                @php
                $visibility = $v->highlight==1?'checked':'';
                @endphp
                <input type="checkbox" data-table="{{@$v->tbl }}" 
                       data-id="{{@$v->id}}" data-field="highlight" class="js-switch js-switch-ajax" 
                       {{$visibility}}/>
            </td>
            <td>
                @php
                $visibility = $v->display==1?'checked':'';
                @endphp
                <input type="checkbox" data-table="{{@$v->tbl }}" 
                       data-id="{{@$v->id}}" data-field="display" class="js-switch js-switch-ajax" 
                       {{$visibility}}/>
            </td>
            <td>
                <a href="{{route('admin_article_edit',[$type,$v->id])}}" class="btn btn-default"><i class="fa fa-edit"></i></a>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>