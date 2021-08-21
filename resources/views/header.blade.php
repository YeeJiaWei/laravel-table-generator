<div class="flex justify-between items-center">
    {{ __($table_name) }}

    @if($create_route_name)
        <div class="flex items-center">
            <a href="{{ route($create_route_name) }}"
               class="bg-blue-600 rounded-lg text-white px-2.5 py-1">
                <x-svg.add/>
            </a>
        </div>
    @endif
</div>