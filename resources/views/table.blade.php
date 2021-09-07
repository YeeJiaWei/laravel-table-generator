<x-card-admin>
    <x-validation-errors/>
    <div class="bg-white overflow-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-600 text-white">
            <tr class="uppercase px-1.5 py-3">
                @foreach($columns as $column)
                    @if($column['name'] == 'created_at' || $column['name'] == 'updated_at')
                        <td class="text-center px-1.5 py-3" style="width: 175px">
                            {{ $column['header'] }}
                        </td>
                    @else
                        <th class="text-left px-1.5 py-3">
                            {{ $column['header'] }}
                        </th>
                    @endif
                @endforeach
                @if($enable)
                    <th class="text-center px-1.5 py-3" style="width: 50px">
                        Status
                    </th>
                @endif
                @if($viewable || $editable || $deletable)
                    <th class="text-center px-1.5 py-3" style="width: 150px">
                        Actions
                    </th>
                @endif
            </tr>
            </thead>
            <tbody class="text-gray-700">
            @foreach($items as $item)
                <tr>
                    @foreach($columns as $column)
                        @if($column['name'] == 'created_at' || $column['name'] == 'updated_at')
                            <td class="text-center px-1.5 py-3" style="width: 175px">
                                {{ $item->{$column['name']}->format($column['format']) }}
                            </td>
                        @elseif($column['type'] == 'image')
                            <td class="px-1.5 py-3">
                                @if($item->{$column['name']})
                                    <img src="{{ $column['path'] . '/' . $item->{$column['name']} }}" class="h-10">
                                @else
                                    <img src="{{ $column['no_image'] }}" class="border border-gray-300 h-10">
                                @endif
                            </td>
                        @else
                            <td class="px-1.5 py-3">
                                <div class="{{ $column['class'] }}">
                                    {{ $item->{$column['name']} }}
                                </div>
                            </td>
                        @endif
                    @endforeach
                    @if($enable)
                        <td class="px-3 py-4">
                            <div class="flex justify-center">
                                <x-toggle :active="$item->enable"
                                          :action="route($enable_route_name, $item)"/>
                            </div>
                        </td>
                    @endif
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
        {{ $items->links() }}
    @endif
</x-card-admin>
