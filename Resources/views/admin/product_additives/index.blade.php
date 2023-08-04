@extends('layouts.admin.app')

@section('content')
    @include('retailobjectsrestourant::admin.product_additives.breadcrumbs')
    @include('admin.notify')

    @include('admin.partials.index.top_search_with_mass_buttons', ['mainRoute' => 'product.additives', 'noMultipleActive' => true])

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <th class="width-2-percent"></th>
                    <th class="width-2-percent">{{ __('admin.number') }}</th>
                    <th>{{ __('retailobjectsrestourant::admin.product_additives.title') }}</th>
                    <th>{{ __('retailobjectsrestourant::admin.product_additives.price') }}</th>
                    <th class="width-220">{{ __('admin.actions') }}</th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @forelse($characteristics as $characteristic)
                        <tr class="t-row row-{{$characteristic->id}}">
                            <td class="width-2-percent">
                                <div class="pretty p-default p-square">
                                    <input type="checkbox" class="checkbox-row" name="characteristic[]" value="{{$characteristic->id}}"/>
                                    <div class="state p-primary">
                                        <label></label>
                                    </div>
                                </div>
                            </td>
                            <td class="width-2-percent">{{$i}}</td>
                            <td>{{ $characteristic->title}}</td>
                            <td>{{ number_format($characteristic->price, 2, ',', '')}}</td>
                            <td class="pull-right">
                                <a href="{{ route('admin.product.additives.edit',['id'=>$characteristic->id]) }}" class="btn green" role="button"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('admin.product.additives.delete', ['id'=>$characteristic->id]) }}" class="btn red btn-delete-confirm tooltips" data-toggle="confirmation"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                            <?php $i++; ?>

                    @empty
                        <tr>
                            <td colspan="5" class="no-table-rows">{{ trans('retailobjectsrestourant::admin.product_additives.no_records_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
