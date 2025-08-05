let PROPS = {
    filterContainer: null,
    active: false,
};

var DataTableFilterSystem = function () {

}

DataTableFilterSystem.prototype.setFilterContainerSelector = function (selector) {
    PROPS.filterContainer = document.querySelector(selector);
}

DataTableFilterSystem.prototype.addSelect2ElementToFilter = function (options) {
    let self = this;
    self.createSelect2Element(options);
    if (self.select2OptionExists() && options.unique) {
        return;
    }
    let filterData = self.renderSelect2Option(options);

    const select2 = document.querySelector('[data-kt-table-filter-select2="'+ options.name +'"]');
    if (!self.select2OptionExists(select2, options.name, filterData.id)) {
        const filterOption = new Option(filterData.text, filterData.id, false, false);
        $(select2).append(filterOption).trigger('change');
    }
}

DataTableFilterSystem.prototype.select2OptionExists = function (select2, name, id) {
    let self = this;
    if(!self.select2ElementExists(name)) {
        return false;
    }
    return !!$(select2).find("option[value='" + id + "']").length;
}

DataTableFilterSystem.prototype.select2OptionIsBoolean = function (options) {
    return options.boolean !== undefined && options.boolean;
}

DataTableFilterSystem.prototype.renderSelect2Option = function (options) {
    let self = this;
    let select2Data;
    if (self.select2OptionIsBoolean(options)) {
        select2Data = {
            id: parseInt(options.id) ? 'Ja' : 'Nein',
            text: options.selectText,
        };
    } else {
        select2Data = {
            id: options.id,
            text: options.selectText,
        }
    }
    return select2Data;
}

DataTableFilterSystem.prototype.select2ElementExists = function (name) {
    return $('[data-kt-table-filter-select2="'+ name +'"]').length > 0;
}

DataTableFilterSystem.prototype.createSelect2Element = function (options) {
    let self = this;
    if(self.select2ElementExists(options.name)) {
        return;
    }
    let searchDataAttribute = ''
    if (options.searchInRow) {
        searchDataAttribute = 'data-search-in-row="'+ options.searchInRow +'"';
    }
    $(PROPS.filterContainer).append('<div class="mb-5" data-kt-table-filter="'+ options.name +'">' +
        '<label for="'+ options.name +'" class="form-label fs-5 fw-bold mb-2">'+ options.name +'</label>' +
        '<select class="form-select" data-control="select2" data-kt-table-filter-select2-column="'+ options.columnName +'" ' +
        'data-kt-table-filter-select2="'+ options.name +'" data-placeholder="'+ options.name +'" '+ searchDataAttribute +'></select>' +
        '</div>');
    const select2Element = $('[data-kt-table-filter-select2="'+ options.name +'"]');
    if(options.select2) {
        select2Element.select2(options.select2);
    } else {
        select2Element.select2({
            minimumResultsForSearch: Infinity,
        });
    }

    if (options.select2 && options.select2.availableOptions) {
        const filterOption = new Option('Alle', 'all', true, true);
        select2Element.append(filterOption).trigger('change');
        jQuery.each(options.select2.availableOptions, function(index, item) {
            select2Element.append(
                new Option(item, index, false, false)
            );
        });
        select2Element.trigger('change');
    } else {
        const filterOption = new Option('Alle', 'all', true, true);
        select2Element.append(filterOption).trigger('change');
    }

    select2Element.on('select2:select', function (e) {
        let lastSelected = e.params.data.id;
        let selected = $(e.target).val();
        let indexSelectedAll = selected.indexOf('all');
        if (lastSelected === 'all') {
            return $(this).val('all').trigger("change");
        }
        if(indexSelectedAll !== -1) {
            selected.splice(indexSelectedAll, 1);
            $(this).val(selected).trigger('change');
        }
    });
    select2Element.on('select2:unselect', function (e) {
        let selected = $(e.target).val();
        if (selected.length === 0) {
            $(this).val('all').trigger('change');
        }
        $(this).on('select2:opening', function (ev) {
            ev.preventDefault();
            $(this).off('select2:opening');
        });
    });
}

DataTableFilterSystem.prototype.filterDateElementExists = function (name) {
    return $('[data-kt-table-filter-date="'+ name +'"]').length > 0;
}

DataTableFilterSystem.prototype.addSelect2DateElementToFilter = function (options) {
    let self = this;
    if(self.filterDateElementExists(options.name)) {
        return;
    }
    $(PROPS.filterContainer).append('<div class="mb-5" data-kt-table-filter="'+ options.name +'">' +
        '<label for="'+ options.name +'" class="form-label fs-5 fw-bold mb-2">'+ options.name +'</label>' +
        '<div class="position-relative d-flex align-items-center">' +
        '<span class="svg-icon svg-icon-2 position-absolute mx-4">' +
        '<i class="far fa-calendar-alt"></i>' +
        '</span>' +
        '<input class="form-control form-control-solid ps-12 flatpickr-input" ' +
        'data-kt-table-filter-date-column="'+ options.columnName +'" ' +
        'data-kt-table-filter-date="'+ options.name +'" placeholder="Datum eingrenzen" type="text" readOnly="readonly" ' +
        'autocomplete="off">' +
        '<span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 ' +
        'translate-middle-y lh-1 p-1" data-kt-table-filter-date-clear="'+ options.name +'">\n' +
        '<span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0">\n' +
        '<i class="fas fa-times"></i>\n' +
        '</span>\n' +
        '</span>' +
        '</div>' +
        '</div>');
    const dateRangePickerElement = $('[data-kt-table-filter-date="'+ options.name +'"]');
    if(options.dateRangePicker) {
        dateRangePickerElement.flatpickr(options.dateRangePicker);
    } else {
        dateRangePickerElement.flatpickr({
            locale: "de",
            dateFormat: "d.m.Y",
            mode: "range",
        });
    }
    const dateClearButton = document.querySelector('[data-kt-table-filter-date-clear="'+ options.name +'"]');
    dateClearButton.addEventListener("click", function() {
        let dateInput = document.querySelector('[data-kt-table-filter-date="'+ options.name +'"]')._flatpickr;
        dateInput.clear();
    });
}

DataTableFilterSystem.prototype.setFilterSystem = function (option) {
    if (option) {
        return PROPS.active = true;
    }
    return PROPS.active = false;
}

DataTableFilterSystem.prototype.isFilterSystemActive = function () {
    return PROPS.active;
}
