<div class="breadcrumbs">
    <ul>
        <li>
            <a href="{{ route('admin.index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.product.additives.index') }}" class="text-black">{{ __('retailobjectsrestourant::admin.product_additives.index') }}</a>
        </li>
        @if(url()->current() === route('admin.product.additives.create'))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.product.additives.create') }}" class="text-purple">{{ __('retailobjectsrestourant::admin.product_additives.create') }}</a>
            </li>
        @elseif(Request::segment(4) !== null && url()->current() === route('admin.product.additives.edit', ['id' => Request::segment(4)]))
            <li>
                <i class="fa fa-angle-right"></i>
                <a href="{{ route('admin.product.additives.edit', ['id' => Request::segment(4)]) }}" class="text-purple">{{ __('retailobjectsrestourant::admin.product_additives.edit') }}</a>
            </li>
        @endif
    </ul>
</div>
