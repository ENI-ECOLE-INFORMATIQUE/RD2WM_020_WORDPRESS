jQuery(document).ready(function(){

    jQuery('#ajouterBlague').click(function (){
        var blague=jQuery('#ajout-nomBlague').val().trim();
        var description=jQuery('#ajout-descriptionBlague').val().trim();

        if(blague=='') jQuery('#Mg-nomBlague-error').show();
        else jQuery('#Mg-nomBlague-error').hide();

        if(description=='') jQuery('#Mg-descriptionBlague-error').show();
        else jQuery('#Mg-descriptionBlague-error').hide();

        if((blague!='')&&(description!='')) jQuery('form').submit();
    });
});