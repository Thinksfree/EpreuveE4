$(document).ready(function() {
    $('#btn_medoc').click(function(){
        var ligneTab = ' <tr>'
        var ligneTab = ligneTab + '<td><input required type = "text" class="form-control" name="nom[]"/>'
        var ligneTab = ligneTab + '</td><td><input required type = "text" class="form-control" name="quantite[]"/></td>'
        var ligneTab = ligneTab + '<td><span class="btn btn-danger active">X</span></td></tr>';
        $('#tableau').append(ligneTab);
    });
 
});


