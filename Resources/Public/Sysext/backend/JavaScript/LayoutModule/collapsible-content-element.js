(function () {
    const collapsedIds = {
        _ids: [],
        _saveIds: function () {
            document.cookie = 'ceCollapsed=' + JSON.stringify(this._ids);
        },
        init: function () {
            this._ids = JSON.parse(document.cookie.split('; ').find((row) => row.startsWith('ceCollapsed'))?.split('=')[1] ?? '[]');
            return this;
        },
        get: function () {
            return this._ids;
        },
        add: function (id) {
            if (this._ids.indexOf(id) >= 0) {
                return;
            }
            this._ids.push(id);
            this._saveIds();
        },
        remove: function (id) {
            let index = this._ids.indexOf(id);
            if ( index >= 0) {
                this._ids.splice(index, 1);
                this._saveIds();
            }
        }
    }
    document.querySelectorAll('.ce-collapse').forEach((el) => {
        el.addEventListener('show.bs.collapse', (e) => {
            const id = e.target.dataset.ceId;
            document.getElementById('ce-header-title-' + id).classList.remove('cec-collapsed');
            collapsedIds.remove(id);
        });
        el.addEventListener('hide.bs.collapse', (e) => {
            const id = e.target.dataset.ceId;
            document.getElementById('ce-header-title-' + id).classList.add('cec-collapsed');
            collapsedIds.add(id);
        });
    })
    collapsedIds.init().get().forEach(id => {
        const toggler = document.getElementById('ce-toggler-' + id);
        if (!toggler) {
            return;
        }
        toggler.classList.add('collapsed');
        toggler.setAttribute('aria-expanded', 'false');
        document.getElementById('ce-header-title-' + id).classList.add('cec-collapsed');
        document.getElementById('ce-collapse-' + id).classList.remove('show');
    });
})();
