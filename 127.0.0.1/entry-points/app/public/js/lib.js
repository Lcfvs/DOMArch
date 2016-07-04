void function (global) {
    'use strict';

    var lib;

    lib = Object.create(null);

    lib.middlewares = [
        /*
        function scroll(element, next) {
            var document,
                scrollable,
                scroller,
                listener,
                height,
                diff;

            document = element.ownerDocument;
            scrollable = document.querySelector('.scrollable');

            if (!scrollable) {
                return next();
            }

            scrollable.style.overflow = 'visible';
            scroller = scrollable.querySelector('.scroller');

            if (!scroller) {
                scroller = document.createElement('progress');
                scroller.classList.add('scroller');
                scrollable.appendChild(scroller);
                listener = scroll.bind(null, scrollable, function() {});
                global.addEventListener('resize', listener);
            }

            height = element.offsetHeight;
            diff = element.scrollHeight - height;

            if (diff) {
                scroller.style.height = (height - diff) / 2 + 'px';
            } else {
                scroller.style.height = 0 + 'px';
            }

            console.log(diff)
        },*/
        function() {
            var CSV_PATTERN,
                document,
                FileReader,
                CSVToArray,
                XLSX,
                demethodize,
                forEach,
                fileInfo,
                cancel,
                listen,
                onChange,
                onLoad,
                detect,
                getShortest,
                onLine,
                onValue,
                onReset,
                remove,
                records;

            CSV_PATTERN = /^(?:[,;\t|]|\r?\n|^)(?:[^",;\t|\r\n]+|"(?:[^"]|"")*")?(.)/;
            document = global.document;
            FileReader = global.FileReader;
            CSVToArray = global.CSVToArray;
            XLSX = global.XLSX;

            demethodize = Function.bind.bind(Function.call);
            forEach = demethodize(Array.prototype.forEach);

            fileInfo = {
                type: 'binary'
            };

            cancel = function(event) {
                event.preventDefault();
                event.stopPropagation();

                return false;
            };

            listen = function(input) {
                input.addEventListener('dragover', cancel, false);
                input.addEventListener('change', onChange, false);
                input.addEventListener('drop', onChange, false);
                input.form.querySelector('[type="reset"]')
                    .addEventListener('click', onReset, false);
            };

            onChange = function(event) {
                var file,
                    reader;

                file = (event.dataTransfer || event.target).files[0];

                if (!file) {
                    return cancel(event);
                }

                reader = new FileReader();
                reader.onload = onLoad;
                reader.readAsBinaryString(file);

                return cancel(event);
            };

            onLoad = function(event) {
                var data,
                    workbook,
                    sheetName,
                    table,
                    csv,
                    delimiter,
                    length;

                data = event.target.result;
                table = document.querySelector('.fileReader table');

                try {
                    workbook = XLSX.read(data, fileInfo);
                    sheetName = workbook.SheetNames[0];

                    if (!sheetName) {
                        return;
                    }

                    csv = XLSX.utils.sheet_to_csv(workbook.Sheets[sheetName])
                        .trim();
                } catch (error) {
                    csv = data
                        .trim();
                }

                delimiter = detect(csv);
                
                length = csv.match(new RegExp(delimiter + '+(?=\r?\n|$)', 'g'))
                    .reduce(getShortest).length;

                csv = csv.replace(
                    new RegExp(delimiter + '{' + length + '}(\r?\n|$)', 'g'),
                    '$1'
                );

                try {
                    records = CSVToArray(csv, delimiter).map(onLine, table);
                } catch (error) {
                    // todo error notice
                }

                table.parentNode.querySelector('p').style.height = '0';
                table.style.display = 'block';
            };

            detect = function(csv) {
                var matches;

                matches = csv.match(CSV_PATTERN);

                if (!matches) {
                    return ',';
                }

                return matches[1];
            };

            getShortest = function(previous, current) {
                return previous.length > current.length
                    ? previous : current;
            };

            onLine = function(line) {
                var row,
                    tbody;

                if (!line) {
                    return;
                }

                tbody = this.querySelector('tbody');
                row = tbody.insertRow(tbody.rows.length);


                return line.map(onValue, row);
            };

            onValue = function(value, key) {
                this.insertCell(key).textContent = value;

                return value.length
                    ? value
                    : null;
            };

            onReset = function(event) {
                var form,
                    table,
                    heads,
                    rows;

                records = [];
                form = event.target.form;
                table = form.querySelector('table');
                heads = table.querySelectorAll('thead tr:not(:first-child)');
                rows = table.querySelectorAll('tbody tr');
                table.style.display = 'none';
                form.querySelector('p').style.height = 'auto';

                forEach(heads, remove);
                forEach(rows, remove);
            };

            remove = function(element) {
                element.parentNode.removeChild(element);
            };

            return function(form, next) {
                if (!form.parentNode.classList.contains('fileReader')) {
                    return next();
                }

                listen(form.querySelector('input[type="file"]'));

                next();
            }
        }()
    ];

    global.lib = lib;
}(this);