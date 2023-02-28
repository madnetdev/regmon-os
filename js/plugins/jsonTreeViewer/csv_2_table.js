/**
 * Converts a CSV string to object with rows and header
 * @param   {String} sCSV    A CSV string
 * @param   {Object} options {
 *                         separator: string "The CSV col selerator" [";"]
 *                         hasHeader: bool [true]
 *                         headerPrefix: string ["COL]  }
 * @returns {Object} {
 * headers: array of headers,
 * rows: array of rows (including header)
 *  }
 */
function convertToArray(sCSV, options) {
	var result = {
			headers: null,
			rows: null
		},
		firstRowAt = 0,
		tds,
		first,
		cols;
	options = options || {};
	/*options = $.extend(options, {
		separator: ",", //";"
		hasHeader: true,
		headerPrefix: "COL"
	});*/
	options = $.extend({
		separator: ",", //";"
		hasHeader: true,
		headerPrefix: "COL"
	}, options);

	// Create header
	tds = sCSV.split("\x0a");
	first = tds[0].split(options.separator);
	if (options.hasHeader) {
		result.headers = first;
		result.headers = result.headers.map(function(header) {
			return header.replace(/\//g, "_");
		});
		firstRowAt = 1;
	} else {
		result.headers = first.map(function(header, i) {
			return options.headerPrefix + i;
		});
	}

	// Create rows
	cols = result.headers.length;
	result.rows = tds.map(function(row, i) {
		return row.split(options.separator);	
	});
	return result;
}

function tag(element, value) {
	return "<" + element + ">" + value + "</" + element + ">";
}

function toHTML(arr) {
	var sTable = "<table class=\"table table-striped\"><thead>";
	arr.map(function(row, i) {
		//console.log(row,i);
		let new_table = false; //Polar(CSV) has 2 tables
		if (row[0] == 'Sample rate' && row[1] == 'Time') {
			new_table = true;
			sTable += "</tbody></table>";
			sTable += "<table class=\"table table-striped\"><thead>";
		}
		
		var sRow = "";
		if (row.length != 1) {
			row.map(function(cell, ii) {
				let tagname = "td";
				if (i === 0 || new_table) {
					tagname = "th";
				}
				sRow += tag(tagname, cell);
			});

			sTable += tag("tr", sRow) + ((i === 0 || new_table) ? "</thead><tbody>" : "");
		}
	});
	return sTable + "</tbody></table>";
}

function csvToHtml($source, $output, options) {
	var sCSV = $source.val();
	var	result = convertToArray(sCSV, options || {});
	//console.log(result);
	$output.html(toHTML(result.rows));
}

function csvToHtml_QueryCSV($source, $output, separator) {
	var sCSV = $source.val();
	var	result = $.csv.toArrays(sCSV, {separator:separator});
	//console.log(result);
	$output.html(toHTML(result));
}

// This is how you can use the code
//csvToHtml($source, $output);