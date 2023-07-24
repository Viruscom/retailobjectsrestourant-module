<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.retail-objects-restaurants.index') }}" class="text-black">@lang('retailobjectsrestourant::admin.restaurants.index')</a>
        </li>
        @if(url()->current() === route('admin.retail-objects.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.retail-objects-restaurants.create') }}" class="text-purple">{{ __('retailobjectsrestourant::admin.restaurants.create') }}</a>
            </li>
        @elseif(Request::segment(3) !== null && url()->current() === route('admin.retail-objects-restaurants.edit', ['id' => Request::segment(3)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.retail-objects-restaurants.edit', ['id' => Request::segment(3)]) }}" class="text-purple">{{ __('retailobjectsrestourant::admin.restaurants.edit') }}</a>
            </li>
        @endif
    </ul>
</div>
