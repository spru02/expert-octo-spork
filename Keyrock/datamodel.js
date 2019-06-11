jQuery(document).ready(function() {
    $("#select_type").change(function(){        
        var texte = $(this).val();
        $("#type_text").val(texte);
      });
 });