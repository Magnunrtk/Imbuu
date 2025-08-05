"use strict";

function initLightboxImagePreview(datatableId) {
    $(datatableId + ' tbody tr [data-kt-datatable-lightbox="button"]').unbind().bind('click', function (e) {
        e.preventDefault();
        $(this).blur();
        $(this).tooltip("hide");
        this.disabled = true;
        this.setAttribute("data-kt-indicator", "on");
        const rowData = $(this).closest('table').DataTable().row($(this).closest('tr')).data();
        showPreviewImageInLightbox(this, rowData);
    });
}

function handleSelectAllCheckbox(datatable, datatableId, selector, callback) {
    let selectAllCheckbox = document.querySelector('[data-' + selector + '="checkboxAll"]');
    $(datatableId).on('page.dt', function () {
        updateSelectAllCheckbox(datatable, selector);
        callback && callback();
    });
    $(selectAllCheckbox).on('click', function () {
        let checkboxesOnPage = datatable.rows({page: 'current'});
        let checkboxState = this.checked;
        checkboxesOnPage.nodes().to$().each(function (index) {
            let checkbox = $(this).find('[data-' + selector + '="checkbox"]');
            checkbox.prop('checked', checkboxState);
            if (checkboxState) {
                checkbox.parents('tr').addClass('bg-light');
            } else {
                checkbox.parents('tr').removeClass('bg-light');
            }
        });
        callback && callback();
    });
}

function initSelectCheckboxes(datatable, datatableId, selector, callback) {
    $(datatableId + ' tbody tr [data-' + selector + '="checkbox"]').unbind().bind('click', function () {
        let row = $(this).parents('tr');
        if (!row.hasClass('bg-light')) {
            row.addClass('bg-light');
        } else {
            row.removeClass('bg-light');
        }
        updateSelectAllCheckbox(datatable, selector);
        callback && callback();
    });
}

function updateSelectAllCheckbox(datatable, selector) {
    let checkboxesOnPage = datatable.rows({page: 'current'}).count();
    let selectedRows = datatable.rows('.bg-light', {page: 'current'}).count();
    let selectAllCheckbox = document.querySelector('[data-' + selector + '="checkboxAll"]');
    selectAllCheckbox.checked = checkboxesOnPage === selectedRows;
}

function handlePageLengthInToolbar(datatable, pageLengthSelector) {
    let pageLengthSelect2 = document.querySelector(pageLengthSelector);
    datatable.page.len($(pageLengthSelect2).val()).draw();
    $(pageLengthSelect2).on('change', function () {
        datatable.page.len($(pageLengthSelect2).val()).draw();
    });
}

function handleSearchDatatable(datatable, inputSelector, clearSelector) {
    let searchInput = document.querySelector(inputSelector);
    let searchClear = document.querySelector(clearSelector);
    searchInput.addEventListener('input', function (e) {
        datatable.search(e.target.value).draw();
        if(searchInput.value !== '') {
            if (searchClear.classList.contains('d-none')) {
                searchClear.classList.remove('d-none');
            }
        } else {
            if (!searchClear.classList.contains('d-none')) {
                searchClear.classList.add('d-none');
            }
        }
    });
    handleResetSearchDatatable(datatable, inputSelector, clearSelector);
}

function handleResetSearchDatatable(datatable, inputSelector, clearSelector) {
    let searchInput = document.querySelector(inputSelector);
    let searchClear = document.querySelector(clearSelector);
    searchClear.addEventListener('click', function (e) {
        searchInput.value = '';
        datatable.search(searchInput.value).draw();
        searchClear.classList.add('d-none');
    });
}

function handleReloadDatatable(reloadSelector) {
    let reloadDtButton = document.querySelector(reloadSelector);
    reloadDtButton.addEventListener('click', function (e) {
        executeReloadDatatable(reloadSelector);
    });
}

function executeReloadDatatable(reloadSelector) {
    let reloadDtButton;
    if (reloadSelector !== undefined) {
        reloadDtButton = document.querySelector(reloadSelector);
        reloadDtButton.disabled = true;
        reloadDtButton.setAttribute("data-kt-indicator", "on");
    }
    let dT = $('.table:visible').DataTable();
    dT.ajax.reload(function () {
        let checkboxAll = $('.table:visible').find('.form-check-input');
        checkboxAll.prop('checked', false);
        if (reloadSelector !== undefined) {
            reloadDtButton.removeAttribute("data-kt-indicator");
            reloadDtButton.disabled = false;
        }
    }, false);
}

function refreshToolTips() {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    })
}

function jobReprint(isReprint = false) {
    if (isReprint) {
        return '<span class="badge badge-light-danger fw-bolder px-4 py-3">Ja</span>';
    }
    return '<span class="badge badge-light-dark fw-bolder px-4 py-3">Nein</span>';
}

function jobPriority(priority = 'ST', priorityCount) {
    let priorityClass;
    switch (priority) {
        case 'ST':
            priorityClass = 'success';
            break;
        case 'EX':
            priorityClass = 'warning';
            break;
        case 'ON':
            priorityClass = 'danger';
            break;
    }
    return '<span class="badge badge-light-' + priorityClass + ' fw-bolder px-4 py-3">' +
        '' + (priorityCount !== undefined ? priorityCount + ' ' : ' ') + priority + '</span>';
}
