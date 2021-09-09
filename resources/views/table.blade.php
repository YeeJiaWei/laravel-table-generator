<x-table-generator::card>
    <x-validation-errors/>
    <div class="bg-white overflow-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-600 text-white">
            <tr class="uppercase px-1.5 py-3">
                @foreach($columns as $column)
                    @if(in_array(\YeeJiaWei\TableGenerator\Traits\SortableColumn::class,class_uses($column))
                        && $column->sortable)
                        <th class="px-1.5 py-3">
                            <div class="flex justify-center">
                                {{ $column->header }}
                                <a href="{{ request()->url() . '?' . $column->query }}"
                                   class="pl-1">
                                    @if(request()->query('order') == 'asc'
                                        && request()->query('orderBy') == $column->name)
                                        &#9660;
                                    @elseif(request()->query('order') == 'desc'
                                            && request()->query('orderBy') == $column->name)
                                        &#9650;
                                    @else
                                        &#9650;
                                        &#9660;
                                    @endif
                                </a>
                            </div>
                        </th>
                    @else
                        <th class="text-center px-1.5 py-3">
                            {{ $column->header }}
                        </th>
                    @endif
                @endforeach
                @if($viewable || $editable || $deletable || $hasSearchableColumn)
                    <th class="text-center px-1.5 py-3" style="width: 150px">
                        Actions
                    </th>
                @endif
            </tr>
            </thead>
            <tbody class="text-gray-700">
            @if($hasSearchableColumn)
                <form>
                    <tr>
                        @foreach(request()->query() as $key => $query)
                            @if($key == 'page' || $key == 'perPage' || $key == 'order' || $key == 'orderBy')
                                <input type="hidden" name="{{ $key }}" value="{{ $query }}">
                            @endif
                        @endforeach
                        @foreach($columns as $column)
                            @if($column instanceof \YeeJiaWei\TableGenerator\Column\ImageColumn)
                                <th class="px-1.5 py-3">
                                </th>
                            @elseif($column instanceof \YeeJiaWei\TableGenerator\Column\TextColumn)
                                @if($column->searchable)
                                    <th class="px-1.5 py-3">
                                        <input type="text" class="w-full px-1 py-1 rounded-lg outline-none"
                                               name="{{ $column->name }}"
                                               value="{{ request()->query($column->name) }}">
                                    </th>
                                @else
                                    <th></th>
                                @endif
                            @elseif($column instanceof \YeeJiaWei\TableGenerator\Column\DateTimeColumn)
                                <th class="text-center px-1.5 py-3">

                                </th>
                            @elseif($column instanceof \YeeJiaWei\TableGenerator\Column\EnableColumn)
                                <th class="px-1.5 py-3">
                                    <select name="enable" class="w-full px-1 py-1 rounded-lg outline-none">
                                        <option></option>
                                        <option @if(request()->query('enable') != '' && request()->query('enable') == 0) selected
                                                @endif
                                                value="0">
                                            Disabled
                                        </option>
                                        <option @if(request()->query('enable') != '' && request()->query('enable') == 1) selected
                                                @endif
                                                value="1">
                                            Enabled
                                        </option>
                                    </select>
                                </th>
                            @endif
                        @endforeach
                        <th>
                            <button class="bg-green-500 text-white rounded-lg px-5 py-2">Search</button>
                        </th>
                    </tr>
                </form>
            @endif
            @foreach($items as $item)
                <tr>
                    @foreach($columns as $column)
                        @if($column instanceof \YeeJiaWei\TableGenerator\Column\ImageColumn)
                            <td class="px-1.5 py-3">
                                @if($item->{$column->name})
                                    <img src="{{ $column->path . '/' . $item->{$column->name} }}" class="h-10">
                                @else
                                    <img src="{{ $column->default_path }}" class="border border-gray-300 h-10">
                                @endif
                            </td>
                        @elseif($column instanceof \YeeJiaWei\TableGenerator\Column\TextColumn)
                            <td class="text-center px-1.5 py-3">
                                {{ $item->{$column->name} }}
                            </td>
                        @elseif($column instanceof \YeeJiaWei\TableGenerator\Column\DateTimeColumn)
                            <td class="text-center px-1.5 py-3" style="width: 175px">
                                {{ $item->{$column->name}->format($column->format) }}
                            </td>
                        @elseif($column instanceof \YeeJiaWei\TableGenerator\Column\EnableColumn)
                            <td class="px-3 py-4" style="width: 125px">
                                <div class="flex justify-center">
                                    <x-toggle :active="$item->enable"
                                              :action="route($column->routeName, $item)"/>
                                </div>
                            </td>
                        @endif
                    @endforeach
                    @if($viewable || $editable || $deletable)
                        <td class="px-3 py-4" style="width: 150px">
                            <div class="flex justify-around">
                                @if($viewable)
                                    <x-btn.view :href="route($view_route_name, $item)"/>
                                @endif
                                @if($editable)
                                    <x-btn.edit :href="route($edit_route_name, $item)"/>
                                @endif
                                @if($deletable)
                                    <x-btn.delete :href="route($delete_route_name, $item)"/>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $items->appends(request()->query())->links('table-generator::pagination')->with(compact('pagination')) }}
    @endif
</x-table-generator::card>
