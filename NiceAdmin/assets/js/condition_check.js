function checkSelect() {
    var selectElement = document.getElementById("depenses_type-id");
    var inputElement = document.getElementById("quantite-id");

    if (selectElement.value != "produits" ) {
        inputElement.value="1";
        inputElement.disabled = true;

    } else {
//        inputElement.disabled = !inputElement.disabled;
//        inputElement.reset();
        inputElement.disabled =false;

    }
}

function handleClick_salaire(condition) {
    var inputElement = document.getElementById("reste-id");
    if(condition.value=="no"){
        inputElement.disabled=true;
        
    }else{
        inputElement.disabled=false;
        

    } 
}

function handleClick_epargne(condition) {
    var inputElement = document.getElementById("reste-id");
    if(condition.value=="no"){
        inputElement.disabled=true;
        
    }else{
        inputElement.disabled=false;
        

    } 
}