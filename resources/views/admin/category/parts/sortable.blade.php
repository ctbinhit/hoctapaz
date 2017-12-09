

 @isset($items_cate)
    <div class="dd" id="sortable_categories">
        <ol class="dd-list">
            {!!$UI->category_initSortable($items_cate,$items_cate_data)!!}
        </ol>
    </div>
    @endisset
    <div class="row">
        <div class="col-md-12" id="jquery-status-sortable">

        </div>
    </div>