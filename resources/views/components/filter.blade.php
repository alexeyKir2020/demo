<form class="filter row">

    <a class="fixed-action-btn btn-floating btn-large purple sidenav-trigger filter__trigger" href="#" data-target="filter" class="">
        <i class="mdi"></i>
    </a>

    <div id="filter" class="filter__container sidenav">
        <script>
            var filter = [];
        </script>

        <h4 class="filter__title">@lang("items.filter")</h4>

        <div class="filter__content">
            @foreach($filters['layout'] as $filter)

                <div class="col xs12">
                    <script>
                        filter['{{ $filter['parameter'] }}'] = JSON.parse('{!! $filter['items']->toJson() !!}'.replace(/:(\d+)([,\}])/g, ':"$1"$2')).map(({ name: label, id: value, ...rest }) => ({ label,  value, ...rest }));
                        console.log(filter['{{ $filter['parameter'] }}'])
                    </script>
                    <x-dynamic-component
                        :component="$filter['view']"
                        :parameter="$filter['parameter']"
                        :placeholder="$filter['placeholder']"
                        :modifiers="$filter['modifiers']"
                        :entity="$entity"
                        :label="$filter['name']"
                        :items="$filter['items'] ?? ''"
                    />
                </div>

            @endforeach
        </div>
    </div>
</form>
