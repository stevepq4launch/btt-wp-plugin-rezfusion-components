/**
 * Rezfusion table component.
 * @param {Object} options {element: HTMLElement, columns: Array.Object, data: Array.Object}
 * @returns {Object}
 */
function rezfusionTable(options = {}) {

    /**
     * @var {HTMLElement}
     */
    const _element = options.element || null;

    /**
     * @var {Array.Object}
     */
    let _columns = options.columns || [];

    /**
     * @var {Array.Object}
     */
    let _data = options.data || [];

    /**
     * Render table in container.
     */
    const _render = function () {
        _element.innerHTML = '';
        _element.append(_makeTable());
    }

    /**
     * Create a new table header element.
     * @returns {HTMLElement}
     */
    const _makeTableHeader = function () {
        return document.createElement('thead');
    }

    /**
     * Create a new table body element.
     * @returns {HTMLElement}
     */
    const _makeTableBody = function () {
        return document.createElement('tbody');
    }

    /**
     * Create a new table header row element with cells.
     * @returns {HTMLElement}
     */
    const _makeTableHeaderRow = function () {
        let row = document.createElement('tr');
        _columns.forEach(function (column) {
            let th = document.createElement('th');
            th.innerHTML = column.caption;
            row.append(th);
        });
        return row;
    }

    /**
     * Create a new table body row cell.
     * @param {Object} column 
     * @param {Object} data 
     * @returns {HTMLElement}
     */
    const _makeTableBodyRowCell = function (column, data) {
        let cell = document.createElement('td');
        if (typeof column.template === 'function') {
            column.template({
                container: cell,
                column: column,
                data: data,
                value: data[column.field]
            });
        } else {
            let value = '';
            if (typeof data[column.field] !== 'undefined')
                value = data[column.field];
            cell.innerHTML = value;
        }

        return cell;
    }

    /**
     * Create a new table body row.
     * @param {Object} data 
     * @returns {HTMLElement}
     */
    const _makeTableBodyRow = function (data) {
        let row = document.createElement('tr');
        _columns.forEach(function (column) {
            row.append(_makeTableBodyRowCell(column, data));
        });
        return row;
    }

    /**
     * Create a set of table body rows.
     * @returns {Array.HTMLElement}
     */
    const _makeTableBodyRows = function () {
        let rows = [];
        _data.forEach(function (datum) {
            rows.push(_makeTableBodyRow(datum));
        });
        return rows;
    }

    /**
     * Apply options to table element.
     * @param {HTMLElement} table 
     * @param {Object} options 
     */
    const _applyTableOptions = function (table, options) {
        if (options.width)
            table.style.width = options.width;
    }

    /**
     * Create and process a new table.
     * @returns {HTMLElement}
     */
    const _makeTable = function () {
        const table = document.createElement('table');
        table.classList.add('rezfusion-table');
        const head = _makeTableHeader();
        const body = _makeTableBody();
        head.append(_makeTableHeaderRow());
        _makeTableBodyRows().forEach(function (row) {
            body.append(row);
        });
        table.append(head, body);
        _applyTableOptions(table, options);
        return table;
    }

    /**
     * Initialize component.
     */
    const _initialize = function () {
        _render();
    }

    /**
     * Set current data.
     * @param {Array.Object} data 
     * @returns {this}
     */
    const _setData = function (data) {
        _data = data;
        return this;
    }

    /**
     * Get current data.
     * @returns {Array.Object}
     */
    const _getData = function () {
        return _data;
    }

    /**
     * Refresh component.
     * @returns {this}
     */
    const _refresh = function () {
        _render();
        return this;
    }

    /**
     * Return component element.
     * @returns {HTMLElement}
     */
    const _getElement = function () {
        return _element;
    }

    _initialize();

    return {
        getData: _getData,
        element: _getElement,
        setData: _setData,
        getData: _getData,
        refresh: _refresh
    };
}