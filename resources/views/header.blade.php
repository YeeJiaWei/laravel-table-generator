<div class="flex justify-between items-center">
    {{ __($table_name) }}

    @if($create_route_name)
        <div class="flex items-center">
            <a href="{{ route($create_route_name) }}"
               class="bg-blue-600 rounded-lg p-2">
                <x-blade-icon::create class="w-5 h-5 text-white"/>
            </a>
        </div>
    @endif
</div>