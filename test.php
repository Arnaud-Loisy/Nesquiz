<!doctype html>
 
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title>test</title>
  <link rel="stylesheet" href="..\styles\jquery-ui.css"/>
  <script src="..\scripts\jquery-2.0.0.js"></script>
  <script src="..\scripts\jquery-ui.js"></script>
  <link rel="stylesheet" href="..\styles\theme.css"/>
  
  <script src="..\scripts\jquery.appendGrid-1.1.0.js"></script>
  <link rel="stylesheet" href="..\styles\jquery.appendGrid-1.1.0.css"/>
  <link rel="stylesheet" media="screen" href="http://openfontlibrary.org/face/earthbound" rel="stylesheet" type="text/css"/>
  
  
  
  
  <script>
$(function () {
    // Initialize appendGrid
    $('#tblAppendGrid').appendGrid({
        caption: 'My CD Collections',
        initRows: 1,
        columns: [
                { name: 'Album', display: 'Album', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px' }, onChange: function (evt, rowIndex) { alert('You have changed the value of `Album` at row ' + rowIndex); } },
                { name: 'Artist', display: 'Artist', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '100px'} },
                { name: 'Year', display: 'Year', type: 'text', ctrlAttr: { maxlength: 4 }, ctrlCss: { width: '40px'} },
                { name: 'Origin', display: 'Origin', type: 'select', ctrlOptions: { 0: '{Choose}', 1: 'Hong Kong', 2: 'Taiwan', 3: 'Japan', 4: 'Korea', 5: 'US', 6: 'Others'} },
                { name: 'Poster', display: 'With Poster?', type: 'checkbox', onClick: function (evt, rowIndex) { alert('You have clicked on the `With Poster?` at row ' + rowIndex); } },
                { name: 'Price', display: 'Price', type: 'text', ctrlAttr: { maxlength: 10 }, ctrlCss: { width: '50px', 'text-align': 'right' }, value: 0 }
            ],
        initData: [
                { 'Album': 'Dearest', 'Artist': 'Theresa Fu', 'Year': '2009', 'Origin': 1, 'Poster': true, 'Price': 168.9 },
                { 'Album': 'To be Free', 'Artist': 'Arashi', 'Year': '2010', 'Origin': 3, 'Poster': true, 'Price': 152.6 },
                { 'Album': 'Count On Me', 'Artist': 'Show Luo', 'Year': '2012', 'Origin': 2, 'Poster': false, 'Price': 306.8 },
                { 'Album': 'Wonder Party', 'Artist': 'Wonder Girls', 'Year': '2012', 'Origin': 4, 'Poster': true, 'Price': 108.6 },
                { 'Album': 'Reflection', 'Artist': 'Kelly Chen', 'Year': '2013', 'Origin': 1, 'Poster': false, 'Price': 138.2 }
            ]
    });
    $('#btnGetCount').button().click(function () {
        alert('Total number of rows = ' + $('#tblAppendGrid').appendGrid('getRowCount'));
    });
    $('#btnGetValue').button().click(function () {
        // Get the row count
        var rowCount = $('#tblAppendGrid').appendGrid('getRowCount');
        // Check the number of row in grid
        if (rowCount <= 1) {
            alert('Warning: Row 2 is not found');
        } else {
            // Row index is start from 0. So, index=2 means the second row
            alert($('#tblAppendGrid').appendGrid('getCellValue', 'Album', 1));
        }
    });
    $('#btnSetValue').button().click(function () {
        // Get the row count
        var rowCount = $('#tblAppendGrid').appendGrid('getRowCount');
        // Check the number of row in grid
        if (rowCount <= 2) {
            alert('Warning: Row 3 is not found');
        } else {
            // Row index is start from 0. So, index=2 means the third row
            $('#tblAppendGrid').appendGrid('setCellValue', 'Price', 2, '9999.9');
            alert('Value of `Price` changed!!');
        }
    });
    $('#btnAddRow').button().click(function () {
        // Get the row count
        var rowCount = $('#tblAppendGrid').appendGrid('getRowCount');
        // Check the number of row in grid
        if (rowCount <= 3) {
            alert('Warning: Row 4 is not found');
        } else {
            // Row index is start from 0. So, index=3 means the forth row
            $('#tblAppendGrid').appendGrid('insertRow', 1, 3);
            alert('New row inserted!!');
        }
    });
    $('#btnRemoveRow').button().click(function () {
        // Get the row count
        var rowCount = $('#tblAppendGrid').appendGrid('getRowCount');
        // Check the number of row in grid
        if (rowCount <= 1) {
            alert('Warning: Row 2 is not found');
        } else {
            // Row index is start from 0. So, index=1 means the second row
            $('#tblAppendGrid').appendGrid('removeRow', 1);
            alert('Row 2 removed!!');
        }
    });
});
</script>

</head>
<body>
<table id="tblAppendGrid">
</table>
</body>
  
  </html>
  