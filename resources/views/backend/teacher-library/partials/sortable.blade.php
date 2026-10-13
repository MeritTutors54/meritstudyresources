{{--
    Drag-and-drop ordering for a <tbody id="{{ $listId }}"> whose rows carry data-id.
    @include('backend.teacher-library.partials.sortable', ['listId' => 'unitList', 'saveUrl' => route(...), 'buttonId' => 'saveUnitOrder'])
    Shows the Save button once the order changes; posts ids[] in the new order (PATCH).
--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
    (function () {
        const list = document.getElementById(@json($listId));
        const button = document.getElementById(@json($buttonId));
        if (!list || !button || typeof Sortable === 'undefined') return;

        Sortable.create(list, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: () => button.classList.remove('d-none'),
        });

        button.addEventListener('click', function () {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = @json($saveUrl);
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                + '<input type="hidden" name="_method" value="PATCH">';
            list.querySelectorAll('[data-id]').forEach(function (row) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = row.dataset.id;
                form.appendChild(input);
            });
            document.body.appendChild(form);
            form.submit();
        });
    })();
</script>
