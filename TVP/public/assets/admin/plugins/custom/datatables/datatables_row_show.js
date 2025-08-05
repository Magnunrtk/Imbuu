$.fn.dataTable.Api.register('row().show()', function() {
    var page_info = this.table().page.info();
    var new_row_index = this.index();
    var row_position = this.table()
        .rows({ search: 'applied' })[0]
        .indexOf(new_row_index);
    if ((row_position >= page_info.start && row_position < page_info.end) || row_position < 0) {
        return this;
    }
    var page_to_display = Math.floor(row_position / this.table().page.len());
    this.table().page(page_to_display);
    return this;
});