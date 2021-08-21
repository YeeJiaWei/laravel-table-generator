<x-card-admin>
    <x-validation-errors/>
    <div class="bg-white overflow-auto">
        <table class="min-w-full bg-white text-sm">
            <thead class="bg-gray-600 text-white">
            <tr class="uppercase">
                @foreach($columns as $column)
                    <th class="text-left py-3 px-4">
                        {{ $column['header'] }}
                    </th>
                @endforeach
                @if($enable)
                    <th class="text-center py-3 px-4" style="width: 50px">
                        Status
                    </th>
                @endif
                @if($viewable || $editable || $deletable)
                    <th class="text-center py-3 px-4" style="width: 150px">
                        Actions
                    </th>
                @endif
            </tr>
            </thead>
            <tbody class="text-gray-700">
            @foreach($items as $item)
                <tr>
                    @foreach($columns as $column)
                        <td class="text-left px-3 py-4">
                            <div class="{{ $column['class'] }}">
                                @if($column['name'] == 'created_at' || $column['name'] == 'updated_at')
                                    {{ $item->{$column['name']}->format($column['format']) }}
                                @elseif($column['type'] == 'img')
                                    <img src="{{ $item->{$column['name']} }}" class="w-16">
                                @else
                                    {{ $item->{$column['name']} }}
                                @endif
                            </div>
                        </td>
                    @endforeach
                    @if($enable)
                        <td class="px-3 py-4">
                            <div class="flex justify-center">
                                <x-toggle :active="$item->enable"
                                          :action="route($enable_route_name, $item)"/>
                            </div>
                        </td>
                    @endif
                    @if($viewable || $editable)
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
