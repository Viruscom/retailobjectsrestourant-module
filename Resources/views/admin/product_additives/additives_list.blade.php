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
                    <li><span>{{ $productAdditive->title }}</span><span>{{ $productAdditive->price }}</span></li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-warning no-selected-additives-list">Няма намерени добавки</div>
        @endif
        <hr>
        <br>
        <div class="row">
            <h5>Избрани добавки</h5>
        </div>
        @if(empty($selectedAdditives))
            <div class="row">
                <div class="alert alert-warning no-selected-additives-list">Няма избрани добавки</div>
            </div>
        @endif
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
                    <li><span>{{ $productAdditive->title }}</span><span>{{ $productAdditive->price }} <span class="plus-icon"><i class="fas fa-plus"></i></span></span></li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-warning no-selected-without-list">Няма избрани добавки</div>
        @endif
        <hr>
        <br>
        <div class="row">
            <h5>Избрани добавки</h5>
        </div>
        @if(empty($selectedAdditivesWithoutList))
            <div class="row">
                <div class="alert alert-warning no-selected-additives-list">Няма избрани добавки</div>
            </div>
        @endif
        <ul id="selectedWithoutList" class="selected-additives-list form-group hidden"></ul>
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
    var productAdditives  = <?php echo isset($productAdditives) ? json_encode($productAdditives) : '[]'; ?>;
    var selectedAdditives = <?php echo isset($selectedAdditives) ? json_encode($selectedAdditives) : '[]'; ?>;

    function createAdditiveListItem(additive, listId, selectedListId) {
        var li   = $('<li>').text(additive.title + ' - ' + additive.price).data('id', additive.id);
        var icon = $('<i>').addClass(listId === 'additivesList' ? 'fas fa-plus' : 'fas fa-minus');
        li.append(icon);

        // Добавете събитие за кликване върху добавката
        li.on('click', function () {
            var inputName = listId === 'additivesList' ? 'additive_id[]' : 'without_additive_id[]';
            if ($(this).parent().attr('id') === selectedListId) {
                // Премахнете скритото поле от формуляра
                $('#input-' + inputName + '-' + $(this).data('id')).remove();

                // Премахнете добавката от списъка с избрани и я добавете в първоначалния списък
                $(this).remove();
                $('#' + listId).append(this);
            } else {
                // Създайте нов input елемент във формуляра с подходящите стойности
                var input = $('<input>').attr('type', 'hidden').attr('name', inputName).val($(this).data('id')).attr('id', 'input-' + inputName + '-' + $(this).data('id'));
                $('#productForm').append(input);

                // Премахнете добавката от първоначалния списък и я добавете в списъка с избрани
                $(this).remove();
                $('#' + selectedListId).append(this);
            }
        });

        $('#' + listId).append(li);
    }

    // Попълнете списъците с добавките
    $.each(productAdditives, function (i, additive) {
        createAdditiveListItem(additive, 'additivesList', 'selectedAdditivesList');
        createAdditiveListItem(additive, 'withoutList', 'selectedWithoutList');
    });

    // Добавете функционалност за търсене
    $.each(['searchAdditives', 'searchWithout'], function (i, inputId) {
        $('#' + inputId).on('input', function () {
            var search     = $(this).val().toLowerCase();
            var list       = $(this).next().next(); // прескачаме дива за съобщението
            var noItemsDiv = $(this).next(); // дива за съобщението
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
    });

    // Проверка за празни списъци с избрани добавки
    $.each(['selectedAdditivesList', 'selectedWithoutList'], function (i, listId) {
        var list       = $('#' + listId);
        var noItemsDiv = list.next();
        noItemsDiv.toggle(!list.children().length);
    });
</script>
