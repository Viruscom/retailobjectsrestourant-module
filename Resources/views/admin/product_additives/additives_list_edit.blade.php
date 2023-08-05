<div class="product-additives-wrapper">
    <div class="col-md-12">
        <h3 class="m-t-40 m-b-20"> Добавки</h3>
    </div>
    <div class="col-md-6 col-xs-12 p-r-30">
        <div class="row">
            <h5>Списък ДОБАВКИ</h5>
        </div>
        <div class="form-group ">
            <input class="form-control width-p100" type="text" id="searchAdditives" placeholder="Търсене...">
        </div>
        @if(!empty($productAdditives))
            <ul id="additivesList" class="additives-list form-group">
                @foreach($productAdditives as $productAdditive)
                    <li data-index="{{$productAdditive->id}}"><span>{{ $productAdditive->title }}</span><span>{{ $productAdditive->price }}</span></li>
                @endforeach
            </ul>
        @endif
        <hr>
        <br>
        <div class="row">
            <h5>Избрани добавки</h5>
        </div>
        <div class="form-group ">
            <input class="form-control width-p100" type="text" id="searchSelectedAdditivesList" placeholder="Търсене...">
        </div>
        <ul id="selectedAdditivesList" class="selected-additives-list form-group"></ul>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="row">
            <h5>Списък БЕЗ</h5>
        </div>
        <div class="form-group ">
            <input class="form-control width-p100" type="text" id="searchWithout" placeholder="Търсене...">
        </div>
        @if(!empty($productAdditives))
            <ul id="withoutList" class="additives-list form-group">
                @foreach($productAdditives as $productAdditive)
                    <li data-index="{{ $productAdditive->id }}"><span>{{ $productAdditive->title }}</span><span>{{ $productAdditive->price }}</span></li>
                @endforeach
            </ul>
        @endif
        <hr>
        <br>
        <div class="row">
            <h5>Избрани добавки</h5>
        </div>
        <div class="form-group ">
            <input class="form-control width-p100" type="text" id="searchWithoutSelected" placeholder="Търсене...">
        </div>
        <ul id="selectedWithoutList" class="selected-additives-list form-group"></ul>
    </div>
</div>
<div class="hidden">
    <input type="text" class="selectedAdditives" name="selectedAdditives[]">
    <input type="text" class="selectedAdditivesWithoutList" name="selectedAdditivesWithoutList[]">
</div>
<style>
    .product-additives-wrapper h5 {
        color:       #333;
        font-weight: bold;
    }

    .additives-list, .selected-additives-list {
        min-height:   300px;
        max-height:   400px;
        overflow-y:   auto;
        padding-left: 0px;
        border:       1px solid #cecece;
    }

    .additives-list li, .selected-additives-list li {
        cursor:           pointer;
        padding:          5px;
        border-bottom:    1px solid #3d3d3d38;
        display:          flex;
        justify-content:  space-between;
        align-items:      center;
        background-color: #f8f9fa;
    }

    .additives-list li:hover {
        background-color: #8BC34A;
        color:            #ffffff;
    }

    .selected-additives-list li:hover {
        background-color: #d32f2f;
        color:            #ffffff;
    }

    .additives-list li i, .selected-additives-list li i {
        margin-left: 10px;
    }
</style>

<script>
    var selectionAdditivesListFinal = [];
    var selectedWithoutListFinal    = [];

    document.addEventListener('DOMContentLoaded', function () {
        var selectedProductsAdditives        = {!! json_encode($selectedProductsAdditives) !!};
        var selectedWithoutProductsAdditives = {!! json_encode($selectedWithoutProductsAdditives) !!};

        // Избиране на добавките от selectedProductsAdditives
        selectedProductsAdditives.forEach(function (additive) {
            var item = $('#additivesList li[data-index="' + additive.id + '"]');
            addAdditiveToList(item, $('#selectedAdditivesList'), $('#additivesList'), selectionAdditivesListFinal);
        });

        // Избиране на добавките от selectedWithoutProductsAdditives
        selectedWithoutProductsAdditives.forEach(function (additive) {
            var item = $('#withoutList li[data-index="' + additive.id + '"]');
            addAdditiveToList(item, $('#selectedWithoutList'), $('#withoutList'), selectedWithoutListFinal);
        });

        // Тук може да добавите останалите части от вашия код
    });

    function addAdditiveToList(additive, selectedList, initialList, selectedArray) {
        var id = additive.data('index');
        selectedArray.push(id);
        selectedList.append(additive.clone());
        updateHiddenInputs();
        selectedList.children().last().on('click', function () {
            removeAdditiveFromList($(this), selectedList, initialList, selectedArray);
        });
        additive.hide();
    }

    function removeAdditiveFromList(additive, selectedList, initialList, selectedArray) {
        var index      = additive.data('index');
        var arrayIndex = selectedArray.indexOf(index);
        if (arrayIndex > -1) {
            selectedArray.splice(arrayIndex, 1);
        }
        additive.remove();
        initialList.children().filter(function () {
            return $(this).data('index') === index;
        }).show();
        updateHiddenInputs();
    }

    function updateHiddenInputs() {
        $('.selectedAdditives').val(selectionAdditivesListFinal.join(','));
        $('.selectedAdditivesWithoutList').val(selectedWithoutListFinal.join(','));
    }

    function addClassHidden(element) {
        element.addClass('hidden');
    }

    function removeClassHidden(element) {
        element.removeClass('hidden');
    }

    function showElement(element) {
        element.show();
    }

    function hideElement(element) {
        element.hide();
    }

    function isListEmpty(list) {
        return list.children().length <= 0;
    }

    $('#additivesList li').on('click', function () {
        addAdditiveToList($(this), $('#selectedAdditivesList'), $('#additivesList'), selectionAdditivesListFinal);
    });

    $('#selectedAdditivesList li').on('click', function () {
        removeAdditiveFromList($(this), $('#selectedAdditivesList'), $('#additivesList'), selectionAdditivesListFinal);
    });

    $('#withoutList li').on('click', function () {
        addAdditiveToList($(this), $('#selectedWithoutList'), $('#withoutList'), selectedWithoutListFinal);
    });

    $('#selectedWithoutList li').on('click', function () {
        removeAdditiveFromList($(this), $('#selectedWithoutList'), $('#withoutList'), selectedWithoutListFinal);
    });

    function handleSearch(inputId, listId) {
        $(inputId).on('input', function () {
            var search     = $(this).val().toLowerCase();
            var list       = $(listId);
            var noItemsDiv = $(this).next();
            var hasItems   = false;
            $.each(list.children(), function () {
                var text = $(this).text().toLowerCase();
                if (text.includes(search)) {
                    $(this).show();
                    hasItems = true;
                } else {
                    $(this).hide();
                }
            });
            noItemsDiv.toggle(!hasItems);
        });
    }

    handleSearch('#searchWithout', '#withoutList');
    handleSearch('#searchWithoutSelected', '#selectedWithoutList');
    handleSearch('#searchAdditives', '#additivesList');
    handleSearch('#searchSelectedAdditivesList', '#selectedAdditivesList');

</script>
